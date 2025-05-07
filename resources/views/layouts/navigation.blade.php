<header id="header" class="bg-white shadow-sm">
    <div class="w-full px-4 sm:px-6 py-3 flex items-center justify-between">
        <!-- Left side - Title and Mobile Menu Button (hidden on desktop) -->
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button (hidden on lg screens) -->
            <button id="mobileMenuButton" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none">
                <i class="fas fa-bars h-5 w-5"></i>
            </button>
            
            <!-- Page Title -->
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800 truncate max-w-xs sm:max-w-md md:max-w-lg">
                @yield('title', 'Dashboard')
            </h1>
        </div>

        <!-- Right side - User/Auth Controls -->
        <div class="flex items-center space-x-3 sm:space-x-4">
            @auth
                <!-- User Dropdown (Desktop) -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- User Avatar -->
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Logout (hidden on desktop) -->
                <div class="md:hidden">
                    <form id="logout-form-header" action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-red-600 hover:text-red-800 rounded-full hover:bg-red-50" title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @else
                <!-- Guest Links -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ route('login') }}" class="text-sm px-3 py-1.5 rounded-md text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-sm px-3 py-1.5 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition-colors hidden sm:inline-block">
                        Register
                    </a>
                </div>
            @endauth
            
            <!-- Theme Toggle (optional) -->
            <button id="themeToggle" class="p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // User dropdown toggle
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function() {
                userDropdown.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                themeIcon.classList.toggle('fa-moon');
                themeIcon.classList.toggle('fa-sun');
            });
            
            // Check for saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        }
        
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                // This would toggle your sidebar
                document.getElementById('sidebar').classList.toggle('open');
                document.getElementById('overlay').classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });
        }
    });
</script>