<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class HealthCheckController extends Controller
{
    /**
     * Basic health check endpoint
     * Returns 200 if application is running
     */
    public function health()
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'service' => 'LegacyLoop Alumni Platform',
        ], 200);
    }

    /**
     * Readiness check endpoint
     * Checks if application is ready to serve traffic
     * Validates: database, redis, and disk space
     */
    public function ready()
    {
        $checks = [];
        $overallStatus = 'ready';

        // Check database connectivity
        try {
            DB::connection()->getPdo();
            $checks['database'] = [
                'status' => 'connected',
                'connection' => config('database.default'),
            ];
        } catch (\Exception $e) {
            $checks['database'] = [
                'status' => 'disconnected',
                'error' => $e->getMessage(),
            ];
            $overallStatus = 'not_ready';
        }

        // Check Redis connectivity
        try {
            Cache::store('redis')->get('health_check_test');
            $checks['redis'] = [
                'status' => 'connected',
                'driver' => 'redis',
            ];
        } catch (\Exception $e) {
            $checks['redis'] = [
                'status' => 'disconnected',
                'error' => $e->getMessage(),
            ];
            $overallStatus = 'not_ready';
        }

        // Check disk space
        try {
            $storagePath = storage_path();
            $freeSpace = disk_free_space($storagePath);
            $totalSpace = disk_total_space($storagePath);
            $usedPercentage = (($totalSpace - $freeSpace) / $totalSpace) * 100;

            $checks['disk'] = [
                'status' => $usedPercentage < 90 ? 'healthy' : 'warning',
                'free_space_gb' => round($freeSpace / 1024 / 1024 / 1024, 2),
                'total_space_gb' => round($totalSpace / 1024 / 1024 / 1024, 2),
                'used_percentage' => round($usedPercentage, 2),
            ];

            if ($usedPercentage >= 95) {
                $overallStatus = 'not_ready';
            }
        } catch (\Exception $e) {
            $checks['disk'] = [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }

        $statusCode = $overallStatus === 'ready' ? 200 : 503;

        return response()->json([
            'status' => $overallStatus,
            'timestamp' => now()->toIso8601String(),
            'checks' => $checks,
        ], $statusCode);
    }

    /**
     * Liveness check endpoint
     * Returns 200 if process is alive
     */
    public function liveness()
    {
        return response()->json([
            'status' => 'alive',
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }
}
