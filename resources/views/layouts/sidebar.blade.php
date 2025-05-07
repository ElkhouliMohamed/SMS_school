 <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:static inset-y-0 left-0 w-72 bg-gray-900 text-white shadow-2xl z-50 transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out flex flex-col border-r border-gray-800">
            <!-- Sidebar Header -->
            <div
                class="p-5 border-b border-gray-800 flex items-center justify-between bg-gradient-to-r from-gray-900 to-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-md">
                        <i class="fas fa-school text-gray-900 text-lg"></i>
                    </div>
                    <h2
                        class="text-xl font-bold uppercase tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-300">
                        EduManage Pro
                    </h2>
                </div>
                <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-blue-400 transition-colors"
                    aria-label="Fermer la barre latérale">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Profile -->
            @auth
                <div class="p-4 border-b border-gray-800 flex items-center gap-3 bg-gray-850">
                    <div class="relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center text-gray-900 font-bold shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-900 shadow-sm"></span>
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-semibold text-gray-100 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">
                            {{ Auth::user()->has('roles') ? Auth::user()->roles->first()->name : 'Unknown Role'  }}
                        </p>
                    </div>
                </div>
            @endauth

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-2 custom-scrollbar">
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs('dashboard') ? 'bg-blue-600 text-gray-900 shadow-md active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                            aria-current="{{ Request::routeIs('dashboard') ? 'page' : 'false' }}">
                            <i
                                class="fas fa-tachometer-alt text-lg w-6 text-center {{ Request::routeIs('dashboard') ? 'text-gray-900' : 'text-blue-500 group-hover:text-blue-400' }}"></i>
                            <span class="font-medium">Tableau de bord</span>
                            <i
                                class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-opacity {{ Request::routeIs('dashboard') ? 'text-gray-900' : 'text-gray-500' }}"></i>
                        </a>
                    @endauth

                    <!-- Profile -->
                    @auth
                        <a href="{{ route('profile.edit') }}"
                            class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs('profile.*') ? 'bg-blue-600 text-gray-900 shadow-md active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                            aria-current="{{ Request::routeIs('profile.*') ? 'page' : 'false' }}">
                            <i
                                class="fas fa-user text-lg w-6 text-center {{ Request::routeIs('profile.*') ? 'text-gray-900' : 'text-blue-500 group-hover:text-blue-400' }}"></i>
                            <span class="font-medium">Profil</span>
                            <i
                                class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-opacity {{ Request::routeIs('profile.*') ? 'text-gray-900' : 'text-gray-500' }}"></i>
                        </a>
                    @endauth

                    <!-- Students & Guardians Section -->
                    @if (auth()->check() && auth()->user()->hasRole('admin'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center">
                            <span class="w-4 h-px bg-gray-700 mr-2"></span>
                            Étudiants & Parents
                            <span class="w-4 h-px bg-gray-700 ml-2"></span>
                        </div>

                        @php
                            $sections = [
                                'students' => ['icon' => 'user-graduate', 'title' => 'Étudiants'],
                                'guardians' => ['icon' => 'users', 'title' => 'Parents'],
                                'grades' => ['icon' => 'award', 'title' => 'Notes'],
                            ];
                        @endphp

                        @foreach ($sections as $route => $data)
                            <a href="{{ route($route . '.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs($route . '.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-500 active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center {{ Request::routeIs($route . '.*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                                <span>{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <!-- Academic Section -->
                    @if (auth()->check() &&
                            auth()->user()->hasAnyRole(['admin', 'teacher', 'accountant']))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center">
                            <span class="w-4 h-px bg-gray-700 mr-2"></span>
                            Académique
                            <span class="w-4 h-px bg-gray-700 ml-2"></span>
                        </div>

                        @php
                            $academic = [
                                'teachers' => [
                                    'icon' => 'chalkboard-teacher',
                                    'title' => 'Enseignants',
                                    'roles' => ['admin'],
                                ],
                                'school_classes' => ['icon' => 'door-open', 'title' => 'Classes', 'roles' => ['admin']],
                                'subjects' => [
                                    'icon' => 'book-open',
                                    'title' => 'Matières',
                                    'roles' => ['admin', 'teacher'],
                                ],
                                'timetables' => [
                                    'icon' => 'calendar-alt',
                                    'title' => 'Emplois du temps',
                                    'roles' => ['admin', 'teacher'],
                                ],
                                'payments' => [
                                    'icon' => 'money-bill-wave',
                                    'title' => 'Paiements',
                                    'roles' => ['admin', 'accountant'],
                                ],
                            ];
                        @endphp

                        @foreach ($academic as $route => $data)
                            @if (auth()->user()->hasAnyRole($data['roles']))
                                <a href="{{ route($route . '.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                           {{ Request::routeIs($route . '.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-500 active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                                    aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                    <i
                                        class="fas fa-{{ $data['icon'] }} w-6 text-center {{ Request::routeIs($route . '.*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                                    <span>{{ $data['title'] }}</span>
                                    @if (Request::routeIs($route . '.*'))
                                        <div class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    @endif

                    <!-- Administration Section -->
                    @if (auth()->check() && auth()->user()->hasRole('admin'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center">
                            <span class="w-4 h-px bg-gray-700 mr-2"></span>
                            Administration
                            <span class="w-4 h-px bg-gray-700 ml-2"></span>
                        </div>

                        @php
                            $admin = [
                                'educational_levels' => ['icon' => 'layer-group', 'title' => 'Niveaux scolaires'],
                                'transports' => ['icon' => 'bus', 'title' => 'Transports'],
                            ];
                        @endphp

                        @foreach ($admin as $route => $data)
                            <a href="{{ route($route . '.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs($route . '.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-500 active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center {{ Request::routeIs($route . '.*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                                <span>{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <!-- Student/Teacher Specific: Grades and Timetables -->
                    @if (auth()->check() && auth()->user()->hasRole('student'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center">
                            <span class="w-4 h-px bg-gray-700 mr-2"></span>
                            Mes Données
                            <span class="w-4 h-px bg-gray-700 ml-2"></span>
                        </div>

                        @php
                            $student = [
                                'grades' => ['icon' => 'award', 'title' => 'Mes Notes'],
                                'timetables' => ['icon' => 'calendar-alt', 'title' => 'Mon Emploi du temps'],
                            ];
                        @endphp

                        @foreach ($student as $route => $data)
                            <a href="{{ route($route . '.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs($route . '.*') ? 'bg-gray-800 text-blue-400 border-l-4 border-blue-500 active' : 'hover:bg-gray-800 hover:text-blue-400' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center {{ Request::routeIs($route . '.*') ? 'text-blue-400' : 'text-gray-400' }}"></i>
                                <span>{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif
                </nav>
            </div>

            <!-- Logout / Login -->
            <div class="p-4 border-t border-gray-800 bg-gray-850">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-blue-400 transition-all duration-200 group">
                            <i class="fas fa-sign-out-alt text-gray-400 group-hover:text-blue-400"></i>
                            <span>Déconnexion</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-gray-600 group-hover:text-blue-400"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-blue-400 transition-all duration-200 group mb-2">
                        <i class="fas fa-sign-in-alt text-gray-400 group-hover:text-blue-400"></i>
                        <span>Connexion</span>
                        <i class="fas fa-chevron-right ml-auto text-xs text-gray-600 group-hover:text-blue-400"></i>
                    </a>
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-blue-400 transition-all duration-200 mb-2 group">
                        <i class="fas fa-user-plus text-gray-400 group-hover:text-blue-400"></i>
                        <span>Inscription</span>
                        <i class="fas fa-chevron-right ml-auto text-xs text-gray-600 group-hover:text-blue-400"></i>
                    </a>
                @endauth
            </div>
        </aside>