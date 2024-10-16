<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DIS MEDIA STORE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col h-screen">
        <!-- Navigation / Header -->
        @include('layouts.navigation')

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8 pt-24 ml-64">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-secondary text-primary shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <div class="py-1 mb-16">
                    <div class="mx-auto">
                        <div class="bg-secondary text-primary overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>
</body>
</html>
