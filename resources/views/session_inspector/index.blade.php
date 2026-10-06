@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Banner -->
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-user-shield text-primary me-2"></i>Active Sessions Inspector & Driver Benchmark
            </h3>
            <p class="text-muted mb-0 small">Scan active device sessions, revoke remote connections, monitor lifetime expiry & benchmark driver latency</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-house me-1"></i> Dashboard
            </a>
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-download me-1"></i> Export Session State
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('session_inspector.export', ['format' => 'csv']) }}"><i class="fa-solid fa-file-csv text-success me-2"></i> CSV State</a></li>
                    <li><a class="dropdown-item" href="{{ route('session_inspector.export', ['format' => 'xlsx']) }}"><i class="fa-solid fa-file-excel text-primary me-2"></i> XLSX Spreadsheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('session_inspector.export', ['format' => 'json']) }}"><i class="fa-solid fa-file-code text-warning me-2"></i> JSON Payload</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Active Device Sessions Radar & Lifetime Watchdog -->
    <div class="row g-4 mb-4">
        <!-- Active Devices List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="fa-solid fa-desktop text-success me-2"></i>Active Device Sessions Radar</h5>
                        <p class="text-muted small mb-0">Total {{ $totalSessionsCount }} active session files detected in <code>storage/framework/sessions</code></p>
                    </div>
                    <form action="{{ route('session_inspector.revoke_others') }}" method="POST" onsubmit="return confirm('Revoke all other active device sessions?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                            <i class="fa-solid fa-user-slash me-1"></i> Revoke All Other Devices
                        </button>
                    </form>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Device / OS</th>
                                    <th>IP Address</th>
                                    <th>Session ID</th>
                                    <th>Last Active</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeDevices as $dev)
                                    <tr class="{{ $dev['is_current'] ? 'table-success bg-opacity-10' : '' }}">
                                        <td>
                                            <div class="fw-bold text-dark">
                                                @if($dev['device_type'] === 'Mobile')
                                                    <i class="fa-solid fa-mobile-screen text-primary me-2"></i>
                                                @else
                                                    <i class="fa-solid fa-laptop text-dark me-2"></i>
                                                @endif
                                                {{ $dev['platform'] }}
                                            </div>
                                            <small class="text-muted text-truncate d-block" style="max-width: 200px;" title="{{ $dev['user_agent'] }}">{{ $dev['user_agent'] }}</small>
                                        </td>
                                        <td><code class="text-primary">{{ $dev['ip'] }}</code></td>
                                        <td>
                                            <span class="font-mono text-muted small">{{ substr($dev['session_id'], 0, 10) }}...</span>
                                            @if($dev['is_current'])
                                                <span class="badge bg-success ms-1">THIS DEVICE</span>
                                            @endif
                                        </td>
                                        <td><span class="small text-muted">{{ $dev['last_active'] }}</span></td>
                                        <td class="text-end">
                                            @if(!$dev['is_current'])
                                                <form action="{{ route('session_inspector.revoke', $dev['session_id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Revoke Device Session">
                                                        <i class="fa-solid fa-power-off"></i> Revoke
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-light text-dark border">Current Session</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Lifetime Expiry Watchdog Widget -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-dark text-white">
                <div class="card-header bg-transparent border-secondary pt-3 px-3 pb-2">
                    <span class="fw-bold small"><i class="fa-solid fa-stopwatch text-warning me-2"></i>Session Lifetime Watchdog</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-between">
                    <div>
                        <div class="bg-black p-3 rounded-3 text-center mb-3" style="border: 1px solid #333;">
                            <div class="text-muted small mb-1">Session Expiry Countdown</div>
                            <div id="sessionCountdownDisplay" class="display-6 fw-bold text-warning font-mono my-2">00m 00s</div>
                            <small class="text-muted d-block">SESSION_LIFETIME = {{ $lifetimeMins }} Minutes</small>
                        </div>

                        <div class="p-3 rounded-3 bg-secondary bg-opacity-25 border border-secondary text-white small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Storage Driver:</span>
                                <strong class="text-info">{{ config('session.driver', 'file') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Session Encryption:</span>
                                <strong>{{ config('session.encrypt') ? 'Enabled' : 'Disabled' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Watchdog Auto-Lock:</span>
                                <strong class="text-success">Active</strong>
                            </div>
                        </div>
                    </div>

                    <div class="text-muted extra-small text-center mt-3">
                        <i class="fa-solid fa-shield-halved me-1"></i> Idle timeout automatically clears active session
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Driver Performance Benchmark & Activity Timeline -->
    <div class="row g-4 mb-4">
        <!-- Session Driver Benchmark -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-gauge-high text-info me-2"></i>Session Driver Performance Benchmark</h5>
                    <p class="text-muted small mb-0">Read/Write execution latency comparison across Laravel session drivers</p>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush border rounded-3 overflow-hidden mb-3">
                        @foreach($benchmark as $bench)
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <div class="fw-bold text-dark small">{{ $bench['driver'] }}</div>
                                    <small class="text-muted">Execution Latency: <strong class="text-dark">{{ $bench['latency_ms'] }} ms</strong></small>
                                </div>
                                <span class="badge {{ $bench['badge'] }}">{{ $bench['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> File-based sessions store serialized arrays directly in <code>storage/framework/sessions</code> for optimal latency.</small>
                </div>
            </div>
        </div>

        <!-- Activity Timeline Visualizer -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-clock-rotate-left text-warning me-2"></i>Session Activity Timeline</h5>
                    <p class="text-muted small mb-0">Audit history of all session modifications during this visit</p>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                        @forelse($timeline as $item)
                            <div class="list-group-item px-0 py-2 border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong class="text-dark small">{{ $item['title'] }}</strong>
                                    <small class="text-muted extra-small">{{ $item['time'] }}</small>
                                </div>
                                <p class="text-muted extra-small mb-0">{{ $item['description'] }}</p>
                            </div>
                        @empty
                            <div class="text-muted small text-center py-4">No timeline activities recorded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let remaining = {{ $remainingSeconds }};
    const display = document.getElementById('sessionCountdownDisplay');

    function updateTimer() {
        if (remaining <= 0) {
            display.textContent = "00m 00s (EXPIRED)";
            return;
        }

        const mins = Math.floor(remaining / 60);
        const secs = remaining % 60;

        const mStr = String(mins).padStart(2, '0');
        const sStr = String(secs).padStart(2, '0');

        display.textContent = `${mStr}m ${sStr}s`;
        remaining--;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
});
</script>
@endpush
