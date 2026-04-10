<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="img/logo.jpg" class="logo" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img src="img/stampella.svg" alt="Menu" class="toggler-icon">
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mx-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        <span class="nav-link-text">Home</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('annunci*') ? 'active' : '' }}" href="{{ route('annunci.index') }}">
                        <span class="nav-link-text">Shop</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('chi-siamo') ? 'active' : '' }}" href="{{ route('chi-siamo') }}">
                        <span class="nav-link-text">Chi siamo</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contatti') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <span class="nav-link-text">Contatti</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                @auth
                @if(in_array(auth()->user()->role, ['admin', 'owner']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('annunci/create') ? 'active' : '' }}" href="{{ route('annunci.create') }}">
                        <span class="nav-link-text">Crea annuncio</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <span class="nav-link-text">Profilo</span>
                        <svg class="nav-circle" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <ellipse cx="50" cy="20" rx="48" ry="17"/>
                        </svg>
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!-- fine navbar -->