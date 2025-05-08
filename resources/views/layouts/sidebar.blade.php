 <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:static inset-y-0 left-0 bg-white text-gray-700 shadow-lg z-50 transform lg:transform-none transition-all duration-300 ease-in-out flex flex-col border-r border-gray-200 flex-shrink-0">
            <!-- Sidebar Header -->
            <div
                class="p-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-white to-gray-50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                        <i class="fas fa-school text-white text-lg"></i>
                    </div>
                    <h2
                        class="text-xl font-bold uppercase tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 nav-text">
                        EduManage Pro
                    </h2>
                </div>
                <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700 transition-colors"
                    aria-label="Fermer la barre latérale">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Profile -->
            @auth
                <div class="p-4 border-b border-gray-200 flex items-center gap-3 bg-gray-50">
                    <div class="relative">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-white shadow-sm"></span>
                    </div>
                    <div class="overflow-hidden nav-text">
                        <p class="font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">
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
                       {{ Request::routeIs('dashboard') ? 'bg-indigo-100 text-indigo-800 border-l-4 border-indigo-500 shadow-sm active' : 'hover:bg-gray-100 hover:text-indigo-700' }}"
                            aria-current="{{ Request::routeIs('dashboard') ? 'page' : 'false' }}">
                            <i
                                class="fas fa-tachometer-alt text-lg w-6 text-center nav-icon {{ Request::routeIs('dashboard') ? 'text-indigo-700' : 'text-gray-500 group-hover:text-indigo-600' }}"></i>
                            <span class="font-medium nav-text">Tableau de bord</span>
                            <i
                                class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-opacity nav-text {{ Request::routeIs('dashboard') ? 'text-indigo-700' : 'text-gray-400' }}"></i>
                        </a>
                    @endauth

                    <!-- Profile -->
                    @auth
                        <a href="{{ route('profile.edit') }}"
                            class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs('profile.*') ? 'bg-indigo-100 text-indigo-800 border-l-4 border-indigo-500 shadow-sm active' : 'hover:bg-gray-100 hover:text-indigo-700' }}"
                            aria-current="{{ Request::routeIs('profile.*') ? 'page' : 'false' }}">
                            <i
                                class="fas fa-user text-lg w-6 text-center nav-icon {{ Request::routeIs('profile.*') ? 'text-indigo-700' : 'text-gray-500 group-hover:text-indigo-600' }}"></i>
                            <span class="font-medium nav-text">Profil</span>
                            <i
                                class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-opacity nav-text {{ Request::routeIs('profile.*') ? 'text-indigo-700' : 'text-gray-400' }}"></i>
                        </a>
                    @endauth

                    <!-- Students & Guardians Section -->
                    @if (auth()->check() && auth()->user()->hasRole('admin'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                            <span class="w-4 h-px bg-gray-300 mr-2"></span>
                            <span class="nav-text">Étudiants & Parents</span>
                            <span class="w-4 h-px bg-gray-300 ml-2"></span>
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
                       {{ Request::routeIs($route . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center nav-icon {{ Request::routeIs($route . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                                <span class="nav-text">{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <!-- Academic Section -->
                    @if (auth()->check() &&
                            auth()->user()->hasAnyRole(['admin', 'teacher', 'accountant']))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                            <span class="w-4 h-px bg-gray-300 mr-2"></span>
                            <span class="nav-text">Académique</span>
                            <span class="w-4 h-px bg-gray-300 ml-2"></span>
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
                                'absences' => [
                                    'icon' => 'calendar-times',
                                    'title' => 'Absences',
                                    'roles' => ['admin', 'teacher'],
                                ],
                            ];
                        @endphp

                        @foreach ($academic as $route => $data)
                            @if (auth()->user()->hasAnyRole($data['roles']))
                                <a href="{{ route($route . '.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                           {{ Request::routeIs($route . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                                    aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                    <i
                                        class="fas fa-{{ $data['icon'] }} w-6 text-center nav-icon {{ Request::routeIs($route . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                                    <span class="nav-text">{{ $data['title'] }}</span>
                                    @if (Request::routeIs($route . '.*'))
                                        <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    @endif

                    <!-- Administration Section -->
                    @if (auth()->check() && auth()->user()->hasRole('admin'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                            <span class="w-4 h-px bg-gray-300 mr-2"></span>
                            <span class="nav-text">Administration</span>
                            <span class="w-4 h-px bg-gray-300 ml-2"></span>
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
                       {{ Request::routeIs($route . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center nav-icon {{ Request::routeIs($route . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                                <span class="nav-text">{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <!-- Student Specific: Grades and Timetables -->
                    @if (auth()->check() && auth()->user()->hasRole('student'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                            <span class="w-4 h-px bg-gray-300 mr-2"></span>
                            <span class="nav-text">Mes Données</span>
                            <span class="w-4 h-px bg-gray-300 ml-2"></span>
                        </div>

                        @php
                            $student = [
                                'grades' => ['icon' => 'award', 'title' => 'Mes Notes'],
                                'timetables' => ['icon' => 'calendar-alt', 'title' => 'Mon Emploi du temps'],
                                'absences' => ['icon' => 'calendar-times', 'title' => 'Mes Absences'],
                            ];
                        @endphp

                        @foreach ($student as $route => $data)
                            <a href="{{ route($route . '.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs($route . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center nav-icon {{ Request::routeIs($route . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                                <span class="nav-text">{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @endif

                    <!-- Events Management -->
                    @if(auth()->check())
                    <div
                        class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                        <span class="w-4 h-px bg-gray-300 mr-2"></span>
                        <span class="nav-text">Événements</span>
                        <span class="w-4 h-px bg-gray-300 ml-2"></span>
                    </div>

                    @php
                        $eventRoutes = [
                            ['route' => 'events.index', 'icon' => 'calendar-day', 'title' => 'Événements'],
                            ['route' => 'events.calendar', 'icon' => 'calendar-alt', 'title' => 'Calendrier'],
                            ['route' => 'event_registrations.index', 'icon' => 'clipboard-list', 'title' => 'Inscriptions'],
                        ];

                        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('accountant')) {
                            $eventRoutes[] = ['route' => 'event_payments.index', 'icon' => 'receipt', 'title' => 'Paiements'];
                        }
                    @endphp

                    @foreach ($eventRoutes as $item)
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                   {{ Request::routeIs(explode('.', $item['route'])[0] . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                            aria-current="{{ Request::routeIs(explode('.', $item['route'])[0] . '.*') ? 'page' : 'false' }}">
                            <i
                                class="fas fa-{{ $item['icon'] }} w-6 text-center nav-icon {{ Request::routeIs(explode('.', $item['route'])[0] . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                            <span class="nav-text">{{ $item['title'] }}</span>
                            @if (Request::routeIs(explode('.', $item['route'])[0] . '.*'))
                                <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                            @endif
                        </a>
                    @endforeach
                    @endif

                    <!-- Guardian Specific: Children's Data -->
                    @if (auth()->check() && auth()->user()->hasRole('guardian'))
                        <div
                            class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 flex items-center section-title">
                            <span class="w-4 h-px bg-gray-300 mr-2"></span>
                            <span class="nav-text">Données des Enfants</span>
                            <span class="w-4 h-px bg-gray-300 ml-2"></span>
                        </div>

                        @php
                            $guardian = [
                                'grades' => ['icon' => 'award', 'title' => 'Notes'],
                                'absences' => ['icon' => 'calendar-times', 'title' => 'Absences'],
                            ];
                        @endphp

                        @foreach ($guardian as $route => $data)
                            <a href="{{ route($route . '.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 mx-2
                       {{ Request::routeIs($route . '.*') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 active' : 'hover:bg-gray-50 hover:text-indigo-600' }}"
                                aria-current="{{ Request::routeIs($route . '.*') ? 'page' : 'false' }}">
                                <i
                                    class="fas fa-{{ $data['icon'] }} w-6 text-center nav-icon {{ Request::routeIs($route . '.*') ? 'text-indigo-600' : 'text-gray-500' }}"></i>
                                <span class="nav-text">{{ $data['title'] }}</span>
                                @if (Request::routeIs($route . '.*'))
                                    <div class="ml-auto w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach

                        <!-- Link to view children profiles -->
                        @php
                            $guardian = \App\Models\Guardian::where('user_id', auth()->id())->first();
                            $hasChildren = $guardian && $guardian->students->count() > 0;
                        @endphp

                        @if($hasChildren)
                            <div class="px-4 py-2 mt-2">
                                <p class="text-xs text-gray-500 mb-2">Mes enfants:</p>
                                @foreach($guardian->students as $student)
                                    <a href="{{ route('students.show', $student->id) }}"
                                       class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 hover:text-indigo-700 transition-all duration-200 mb-1">
                                        <div class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center text-xs text-white">
                                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm truncate">{{ $student->first_name }} {{ $student->last_name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </nav>
            </div>

            <!-- Logout / Login -->
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white transition-all duration-200 group shadow-md">
                            <i class="fas fa-sign-out-alt text-white nav-icon"></i>
                            <span class="nav-text">Déconnexion</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-white/70 group-hover:text-white nav-text"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white transition-all duration-200 group mb-3 shadow-md">
                        <i class="fas fa-sign-in-alt text-white nav-icon"></i>
                        <span class="nav-text">Connexion</span>
                        <i class="fas fa-chevron-right ml-auto text-xs text-white/70 group-hover:text-white nav-text"></i>
                    </a>
                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-gray-900 transition-all duration-200 mb-2 group shadow-md">
                        <i class="fas fa-user-plus text-gray-600 group-hover:text-gray-900 nav-icon"></i>
                        <span class="nav-text">Inscription</span>
                        <i class="fas fa-chevron-right ml-auto text-xs text-gray-500 group-hover:text-gray-900 nav-text"></i>
                    </a>
                @endauth
            </div>
        </aside>