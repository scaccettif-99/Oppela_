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
                        <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Chi siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('annunci.index') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contatti</a>
                    </li>
                    @auth
                        @if(in_array(auth()->user()->role, ['admin', 'owner']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('annunci.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Crea annuncio
                            </a>
                        </li>
                        @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle me-1"></i> Profilo
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <!-- fine navbar -->