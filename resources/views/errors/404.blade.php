<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="text-8xl font-bold text-blue-600 dark:text-blue-400 mb-4">404</div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Page Not Found</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8">The page you are looking for does not exist or has been moved.</p>
        <a href="{{ route('events.index') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
            &larr; Back to Events
        </a>
    </div>
</body>
</html>
