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
        <div class="min-h-screen flex">
            <!-- Left Panel - Real Travel Image -->
            <div class="hidden lg:flex lg:w-1/2 relative">
                <!-- Real Background Image from Unsplash -->
                <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                     alt="Airplane wing view" 
                     class="absolute inset-0 w-full h-full object-cover">
                
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 via-blue-800/60 to-indigo-900/70"></div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-between p-10 h-full">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                            </svg>
                        </div>
                        <span class="text-white font-semibold text-lg">SkyLine Airways</span>
                    </div>
                    
                    <!-- Quote -->
                    <div class="mb-10">
                        <blockquote class="text-white text-2xl lg:text-3xl font-light leading-relaxed mb-4">
                            "Travel is the only purchase that enriches you in ways beyond material wealth."
                        </blockquote>
                        <p class="text-blue-200 text-sm">Professional Ticket Management System</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="flex-1 lg:w-1/2 flex items-center justify-center p-6 sm:p-8 bg-gray-50 min-h-screen">
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
