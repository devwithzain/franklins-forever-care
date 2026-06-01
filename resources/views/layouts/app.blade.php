<!DOCTYPE html>
<html lang="en" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true', 
    sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' 
}" x-init="
    $watch('darkMode', val => localStorage.setItem('darkMode', val)); 
    $watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val));
" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Franklin's Forever Care</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-theme-bg text-theme-text-main transition-colors duration-300">
    <div class="flex min-h-screen">
        <x-sidebar />
        <div :class="sidebarOpen ? 'ml-64' : 'ml-0'"
            class="flex flex-col flex-1 overflow-hidden transition-all duration-300">
            <x-navbar />
            <main class="flex-1 overflow-y-auto p-7 pt-[91px]">
                @yield('content')
            </main>
        </div>
    </div>

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
</body>

</html>