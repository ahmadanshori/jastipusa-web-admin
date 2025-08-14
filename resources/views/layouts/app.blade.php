

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JASTIPUSA - Admin Dashboard</title>
    
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.jpg') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.jpg') }}" type="image/png">
    @include('partials.css')
    @yield('styles')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="/"><img src="{{ asset('assets/images/logo/logo.jpg') }}" alt="Logo" srcset=""></a>
            </div>
            <div class="theme-toggle d-flex gap-2  align-items-center mt-2" style="display:none !important">
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" >
                    <label class="form-check-label" ></label>
                </div>
            </div>
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        @include('partials.sidebar')
    </div>
</div>
        </div>
        <div id="main" class='layout-navbar'>
            <header class='mb-1'>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                               
                            </ul>
                             <div class="dropdown">
                                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                  
                                    <div class="avatar bg-warning avatar-md2">
                                        <span class="avatar-content">{{ App\Helpers\Helper::avatar(Auth::user()->name) }}</span>
                                      </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name"> {{ Auth::user()->name }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted">{{ App\Models\User::getRole(Auth::user()->role_id)}}</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                  <li><a class="dropdown-item" href="{{ route('user.edit', [Auth::user()->id]) }}">My Account</a></li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                 </a>

                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                 </form>
                                  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
        <div id="main-content">
                
            @yield('content')

             
            </div>
        </div>
    </div>
    @include('partials.js')
    @yield('scripts')
  
    
</body>

</html>
