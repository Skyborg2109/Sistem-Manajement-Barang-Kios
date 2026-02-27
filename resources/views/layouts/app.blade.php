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
        @stack('styles')
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50 selection:bg-primary-500 selection:text-white" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden bg-slate-50">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
                <!-- Topbar / Header -->
                @include('layouts.topbar')

                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto w-full relative z-0 hide-scrollbar" style="scroll-behavior: smooth;">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-10 border-b border-slate-200/60 shadow-sm transition-all duration-300">
                            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Utility styles -->
        <style>
            .hide-scrollbar::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            .hide-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .hide-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 20px;
            }
            .hide-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: #94a3b8;
            }
        </style>
        
        @stack('scripts')
    </body>
</html>
