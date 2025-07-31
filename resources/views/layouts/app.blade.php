<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Laravel Blog')</title>
    
    <!-- Meta Tags -->
    @stack('meta')
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .blog-card {
            transition: transform 0.2s ease-in-out;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .blog-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .search-form {
            max-width: 400px;
        }
        
        .pagination {
            justify-content: center;
        }
        
        .sidebar {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }
        
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .loading-spinner {
            display: none;
        }
        
        .blog-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .search-form {
                max-width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('blog.index') }}">
                <i class="fas fa-blog"></i> Laravel Blog
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" 
                           href="{{ route('blog.index') }}">
                            <i class="fas fa-home"></i> Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                           href="{{ route('admin.blog.list') }}">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Laravel Blog</h5>
                    <p class="mb-0">A modern, responsive blog built with Laravel and Bootstrap.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} Laravel Blog. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // CSRF token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Show loading spinner on form submit
        $('form').on('submit', function() {
            $(this).find('.loading-spinner').show();
            $(this).find('button[type="submit"]').prop('disabled', true);
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
