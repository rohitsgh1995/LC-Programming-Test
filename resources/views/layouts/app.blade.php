<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick-theme.css') }}">
        <style>
            .slick-prev::before, .slick-next::before{color: #000 !important;}
        </style>
        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="d-flex flex-column h-100">

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">
                    <a href="{{ route('movies') }}" class="navbar-brand">Movies</a>
                    <a href="{{ route('movie.create') }}" class="btn btn-success">
                        Create Movie
                    </a>
                </div>
            </nav>
        </header>

        <!-- Begin page content -->
        <main class="flex-shrink-0">
            
                {{ $slot }}
            
        </main>
        
        <footer class="footer fixed-bottom mt-auto py-2 bg-dark">
            <div class="container text-center">
                <span class="text-muted">Developed by Rohit Singh</span>
            </div>
        </footer>

        @stack('modals')

        @livewireScripts

        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            $(document).on('ready', function() {
                $(".center").slick({
                    dots: false,
                    infinite: true,
                    centerMode: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    responsive: [
                        {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                        }
                        },
                        {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                        }
                        },
                        {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                        }
                    ]
                });
            });
        </script>

        @stack('footerScripts')
    </body>
</html>