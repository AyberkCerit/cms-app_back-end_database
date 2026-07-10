<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Blog">
	<title>@yield('title', 'Blog') | CMS App</title>

	<link href="{{ asset('template/static/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .blog-card-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
	<div class="wrapper">
        <!-- Sidebar for Categories -->
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{ route('blog.index') }}">
                  <span class="align-middle">My Blog</span>
                </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Kategoriler
					</li>
                    <li class="sidebar-item {{ request()->routeIs('blog.index') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('blog.index') }}">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tümü</span>
                        </a>
					</li>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('blog.index', ['category' => $cat->slug]) }}">
                                <i class="align-middle" data-feather="hash"></i> <span class="align-middle">{{ $cat->name }}</span>
                            </a>
                        </li>
                        @endforeach
                    @endif
				</ul>
			</div>
		</nav>

		<div class="main">
            <!-- Navbar -->
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
                  <i class="hamburger align-self-center"></i>
                </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
                        
                        @php
                            $active_languages = \App\Models\Language::where('status', 1)->get();
                            $current_locale = app()->getLocale();
                            $current_language = $active_languages->where('code', $current_locale)->first();
                        @endphp

                        @if($active_languages->count() > 1)
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="globe"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="globe"></i> <span class="text-dark">{{ $current_language ? $current_language->name : strtoupper($current_locale) }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                @foreach($active_languages as $lang)
                                <a class="dropdown-item" href="{{ route('lang.switch', $lang->code) }}">{{ $lang->name }}</a>
                                @endforeach
                            </div>
                        </li>
                        @endif
                        @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Yönetim Paneline Dön</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">Giriş Yap</a>
                            </li>
                        @endif
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
                    @yield('content')
				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="{{ route('blog.index') }}"><strong>My Blog</strong></a> &copy; 2026
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{ asset('template/static/js/app.js') }}"></script>
    @yield('js')
</body>

</html>
