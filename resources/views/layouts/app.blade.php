<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hospital Management System') }}</title>

    <link rel="shortcut icon" href="{{ asset('img/favicon1.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clock.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prescription.css') }}">

    <link href="{{ asset('bootstrap-5.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('bootstrap-4.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet"> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">

    <!-- DataTables Core -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    
    <!-- Responsive Extension -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">

        {{-- SIDEBAR --}}
        <div
            class="sidebar-modern fixed inset-y-0 left-0 z-40 w-64 overflow-y-auto transform transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            @include('layouts.sidebar')
        </div>
        
        <!-- OVERLAY -->
        <div
            class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
            x-show="sidebarOpen"
            x-transition
            @click="sidebarOpen = false"
            x-cloak
        ></div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col transition-all duration-300 lg:ml-64" :class="sidebarOpen ? 'ml-0' : ''">

            @include('layouts.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto"
                style="
                    min-height: 100vh;
                    background:linear-gradient(135deg,#f0f9ff 0%,#dbeafe 30%,#e0e7ff 55%,#ccfbf1 80%,#f0fdfa 100%);
                    background-size: 400% 400%;
                    animation: gradientMove 15s ease infinite;
                ">
                {{ $slot }}
            </main>

        </div>

        {{-- AUTO LOGOUT MODAL --}}
        <div id="logoutModal"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">

            <div style="background:#fff; padding:50px; border-radius:8px; text-align:center; width:300px;">
                <p>
                    You will be logged out in
                    <span id="countdown">10</span> seconds due to inactivity.
                </p>
            </div>
        </div>

    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

    <script src="{{ asset('bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('scripts')

</body>
</html>