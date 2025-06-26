<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 animate__animated animate__fadeInDown">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary d-none d-md-block" type="button" id="sidebarToggleDesktop">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ms-3 d-none d-md-block" href="#">Halo, {{ Auth::user()->name }}!</a>
        <div class="ms-auto">
            <span class="navbar-text">
                Puskesmas Nanggalo Siteba | <span id="currentDateTime"></span>
            </span>
        </div>
    </div>
</nav>