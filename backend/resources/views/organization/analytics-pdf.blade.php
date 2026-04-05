<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report - {{ $organization->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #4f46e5;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .metric-card {
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 5px;
        }
        .metric-value {
            font-size: 32px;
            font-weight: bold;
            color: #4f46e5;
            margin: 5px 0;
        }
        .metric-label {
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #4f46e5;
            font-weight: 600;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:hover {
            background: #f9fafb;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #666;
            font-size: 12px;
        }
        .two-column {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .section {
                page-break-inside: avoid;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
        @media screen {
            body {
                max-width: 210mm;
                margin: 20px auto;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 20px;
                background: white;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Header -->
    <div class="header">
        <h1>Alumni Analytics Report</h1>
        <p><strong>{{ $organization->name }}</strong></p>
        <p>Generated on {{ now()->format('F d, Y') }} at {{ now()->format('h:i A') }}</p>
    </div>

    <!-- Key Metrics -->
    <div class="section">
        <div class="section-title">Key Metrics</div>
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-label">Total Alumni</div>
                <div class="metric-value">{{ number_format($analytics['total_alumni'] ?? 0) }}</div>
                <small style="color: #22c55e;">+{{ $analytics['new_alumni_month'] ?? 0 }} this month</small>
            </div>
            <div class="metric-card">
                <div class="metric-label">Total Events</div>
                <div class="metric-value">{{ $analytics['total_events'] ?? 0 }}</div>
                <small style="color: #666;">{{ $analytics['upcoming_events'] ?? 0 }} upcoming</small>
            </div>
            <div class="metric-card">
                <div class="metric-label">Engagement Rate</div>
                <div class="metric-value">{{ $analytics['engagement_rate'] ?? 0 }}%</div>
                <small style="color: #22c55e;">+{{ $analytics['engagement_change'] ?? 0 }}% vs last month</small>
            </div>
            <div class="metric-card">
                <div class="metric-label">Total Donations</div>
                <div class="metric-value">₹{{ number_format($analytics['total_donations'] ?? 0) }}</div>
                <small style="color: #666;">{{ $analytics['donation_growth'] ?? 0 }}% growth</small>
            </div>
        </div>
    </div>

    <!-- Alumni by Graduation Year -->
    <div class="section">
        <div class="section-title">Alumni by Graduation Year</div>
        <table>
            <thead>
                <tr>
                    <th>Year Range</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = array_sum($analytics['grad_data'] ?? [0, 0, 0, 0]);
                @endphp
                @foreach(($analytics['grad_labels'] ?? []) as $index => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td><strong>{{ $analytics['grad_data'][$index] ?? 0 }}</strong></td>
                    <td>{{ $total > 0 ? round(($analytics['grad_data'][$index] / $total) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Two Column Section -->
    <div class="two-column">
        <!-- Top Companies -->
        <div class="section">
            <div class="section-title">Top Companies</div>
            <table>
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Alumni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($analytics['top_companies'] ?? [] as $company)
                    <tr>
                        <td>{{ $company['name'] }}</td>
                        <td><strong>{{ $company['count'] }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" style="text-align: center; color: #999;">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Top Locations -->
        <div class="section">
            <div class="section-title">Top Locations</div>
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Alumni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($analytics['top_locations'] ?? [] as $location)
                    <tr>
                        <td>{{ $location['name'] }}</td>
                        <td><strong>{{ $location['count'] }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" style="text-align: center; color: #999;">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Growth -->
    <div class="section">
        <div class="section-title">Monthly Growth ({{ now()->year }})</div>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>New Alumni</th>
                </tr>
            </thead>
            <tbody>
                @foreach(($analytics['growth_labels'] ?? []) as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td><strong>{{ $analytics['growth_data'][$index] ?? 0 }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Events -->
    <div class="section">
        <div class="section-title">Recent Events</div>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Attendees</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($analytics['event_labels'] ?? []) as $index => $event)
                <tr>
                    <td>{{ $event }}</td>
                    <td><strong>{{ $analytics['event_data'][$index] ?? 0 }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: #999;">No events found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated by LegacyLoop Alumni Management System</p>
        <p>&copy; {{ now()->year }} {{ $organization->name }}. All rights reserved.</p>
    </div>
</body>
</html>
