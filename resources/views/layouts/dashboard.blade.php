<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Petugas Puskesmas Sehat Selalu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    @stack('css')
</head>
<body>

    <div class="wrapper d-flex">

        {{-- sidebar --}}
        @include('layouts.backend.sidebar')

        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-md-none mb-3 animate__animated animate__fadeIn">
                <i class="fas fa-bars"></i>
            </button>

            {{-- navbar --}}
            @include('layouts.backend.navbar')

            {{-- subtitle --}}
            <h1 class="mb-3 animate__animated animate__fadeInUp">@yield('sub_title')</h1>

            {{-- content --}}
            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('backend/js/script.js') }}"></script>
    @stack('js')
</body>
</html>