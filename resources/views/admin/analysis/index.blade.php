@extends('admin.layout')
@section('title', 'Analytics Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="content-header" style="margin-bottom: 2rem;">
    <h1 class="page-title" style="margin: 0;">Analytics Dashboard</h1>
    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Overview of your platform's performance.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Stat Cards -->
    <div class="card" style="padding: 1.5rem; border-top: 4px solid var(--primary);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Users</div>
                <div style="font-size: 2rem; font-weight: 700; margin-top: 0.5rem; color: var(--text-primary);">{{ number_format($totalUsers) }}</div>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="ph-fill ph-users"></i>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 1.5rem; border-top: 4px solid var(--success);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Posts</div>
                <div style="font-size: 2rem; font-weight: 700; margin-top: 0.5rem; color: var(--text-primary);">{{ number_format($totalPosts) }}</div>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 12px; background: var(--success-bg); color: var(--success); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="ph-fill ph-article"></i>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 1.5rem; border-top: 4px solid var(--warning);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Categories</div>
                <div style="font-size: 2rem; font-weight: 700; margin-top: 0.5rem; color: var(--text-primary);">{{ number_format($totalCategories) }}</div>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="ph-fill ph-folder"></i>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 1.5rem; border-top: 4px solid #8b5cf6;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Avg. Engagement</div>
                <div style="font-size: 2rem; font-weight: 700; margin-top: 0.5rem; color: var(--text-primary);">{{ $engagement }}</div>
            </div>
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                <i class="ph-fill ph-trend-up"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
        <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Traffic Overview</h3>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <div style="height: 300px; width: 100%;">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trafficChart').getContext('2d');
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#4f46e5';
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $chartLabels !!},
            datasets: [{
                label: 'Page Views',
                data: {!! $chartData !!},
                borderColor: primaryColor,
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: primaryColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                x: { grid: { display: false, drawBorder: false } }
            }
        }
    });
});
</script>
@endsection
