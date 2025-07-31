<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel - Laravel Blog')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom Admin CSS -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        
        .main-content {
            min-height: calc(100vh - 56px);
        }
        
        .card-stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .card-stats.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .card-stats.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .card-stats.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
        
        .table-actions {
            white-space: nowrap;
        }
        
        .status-badge {
            font-size: 0.75rem;
        }
        
        .search-form {
            max-width: 300px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.blog.list') }}">
                <i class="fas fa-cog"></i> Admin Panel
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('blog.index') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Blog
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}" 
                               href="{{ route('admin.blog.list') }}">
                                <i class="fas fa-list"></i> Blog Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.blog.create') }}">
                                <i class="fas fa-plus"></i> Create Post
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // CSRF token setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                language: {
                    search: "Search posts:",
                    lengthMenu: "Show _MENU_ posts per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ posts",
                    infoEmpty: "No posts available",
                    infoFiltered: "(filtered from _MAX_ total posts)"
                }
            });
        });
        
        // Confirm delete actions
        $('.btn-delete').on('click', function(e) {
            if (!confirm('Are you sure you want to delete this post?')) {
                e.preventDefault();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
