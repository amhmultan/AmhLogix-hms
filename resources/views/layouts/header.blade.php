<header class="container-fluid mx-auto bg-white shadow-md px-4 py-2">
    <div class="flex justify-between items-center w-full">
        
        <!-- Left Side -->
        
        <button
            type="button"
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden text-xl p-2"
        >
            <i class="fas fa-bars"></i>
        </button>

        <div class="w-1/3 text-left">
            <h3 class="text-blue-700 text-base font-semibold">
                Welcome: {{ auth()->user()->name }}
            </h3>
            <p class="text-yellow-600 text-sm font-medium">
                Role:
                @foreach(auth()->user()->roles as $role)
                    {{ $role->name }}
                @endforeach
            </p>
        </div>

        <!-- Middle (Clock / Alerts) -->
        <div class="w-1/3 text-center">
            @if(!session()->has('success') && !session()->has('error') && !$errors->any())
                <x-digital-clock />
            @else
                @if(session()->has('success'))
                    <div class="text-green-600 text-sm">
                        <ul>
                            <li>{!! session('success') !!}</li>
                        </ul>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="text-red-600 text-sm">
                        <ul>
                            <li>{!! session('error') !!}</li> 
                        </ul>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="text-red-600 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>

        <!-- Right Side (User Menu) -->
        <div class="w-1/3 text-right">
            <div class="dropdown d-inline-block">
                <button class="btn dropdown-toggle p-0 border-0 bg-transparent" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ url('/img/logo.png') }}" alt="AMH Logix Logo"
                        class="rounded-circle" height="80" width="80">
                </button>

                <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm border-0 rounded" aria-labelledby="userDropdown" style="min-width: 160px;">
                    {{-- <li class="px-3 py-2 text-muted small">
                        {{ auth()->user()->name }}<br>
                        <span class="text-secondary">
                            @foreach(auth()->user()->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </span>
                    </li> --}}
                    {{-- <li><hr class="dropdown-divider"></li> --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.users.show', auth()->user()->id) }}">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>


    </div>
</header>