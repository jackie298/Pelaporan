<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','PT. Nusa Karya Arindo')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Icon --}}
    <link rel="icon" type="image/png" href="../assets/img/logoperusahaan.png">
</head>
<body>

@include('components.navbar')

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h6 class="fw-bold">PERHUTANI</h6>
                <p class="small">
                    Pengelolaan hutan negara secara lestari
                </p>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Menu</h6>
                <ul class="list-unstyled small">
                    <li>Profil</li>
                    <li>Bisnis</li>
                    <li>Publikasi</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold">Kontak</h6>
                <p class="small">
                    Jakarta – Indonesia<br>
                    info@perhutani.co.id
                </p>
            </div>

        </div>

        <hr>
        <p class="text-center small mb-0">
            © {{ date('Y') }} Perum Perhutani
        </p>
    </div>
</footer>

</html>
