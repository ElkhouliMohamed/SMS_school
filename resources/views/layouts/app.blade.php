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
    @yield('styles')

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #8b5cf6;
            --secondary-hover: #7c3aed;
            --light-color: #ffffff;
            --light-secondary: #f9fafb;
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
            background-color: rgba(79, 70, 229, 0.1);
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

        /* Sidebar transitions */
        .sidebar-expanded {
            width: 18rem; /* 288px */
            transition: width 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 5rem; /* 80px */
            transition: width 0.3s ease-in-out;
        }

        .sidebar-mobile {
            transform: translateX(0);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-mobile-hidden {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        /* Content transitions */
        @media (min-width: 1024px) {
            .content-expanded {
                margin-left: 5rem;
                transition: margin-left 0.3s ease-in-out;
            }

            .content-full {
                margin-left: 0;
                transition: margin-left 0.3s ease-in-out;
            }

            /* Sidebar width */
            .sidebar-expanded {
                width: 18rem;
                min-width: 18rem;
                max-width: 18rem;
            }

            .sidebar-collapsed {
                width: 5rem;
                min-width: 5rem;
                max-width: 5rem;
            }
        }

        @media (max-width: 1023px) {
            .content-expanded, .content-full {
                margin-left: 0;
                transition: margin-left 0.3s ease-in-out;
            }
        }

        /* Text fade transitions */
        .text-fade-in {
            opacity: 1;
            transition: opacity 0.2s ease-in-out 0.1s;
        }

        .text-fade-out {
            opacity: 0;
            transition: opacity 0.1s ease-in-out;
        }
    </style>
</head>
<body class="h-full bg-gray-100 antialiased font-sans text-gray-900">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 hidden transition-opacity duration-300 lg:hidden"></div>

    <div class="flex h-full overflow-hidden">
        @include('layouts.sidebar')

        <!-- Main content -->
        <div id="mainContent" class="flex-1 flex flex-col overflow-hidden transition-all duration-300 w-full">
            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100">
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
        class="fixed lg:hidden bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Collapse/Expand sidebar button for desktop -->
    <button id="collapseSidebar" aria-label="Réduire la barre latérale" aria-expanded="true" aria-controls="sidebar"
        class="fixed hidden md:flex lg:flex bottom-6 left-6 z-50 w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-lg items-center justify-center hover:shadow-xl transition-all duration-300">
        <i class="fas fa-chevron-left text-sm"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('overlay');
            const toggleBtn = document.getElementById('toggleSidebar');
            const collapseBtn = document.getElementById('collapseSidebar');
            const closeBtn = document.getElementById('closeSidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarSections = document.querySelectorAll('.sidebar-section-title');
            const sidebarIcons = document.querySelectorAll('.sidebar-icon');

            // State
            let isSidebarCollapsed = false;
            let isMobile = window.innerWidth < 1024;

            // Toggle mobile sidebar
            const toggleMobileSidebar = () => {
                if (isMobile) {
                    const isOpen = !sidebar.classList.contains('sidebar-mobile-hidden');
                    if (isOpen) {
                        sidebar.classList.add('sidebar-mobile-hidden');
                        sidebar.classList.remove('sidebar-mobile');
                    } else {
                        sidebar.classList.remove('sidebar-mobile-hidden');
                        sidebar.classList.add('sidebar-mobile');
                    }
                    overlay.classList.toggle('hidden', isOpen);
                    document.body.classList.toggle('overflow-hidden', !isOpen);
                    toggleBtn.setAttribute('aria-expanded', !isOpen);
                    toggleBtn.innerHTML = !isOpen ? '<i class="fas fa-times text-xl"></i>' :
                        '<i class="fas fa-bars text-xl"></i>';
                }
            };

            // Toggle desktop sidebar collapse
            const toggleSidebarCollapse = () => {
                if (!isMobile) {
                    isSidebarCollapsed = !isSidebarCollapsed;

                    if (isSidebarCollapsed) {
                        sidebar.classList.remove('sidebar-expanded');
                        sidebar.classList.add('sidebar-collapsed');
                        mainContent.classList.add('content-expanded');
                        mainContent.classList.remove('content-full');
                        collapseBtn.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
                        collapseBtn.classList.add('left-20');

                        // Fade out text
                        sidebarTexts.forEach(text => {
                            text.classList.remove('text-fade-in');
                            text.classList.add('text-fade-out');
                        });

                        sidebarSections.forEach(section => {
                            section.classList.add('hidden');
                        });

                        // Center icons
                        sidebarIcons.forEach(icon => {
                            icon.classList.add('mx-auto');
                            icon.classList.remove('mr-3');
                        });
                    } else {
                        sidebar.classList.add('sidebar-expanded');
                        sidebar.classList.remove('sidebar-collapsed');
                        mainContent.classList.remove('content-expanded');
                        mainContent.classList.add('content-full');
                        collapseBtn.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
                        collapseBtn.classList.remove('left-20');

                        // Fade in text
                        setTimeout(() => {
                            sidebarTexts.forEach(text => {
                                text.classList.add('text-fade-in');
                                text.classList.remove('text-fade-out');
                            });

                            sidebarSections.forEach(section => {
                                section.classList.remove('hidden');
                            });

                            // Restore icon alignment
                            sidebarIcons.forEach(icon => {
                                icon.classList.remove('mx-auto');
                                icon.classList.add('mr-3');
                            });
                        }, 150);
                    }

                    collapseBtn.setAttribute('aria-expanded', !isSidebarCollapsed);
                }
            };

            // Event listeners
            toggleBtn.addEventListener('click', toggleMobileSidebar);
            collapseBtn.addEventListener('click', toggleSidebarCollapse);
            closeBtn.addEventListener('click', toggleMobileSidebar);
            overlay.addEventListener('click', toggleMobileSidebar);

            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (isMobile) {
                        toggleMobileSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                const wasDesktop = !isMobile;
                isMobile = window.innerWidth < 1024;

                // If switching between mobile and desktop
                if (wasDesktop !== !isMobile) {
                    if (isMobile) {
                        // Switching to mobile
                        sidebar.classList.remove('sidebar-expanded', 'sidebar-collapsed');
                        sidebar.classList.add('sidebar-mobile-hidden');
                        mainContent.classList.remove('content-expanded', 'content-full', 'lg:ml-72');

                        // Reset text visibility
                        sidebarTexts.forEach(text => {
                            text.classList.add('text-fade-in');
                            text.classList.remove('text-fade-out');
                        });

                        sidebarSections.forEach(section => {
                            section.classList.remove('hidden');
                        });

                        sidebarIcons.forEach(icon => {
                            icon.classList.remove('mx-auto');
                            icon.classList.add('mr-3');
                        });
                    } else {
                        // Switching to desktop
                        sidebar.classList.remove('sidebar-mobile', 'sidebar-mobile-hidden');
                        sidebar.classList.add('sidebar-expanded');
                        mainContent.classList.add('content-full');
                        overlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');

                        // Apply collapsed state if it was collapsed before
                        if (isSidebarCollapsed) {
                            toggleSidebarCollapse();
                        }
                    }
                }
            });

            // Initial setup
            if (isMobile) {
                sidebar.classList.add('sidebar-mobile-hidden');
                toggleBtn.setAttribute('aria-expanded', false);
            } else {
                sidebar.classList.add('sidebar-expanded');
                collapseBtn.setAttribute('aria-expanded', true);
                mainContent.classList.remove('content-expanded');
                mainContent.classList.remove('content-full');
            }

            // Add classes to sidebar elements
            document.querySelectorAll('#sidebar .nav-text').forEach(text => {
                text.classList.add('sidebar-text', 'text-fade-in');
            });

            document.querySelectorAll('#sidebar .section-title').forEach(title => {
                title.classList.add('sidebar-section-title');
            });

            document.querySelectorAll('#sidebar .nav-icon').forEach(icon => {
                icon.classList.add('sidebar-icon', 'mr-3');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>