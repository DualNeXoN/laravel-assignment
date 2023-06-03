<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('home') }}">Laravel Zadanie</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item {{ request()->routeIs('cars') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cars') }}">Cars</a>
            </li>
            <li class="nav-item {{ request()->routeIs('parts') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('parts') }}">Parts</a>
            </li>
        </ul>
    </div>
</nav>