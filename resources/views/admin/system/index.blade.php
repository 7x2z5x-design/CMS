@extends('admin.layout')

@section('title', 'System Analysis')

@section('content')
<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6B7B3A" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">System Health</div>
                <div class="stat-number">{{ $systemHealth ?? '98%' }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 0 20 20v-1a9 9 0 0 1 20 20z"></path>
                    <polyline points="22 4 12 4 2 4"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Active Users</div>
                <div class="stat-number">{{ $activeUsers ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="14 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Content</div>
                <div class="stat-number">{{ $totalContent ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 0 20 20v-1a9 9 0 0 1 20 20z"></path>
                    <polyline points="22 4 12 4 2 4"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Published Content</div>
                <div class="stat-number">{{ $publishedContent ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Draft Content</div>
                <div class="stat-number">{{ $draftContent ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2">
                    <path d="M16 21H5a2 2 0 0 1-2 2v16a2 2 0 0 1-2 2h11a2 2 0 0 1-2 2z"></path>
                    <polyline points="16 2 14 8 6 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Storage Used</div>
                <div class="stat-number">{{ $storageUsed ?? '2.5 GB' }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2">
                    <path d="M13 2L3 14h9v11l9-11z"></path>
                    <polyline points="13 2 3 14 3 14"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Error Rate</div>
                <div class="stat-number">{{ $errorRate ?? '0.2%' }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 0 20 20v-1a9 9 0 0 1 20 20z"></path>
                    <polyline points="22 4 12 4 2 4"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Uptime</div>
                <div class="stat-number">{{ $uptime ?? '99.9%' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- System Controls -->
<section class="table-section">
    <div class="table-container">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem;">System Controls</h2>
        
        <div class="controls-grid">
            <div class="control-card">
                <div class="control-header">
                    <i class="ph ph-cpu" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Performance</h3>
                </div>
                <div class="control-actions">
                    <button class="control-btn primary" onclick="optimizePerformance()">
                        <i class="ph ph-gauge"></i> Optimize
                    </button>
                    <button class="control-btn secondary" onclick="clearCache()">
                        <i class="ph ph-funnel"></i> Clear Cache
                    </button>
                </div>
                <div class="control-status">
                    <span class="status-indicator good"></span>
                    <span>Optimal</span>
                </div>
            </div>

            <div class="control-card">
                <div class="control-header">
                    <i class="ph ph-shield-check" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Security</h3>
                </div>
                <div class="control-actions">
                    <button class="control-btn primary" onclick="runSecurityScan()">
                        <i class="ph ph-shield"></i> Scan
                    </button>
                    <button class="control-btn secondary" onclick="viewLogs()">
                        <i class="ph ph-file-text"></i> Logs
                    </button>
                </div>
                <div class="control-status">
                    <span class="status-indicator good"></span>
                    <span>Secure</span>
                </div>
            </div>

            <div class="control-card">
                <div class="control-header">
                    <i class="ph ph-database" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Database</h3>
                </div>
                <div class="control-actions">
                    <button class="control-btn primary" onclick="backupDatabase()">
                        <i class="ph ph-cloud-arrow-up"></i> Backup
                    </button>
                    <button class="control-btn secondary" onclick="optimizeDatabase()">
                        <i class="ph ph-wrench"></i> Optimize
                    </button>
                </div>
                <div class="control-status">
                    <span class="status-indicator good"></span>
                    <span>Healthy</span>
                </div>
            </div>

            <div class="control-card">
                <div class="control-header">
                    <i class="ph ph-cloud" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.5rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Storage</h3>
                </div>
                <div class="control-actions">
                    <button class="control-btn primary" onclick="cleanupStorage()">
                        <i class="ph ph-trash"></i> Cleanup
                    </button>
                    <button class="control-btn secondary" onclick="analyzeStorage()">
                        <i class="ph ph-chart-pie"></i> Analyze
                    </button>
                </div>
                <div class="control-status">
                    <span class="status-indicator warning"></span>
                    <span>75% Used</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">Recent Activity</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="ph ph-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">System backup completed</div>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="ph ph-info"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Database optimization performed</div>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="ph ph-warning"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">High memory usage detected</div>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon error">
                        <i class="ph ph-x-circle"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Failed login attempts detected</div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
