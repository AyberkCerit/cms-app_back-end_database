<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{route('profile')}}">
          <span class="align-middle">Welcome {{Auth::user()->name}}</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						{{ __('menu.pages') }}
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('dashboard')}}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{ __('menu.dashboard') }}</span>
            </a>
					</li>


					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('blog-posts')}}">
              <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">{{ __('menu.blog_posts') }}</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('blog-categories')}}">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">{{ __('menu.blog_categories') }}</span>
            </a>
					</li>

					<li class="sidebar-item {{ request()->routeIs('languages') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('languages')}}">
              <i class="align-middle" data-feather="globe"></i> <span class="align-middle">{{ __('menu.languages') }}</span>
            </a>
					</li>

					<li class="sidebar-item {{ request()->routeIs('media') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('media')}}">
              <i class="align-middle" data-feather="image"></i> <span class="align-middle">Medya</span>
            </a>
					</li>



					@role('Admin')
                    					<li class="sidebar-item ">
						<a class="sidebar-link" href="{{route('users')}}">
              <i class="align-middle" data-feather="command"></i> <span class="align-middle">{{ __('menu.user_manage') }}</span>
            </a>
					</li>
					@endrole

				</ul>
			</div>
		</nav>
