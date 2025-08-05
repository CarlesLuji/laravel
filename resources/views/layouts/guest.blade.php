<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">

    <!-- 🎥 VIDEO de fondo a pantalla completa -->
    <div class="fixed inset-0 z-[-1] overflow-hidden">
       <video id="bg-video" autoplay muted playsinline class="w-full h-full object-cover">

            <source src="{{ asset('videos/fondo_login.mp4') }}" type="video/mp4">
            Tu navegador no soporta video HTML5.
        </video>
    </div>

    <!-- 📦 CONTENIDO del login sin tocar -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg backdrop-blur-md"
             style="background-color: rgba(255, 255, 255, 0.7);">
            {{ $slot }}
        </div>
    </div>

  <!-- 🔁 Reproducción manual del video cada 20 segundos -->
    <script>
        const video = document.getElementById('bg-video');

        function playVideoEvery30Seconds() {
            video.currentTime = 0;
            video.play();
        }

        // Reproduce inicialmente
        playVideoEvery30Seconds();

        // Luego cada 20 segundos
        setInterval(playVideoEvery30Seconds, 30000);
    </script>

</body>
</html>
