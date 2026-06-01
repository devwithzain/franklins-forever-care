<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Franklin's Forever Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="bg-theme-bg text-theme-text-main transition-colors duration-300 inter">
    <main>
        <div class="absolute top-0 left-0 w-full z-50">
            @include('frontend.components.header')

            <div class="{{ request()->is('/') ? '' : 'bg-white' }}">
                @include('frontend.components.navbar')
            </div>
        </div>
        @yield('content')
        @include('frontend.components.footer')
    </main>

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };
        @if (Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if (Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>