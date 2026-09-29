@extends('admin.layouts.app')

@push('page-style')
    <style>
        .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
    </style>
@endpush

@section('page-content')
    <!-- BEGIN row -->
    <div class="row">
        <!-- Breadcrumb -->
        <div class="col-sm-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Overview</li>
            </ul>
            <hr class="mb-4">
        </div>
    </div>

    <!-- BEGIN Stat Cards Row -->
    <div class="row mb-3">

        <!-- Projects Stat Card -->
        <div class="col-xl-3 col-lg-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">TOTAL PROJECTS</span>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-briefcase fs-5"></i>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-12">
                            <h3 class="mb-0 text-primary">{{ $stats['projects'] }}</h3>
                        </div>
                    </div>
                    <div class="small text-muted text-truncate">
                        <a href="{{ route('admin.project') }}" class="text-decoration-none text-muted"><i
                                class="bi bi-arrow-right me-1"></i> Manage Projects</a>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>

        <!-- Blogs Stat Card -->
        <div class="col-xl-3 col-lg-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">PUBLISHED BLOGS</span>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-journal-text fs-5"></i>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-12">
                            <h3 class="mb-0 text-success">{{ $stats['blogs'] }}</h3>
                        </div>
                    </div>
                    <div class="small text-muted text-truncate">
                        <a href="{{ route('admin.blog') }}" class="text-decoration-none text-muted"><i
                                class="bi bi-arrow-right me-1"></i> Manage Blogs</a>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>

        <!-- Contact Messages Stat Card -->
        <div class="col-xl-3 col-lg-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">NEW MESSAGES</span>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-envelope-paper fs-5"></i>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-12">
                            <h3 class="mb-0 text-warning">{{ $stats['contacts'] }}</h3>
                        </div>
                    </div>
                    <div class="small text-muted text-truncate">
                        <a href="{{ route('admin.contact') }}" class="text-decoration-none text-muted"><i
                                class="bi bi-arrow-right me-1"></i> View Inbox</a>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>

        <!-- Testimonials Stat Card -->
        <div class="col-xl-3 col-lg-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">TESTIMONIALS</span>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-chat-quote fs-5"></i>
                        </div>
                    </div>
                    <div class="row align-items-center mb-2">
                        <div class="col-12">
                            <h3 class="mb-0 text-info">{{ $stats['testimonials'] }}</h3>
                        </div>
                    </div>
                    <div class="small text-muted text-truncate">
                        <a href="{{ route('admin.testimonial') }}" class="text-decoration-none text-muted"><i
                                class="bi bi-arrow-right me-1"></i> Manage Reviews</a>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Stat Cards Row -->

    <!-- BEGIN Data Tables Row -->
    <div class="row">
        <!-- Recent Messages Table -->
        <div class="col-xl-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">RECENT INQUIRIES</span>
                        <a href="{{ route('admin.contact') }}" class="text-muted text-decoration-none"><i
                                class="bi bi-box-arrow-up-right me-1"></i> View All</a>
                    </div>

                    <div class="table-responsive">
                        <table class="w-100 mb-0 align-middle text-nowrap table table-borderless table-hover small">
                            <thead class="border-bottom">
                                <tr class="text-secondary">
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th class="text-end">DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentContacts as $msg)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="w-30px h-30px rounded-circle bg-dark d-flex align-items-center justify-content-center me-3 text-primary">
                                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                                </div>
                                                <div class="fw-semibold">{{ $msg->name }}</div>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $msg->email }}</td>
                                        <td class="text-end text-muted">{{ $msg->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No messages found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>

        <!-- Recent Projects Table -->
        <div class="col-xl-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex fw-bold small mb-3">
                        <span class="flex-grow-1 text-secondary">RECENTLY ADDED PROJECTS</span>
                        <a href="{{ route('admin.project') }}" class="text-muted text-decoration-none"><i
                                class="bi bi-box-arrow-up-right me-1"></i> View All</a>
                    </div>

                    <div class="table-responsive">
                        <table class="w-100 mb-0 align-middle text-nowrap table table-borderless table-hover small">
                            <thead class="border-bottom">
                                <tr class="text-secondary">
                                    <th>PROJECT TITLE</th>
                                    <th>STATUS</th>
                                    <th class="text-end">DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProjects as $proj)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-circle-fill fs-6px text-success me-2"></i>
                                                <div class="fw-semibold text-truncate" style="max-width: 200px;">
                                                    {{ $proj->title }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($proj->live_url)
                                                <a href="{{ $proj->live_url }}" target="_blank"
                                                    class="badge bg-success bg-opacity-10 text-success text-decoration-none">Live</a>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Local</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-muted">{{ $proj->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Data Tables Row -->
@endsection

@push('page-script')
    <!-- Minimal Dashboard JS needs (Removed heavy charts logic since it's customized) -->
@endpush
