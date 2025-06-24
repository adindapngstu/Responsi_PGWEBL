<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
        <!-- Brand: Logo + Text -->
        <a class="navbar-brand d-flex align-items-center gap-2 text-dark fw-semibold" href="{{ route('home') }}">
            <img src="{{ asset('build/assets/icon/logo_web2.png') }}" alt="Sare Kene Logo" style="height: 32px;">
            <span class="fs-5">Sare Kene</span>
        </a>

        <!-- Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links + Search -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fa-solid fa-house-chimney me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('map') }}">
                        <i class="fa-solid fa-map-location-dot me-1"></i> Peta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('table') }}">
                        <i class="fa-solid fa-table me-1"></i> Tabel
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="nav-link text-danger bg-transparent border-0" type="submit">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ route('login') }}">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </a>
                    </li>
                @endguest
            </ul>

            <!-- Right Search Bar -->
            <form id="navbarSearchForm" class="d-flex" role="search">
                <input class="form-control rounded-start-pill border-0 shadow-sm" id="navbarSearchInput" type="search"
                    name="query" placeholder="Cari hotel..." aria-label="Search">
                <button class="btn btn-cari" type="submit">
                    <i class="fa fa-search"></i>
                </button>

            </form>
        </div>
    </div>
</nav>
