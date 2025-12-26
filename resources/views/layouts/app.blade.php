<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hospital</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex">

    <aside class="w-64 bg-gradient-to-br from-blue-700 to-blue-900 text-white shadow-lg flex flex-col rounded-r-xl">
        <div class="p-6 border-b border-blue-800 flex items-center justify-center">
            <h1 class="text-2xl font-bold tracking-wide">KHAZIR HOSPITAL</h1>
        </div>
        <nav class="flex-grow p-4">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Dashboard</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('patients.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M12 20.052v-8.3M15 7.052h2.5a1.5 1.5 0 011.5 1.5v5a1.5 1.5 0 01-1.5 1.5H12m-3-10V4.5a1.5 1.5 0 011.5-1.5h3.5a1.5 1.5 0 011.5 1.5V7">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Patients</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('doctors.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Doctors</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('departments.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Departments</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('specialities.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-lg font-medium">Specialities</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('floors.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="text-lg font-medium">Floors</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('rooms.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-lg font-medium">Rooms</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('doctor_types.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-lg font-medium">Doctor Types</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('shifts.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-lg font-medium">Shifts</span>
                    </a>
                </li>
                 <li class="mb-2">
                    <a href="{{ route('emergency.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Emergency</span>
                    </a>
                </li>
                 <li class="mb-2">
                    <a href="{{ route('emergency_charges.add') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-lg font-medium">Emergency Charges</span>
                    </a>
                </li>
                @if(Auth::user()->hasPermission('view_lab_requests'))
                <li class="mb-2">
                    <a href="{{ route('laboratory.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Laboratory</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->hasPermission('view_radiology_requests'))
                <li class="mb-2">
                    <a href="{{ route('radiology.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-lg font-medium">Radiology</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->hasPermission('prescribe_medicine'))
                <li class="mb-2">
                    <a href="{{ route('prescriptions.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <span class="text-lg font-medium">My Prescriptions</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->hasPermission('manage_pharmacy_stock'))
                <li class="mb-2">
                    <a href="{{ route('pharmacy.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span class="text-lg font-medium">Pharmacy Stock</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->hasPermission('dispense_medicine'))
                <li class="mb-2">
                    <a href="{{ route('pharmacy.dispense_index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-lg font-medium">Dispense Medicine</span>
                    </a>
                </li>
                @endif
                 <li class="mb-2">
                    <a href="{{ route('day-care.create') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="text-lg font-medium">Day Care Procedures</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('store.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">Store</span>
                    </a>
                </li>
                 <li class="mb-2">
                    <a href="{{ route('opd.consultation') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span class="text-lg font-medium">OPD Consultation</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.user_manager') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V5M6 16V9a2 2 0 00-2-2H3">
                            </path>
                        </svg>
                        <span class="text-lg font-medium">User Manager</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-blue-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center p-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 ease-in-out w-full text-left">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="text-lg font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm py-4 px-6 flex items-center justify-between rounded-bl-xl">
            <h2 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h2>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, {{ Auth::user()->name }}!</span>
                <div
                    class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center text-blue-800 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}</div>
            </div>
        </header>

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>

</html>
