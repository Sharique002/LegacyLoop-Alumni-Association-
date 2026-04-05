<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AlumniController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SuccessStoryController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\NetworkingController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\OrganizationAuthController;
use App\Http\Controllers\Api\OrganizationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Health check endpoints (no authentication required)
Route::get('/health', [HealthCheckController::class, 'health']);
Route::get('/ready', [HealthCheckController::class, 'ready']);
Route::get('/liveness', [HealthCheckController::class, 'liveness']);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public: List of universities for registration dropdown
Route::get('/universities', [OrganizationAuthController::class, 'listUniversities']);

// Organization public routes
Route::prefix('organization')->group(function () {
    Route::post('/register', [OrganizationAuthController::class, 'register']);
    Route::post('/login', [OrganizationAuthController::class, 'login']);
});

// Public data (read-only)
Route::get('/alumni', [AlumniController::class, 'index']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::get('/alumni/statistics', [AlumniController::class, 'statistics']);

Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

Route::get('/stories', [SuccessStoryController::class, 'index']);
Route::get('/stories/{id}', [SuccessStoryController::class, 'show']);

Route::get('/donations', [DonationController::class, 'index']);
Route::get('/donations/statistics', [DonationController::class, 'statistics']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Jobs
    Route::post('/jobs', [JobController::class, 'store']);
    Route::put('/jobs/{id}', [JobController::class, 'update']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
    Route::post('/jobs/{id}/apply', [JobController::class, 'apply']);
    Route::get('/my-applications', [JobController::class, 'myApplications']);
    Route::get('/jobs/{id}/applications', [JobController::class, 'jobApplications']);

    // Events
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::post('/events/{id}/register', [EventController::class, 'register']);
    Route::post('/events/{id}/cancel', [EventController::class, 'cancelRegistration']);
    Route::get('/my-events', [EventController::class, 'myEvents']);

    // Success Stories
    Route::post('/stories', [SuccessStoryController::class, 'store']);
    Route::put('/stories/{id}', [SuccessStoryController::class, 'update']);
    Route::delete('/stories/{id}', [SuccessStoryController::class, 'destroy']);
    Route::post('/stories/{id}/like', [SuccessStoryController::class, 'like']);
    Route::get('/my-stories', [SuccessStoryController::class, 'myStories']);

    // Donations
    Route::post('/donations', [DonationController::class, 'store']);
    Route::get('/my-donations', [DonationController::class, 'myDonations']);

    // Networking
    Route::get('/connections', [NetworkingController::class, 'connections']);
    Route::get('/connection-requests', [NetworkingController::class, 'pendingRequests']);
    Route::post('/connections/send', [NetworkingController::class, 'sendRequest']);
    Route::post('/connections/{id}/accept', [NetworkingController::class, 'acceptRequest']);
    Route::post('/connections/{id}/reject', [NetworkingController::class, 'rejectRequest']);

    // Messages
    Route::get('/messages', [NetworkingController::class, 'messages']);
    Route::get('/messages/{userId}', [NetworkingController::class, 'conversation']);
    Route::post('/messages', [NetworkingController::class, 'sendMessage']);
    Route::delete('/messages/{id}', [NetworkingController::class, 'deleteMessage']);
    Route::get('/messages/unread/count', [NetworkingController::class, 'unreadCount']);

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus']);
        Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole']);
        
        Route::get('/stories/pending', [AdminController::class, 'pendingStories']);
        Route::post('/stories/{id}/approve', [AdminController::class, 'approveStory']);
        Route::post('/stories/{id}/reject', [AdminController::class, 'rejectStory']);
        
        Route::get('/activities', [AdminController::class, 'activities']);
        Route::get('/analytics', [AdminController::class, 'analytics']);
        
        // Admin: Organization management
        Route::get('/organizations', [AdminController::class, 'organizations']);
        Route::post('/organizations/{id}/verify', [AdminController::class, 'verifyOrganization']);
        Route::post('/organizations/{id}/toggle-status', [AdminController::class, 'toggleOrganizationStatus']);
    });
});

// Organization protected routes
Route::middleware(['auth:sanctum', 'organization'])->prefix('organization')->group(function () {
    // Auth
    Route::post('/logout', [OrganizationAuthController::class, 'logout']);
    Route::get('/me', [OrganizationAuthController::class, 'me']);
    Route::put('/profile', [OrganizationAuthController::class, 'updateProfile']);
    Route::post('/change-password', [OrganizationAuthController::class, 'changePassword']);
    
    // Dashboard
    Route::get('/dashboard', [OrganizationController::class, 'dashboard']);
    
    // Alumni management (view only)
    Route::get('/alumni', [OrganizationController::class, 'alumni']);
    Route::get('/alumni/{id}', [OrganizationController::class, 'showAlumni']);
    
    // Event management (requires verified organization)
    Route::middleware(['organization.verified'])->group(function () {
        Route::get('/events', [OrganizationController::class, 'events']);
        Route::post('/events', [OrganizationController::class, 'createEvent']);
        Route::put('/events/{id}', [OrganizationController::class, 'updateEvent']);
        Route::delete('/events/{id}', [OrganizationController::class, 'deleteEvent']);
        Route::get('/events/{id}/attendees', [OrganizationController::class, 'eventAttendees']);
    });
});
