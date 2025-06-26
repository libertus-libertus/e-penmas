<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Petugas Puskesmas Sehat Selalu')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- AOS (Animate On Scroll) CDN -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts: Jost -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS Anda (yang sudah dipisahkan ke public/backend/css/style.css) -->
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">

    <!-- Stack untuk CSS tambahan per halaman (misal: Datatables CSS) -->
    @stack('styles')
</head>
<body>

    <div class="wrapper d-flex">

        {{-- sidebar (sekarang diambil dari resources/views/layouts/backend/sidebar.blade.php) --}}
        @include('layouts.backend.sidebar')

        <div id="content">
            <!-- Tombol toggle sidebar untuk mobile -->
            <button type="button" id="sidebarCollapse" class="btn btn-info d-block d-md-none mb-3 animate__animated animate__fadeIn">
                <i class="fas fa-bars"></i>
            </button>

            {{-- navbar (sekarang diambil dari resources/views/layouts/backend/navbar.blade.php) --}}
            @include('layouts.backend.navbar')

            {{-- Judul Sub Halaman --}}
            <h1 class="mb-3 animate__animated animate__fadeInUp">@yield('sub_title')</h1>

            {{-- Konten Utama Halaman --}}
            @yield('content')

        </div>
    </div>

    <!-- JQuery (HARUS ADA SEBELUM SCRIPT LAIN YANG MENGGUNAKAN JQUERY, TERUTAMA DATATABLES) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle with Popper CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- AOS Initialization -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS Anda (yang sudah dipisahkan ke public/backend/js/script.js) -->
    <script src="{{ asset('backend/js/script.js') }}"></script>
    <script>
        // Global SweetAlert2 (for delete confirmation)
        window.confirmDelete = function (formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Inisialisasi Toastr untuk pesan flash
        if (typeof toastr !== 'undefined') { // Cek apakah toastr sudah dimuat
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Tangani pesan dari session flash
            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif

            @if(Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
            @endif

            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif

            // Tangani pesan error validasi ($errors)
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
        }
    </script>

    <!-- Stack untuk JS tambahan per halaman (misal: Datatables JS dan inisialisasi) -->
    @stack('scripts')
</body>
</html>