<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Programming Test | Lingual Consultancy</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick-theme.css') }}">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .slick-prev::before, .slick-next::before{color: #000 !important;}
        </style>
    </head>
    <body class="d-flex flex-column h-100">
        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">
                    <span class="navbar-brand">Movies</span>
                    <button class="btn btn-success">Create Movie</button>
                </div>
            </nav>
        </header>
        <!-- Begin page content -->
        <main class="flex-shrink-0">
            <div class="container" style="padding: 90px 10px 0;">
                <div class="row g-0 mb-5">
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset('assets/img/movie.jpg') }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Avengers</h5>
                                <p class="card-text">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">2h 30m</small>
                                    <div class="d-flex gap-3 align-items-center">
                                        <button type="button" class="btn btn-outline-warning">Edit</button>
                                        <button type="button" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Casts</h5>
                                <div class="px-3">
                                    <div class="center slider">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img class="mb-1" src="{{ asset('assets/img/user.png') }}" width="50">
                                            <strong>Iron Man</strong>
                                            <small class="text-wrap">Robert Downey Junior</small>
                                            <small>(M)</small>
                                        </div>                                        
                                    </div>
                                </div>
                                <hr>
                                <h5 class="card-title">Dialouges</h5>
                                <div class="d-flex justify-content-between align-items-center" style="height: 32.3vh; max-height: 32.3vh; overflow-y: scroll;">
                                    
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer mt-auto py-1 bg-dark">
            <div class="container text-center">
                <span class="text-muted">Developed by Rohit Singh</span>
            </div>
        </footer>
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
    </body>
</html>