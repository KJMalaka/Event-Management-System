<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="text-8xl font-bold text-red-500 dark:text-red-400 mb-4">403</div>
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Access Denied</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8">You do not have permission to access this area.</p>
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
            &larr; Go to Dashboard
        </a>
    </div>
</body>
</html>
