<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('img/favicon1.ico') }}">
        
        <!-- Custom Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/clock.css') }}">
        <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('css/prescription.css') }}">

        <!-- Bootstrap Styles Links -->
        <link href="{{ asset('bootstrap-5.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap-4.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- FontAwsome 6.2.1 Icons -->
        <link href="{{ asset('fontawesome-free-6.2.1-web/css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('fontawesome-free-6.2.1-web/css/regular.min.css') }}" rel="stylesheet">
        <link href="{{ asset('fontawesome-free-6.2.1-web/css/solid.min.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Orbitron Font -->
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
        
        <!-- JQuery Styles -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        
        @stack('styles')

    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            @include('layouts.sidebar')
            
            <div class="flex-1 flex flex-col overflow-scroll">
                
                @include('layouts.header')

                {{ $slot }}

            </div>
            <!-- Auto Logout Warning Modal -->
            <div id="logoutModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
                background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
                <div style="background:#fff; padding:50px; border-radius:8px; text-align:center; width:300px; font-size:30px; text-align:justify; font-weight:bold;">
                    <p id="logoutMessage">You will be logged out in <span id="countdown">10</span> seconds due to inactivity.</p>
                </div>
            </div>
        </div>
        
        <!-- JS Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

        <!-- Bootstrap -->
        <script src="{{ asset('bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') }}"></script>
        
        <!-- Session out Script -->
        <script>
        (function() {
            let timer;
            const sessionLifetime = 1200000; // 20 minutes
            const warningTime = 10000; // show warning 10 seconds before logout
            let countdownInterval;

            const modal = document.getElementById('logoutModal');
            const countdownEl = document.getElementById('countdown');
            const stayButton = document.getElementById('stayLoggedIn');

            function resetTimer() {
                clearTimeout(timer);
                clearInterval(countdownInterval);
                hideModal();
                timer = setTimeout(showWarning, sessionLifetime - warningTime);
            }

            function showWarning() {
                let countdown = warningTime / 1000;
                countdownEl.textContent = countdown;
                modal.style.display = 'flex';

                countdownInterval = setInterval(() => {
                    countdown--;
                    countdownEl.textContent = countdown;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        logoutUser();
                    }
                }, 1000);
            }

            function hideModal() {
                modal.style.display = 'none';
            }

            function logoutUser() {
                fetch("{{ route('admin.logout') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    window.location.href = '/AmhLogix-hms/public/admin/login';
                }).catch((err) => {
                    console.error('Logout error:', err);
                });
            }

            // Reset timer on any user activity
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;
        })();
        </script>

        @stack('scripts')

    </body>
</html>