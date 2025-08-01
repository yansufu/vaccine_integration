  <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ibu Digi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>

    </style>
</head>

<body>
    <header class="container d-flex flex-column flex-md-row
              justify-content-between align-items-center px-4 px-md-5 py-3">
        <div class="d-flex align-items-center gap-2 fw-bold text-danger">
            <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Ibu Digi"></a>
        </div>

        <nav class="d-flex gap-4 fw-medium">
            <a href="{{ route('home') }}" class="nav-link">
                Home
            </a>

            <a href="{{ route('new') }}" class="nav-link ">
                News
            </a>

            <a href="{{ route('catalog') }}" class="nav-link ">
                Catalog
            </a>
        </nav>
    </header>


@yield('content')

  <img src="{{ asset('images/Call to action.png') }}" style="width:100%">

    </div>
    <!-- Footer -->
    <footer class="text-white mt-5" style="background: #ffe3ef73;">
        <div class="container py-5 text-dark">
            <div class="row">
                <!-- Logo & Info -->
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Ibu Digi Logo"
                            style="width: 14rem; height: auto;">
                    </div>
                    <p class="mt-3">
                        Your Health Is Our <span class="fw-bold">Priority</span><br>
                        <br>
                        <small>All vaccines are carefully tested and recommended by health experts to ensure they are safe for
                        your child.</small>
                    </p>
                </div>

                <!-- Important Links -->
                <div class="col-md-4 mb-4">
                    <h6 class=" mb-3">Important <span class="fw-bold">Links</span></h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><img src="{{asset('images/check.png')}}" alt=""> Support center</li>
                        <li class="mb-2"><img src="{{asset('images/check.png')}}" alt=""> Privacy policy</li>
                        <li class="mb-2"><img src="{{asset('images/check.png')}}" alt=""> Terms and conditions</li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4 mb-4">
                    <h6 class=" mb-3">Contact <span class="fw-bold">Us</span></h6>
                    <p class="mb-2"><img src="{{asset('images/settings_phone.png')}}" alt=""> 123 456 7890</p>
                    <p class="mb-2"><img src="{{asset('images/settings_phone.png')}}" alt=""> 123 456 7890</p>
                    <p> info@yourcompany.com</p>
                </div>
            </div>
        </div>
        <div class="text-center py-3" style="background: #f39ebd;">
            <small>© Copyright 2024 IbuDigi. All Rights Reserved.</small>
        </div>
    </footer>


    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper.js')}}"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Inisialisasi Swiper HARUS setelah Swiper JS dimuat -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1.2,
            spaceBetween: 5,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2.2,
                },
                992: {
                    slidesPerView: 3,
                }
            }
        });
    </script>

    <!-- Bootstrap JS -->

    <script src="{{asset('js/script.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
