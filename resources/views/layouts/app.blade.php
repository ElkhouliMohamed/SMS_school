<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduManage Pro') }} - @yield('title', 'Tableau de bord')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #f59e0b;
            --secondary-hover: #d97706;
            --light-color: #ffffff;
            --light-secondary: #f3f4f6;
            --text-color: #1f2937;
        }

        body {
            scroll-behavior: smooth;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(209, 213, 219, 0.3);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.7);
        }

        .active {
            background-color: rgba(37, 99, 235, 0.1);
            border-left: 4px solid var(--primary-color);
            color: var(--primary-color);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="h-full bg-gray-100 antialiased font-sans text-gray-900">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden transition-opacity duration-300 lg:hidden"></div>

    <div class="flex h-full overflow-hidden">
        @include('layouts.sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100" tabindex="0">
                <!-- Status messages -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <p>{{ session('status') }}</p>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Page content -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar toggle button -->
    <button id="toggleSidebar" aria-label="Ouvrir la barre latérale" aria-expanded="false" aria-controls="sidebar"
        class="fixed lg:hidden bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 text-white shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const toggleBtn = document.getElementById('toggleSidebar');
            const closeBtn = document.getElementById('closeSidebar');

            const toggleSidebar = () => {
                const isOpen = sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden', !isOpen);
                document.body.classList.toggle('overflow-hidden', isOpen);
                toggleBtn.setAttribute('aria-expanded', isOpen);
                toggleBtn.innerHTML = isOpen ? '<i class="fas fa-times text-xl"></i>' :
                    '<i class="fas fa-bars text-xl"></i>';
            };

            toggleBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleSidebar();
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    toggleBtn.setAttribute('aria-expanded', true);
                }
            });

            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                toggleBtn.setAttribute('aria-expanded', true);
            }
        });
    </script>
</body>
</html>