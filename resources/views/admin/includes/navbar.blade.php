<nav class="main-header navbar navbar-expand  navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav w-100">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item w-75 custom-bg-transparent pageTitle">
            @yield('pageHeading')
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home.index') }}" class="nav-link">الرئيسية</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('logout') }}" class="nav-link">خروج</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" id="search" type="search" placeholder="Search"
                aria-label="Search">

            <label class="input-group-text" for="search">
                <i class="fas fa-search"></i>
            </label>

        </div>
    </form>
</nav>
