    {{-- Logo --}}
    <div class="sidebar-logo text-center">
        <div>
            <h1 class="font-bold text-center tracking-wider text-4xl" style="color:#DF752E">Amh<span class="text-primary">Logix</span></h1>
            <h6 class="text-indigo-200">Hospital Management System</span></h6>
        </div>
    </div>

    {{-- Searchbar --}}
    <div class="sidebar-search relative" data-widget="sidebar-search">
        <span class="absolute inset-y-0 right-0 flex items-center pr-6">
            <svg class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none">
                <path
                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                </path>
            </svg>
        </span>

        <input
            class="form-input w-32 sm:w-60 rounded-md pl-10 pr-2 bg-white text-gray-900 placeholder-gray-400 focus:border-indigo-600 focus:ring-0"
            type="text"
            placeholder="Search Menu"
            id="search"
            autofocus>
    </div>


    <nav class="mt-1 pt-1">

        {{-- General Menu Starting --}}
        <h6 class="sidebar-title">
            <span>General</span>
        </h6>

        <a class="sidebar-link {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }} " href="{{ route('admin.dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        {{-- Users Sub Menu Starting --}}
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0" id="menu">
            <li>
                @canany('UserMenu access')
                <a href="#submenu1"
                    data-bs-toggle="collapse"
                    class="dropdown-toggle sidebar-link {{ Route::currentRouteNamed('admin.users.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc">
                        <g>
                            <rect fill="none" height="24" width="24" />
                        </g>
                        <g>
                            <g>
                                <path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M7.35,18.5C8.66,17.56,10.26,17,12,17 s3.34,0.56,4.65,1.5C15.34,19.44,13.74,20,12,20S8.66,19.44,7.35,18.5z M18.14,17.12L18.14,17.12C16.45,15.8,14.32,15,12,15 s-4.45,0.8-6.14,2.12l0,0C4.7,15.73,4,13.95,4,12c0-4.42,3.58-8,8-8s8,3.58,8,8C20,13.95,19.3,15.73,18.14,17.12z" />
                                <path d="M12,6c-1.93,0-3.5,1.57-3.5,3.5S10.07,13,12,13s3.5-1.57,3.5-3.5S13.93,6,12,6z M12,11c-0.83,0-1.5-0.67-1.5-1.5 S11.17,8,12,8s1.5,0.67,1.5,1.5S12.83,11,12,11z" />
                            </g>
                        </g>
                    </svg>
                    <span class="mx-3">Users Management</span>
                </a>
                @endcan

                <ul class="collapse sidebar-submenu" id="submenu1" data-bs-parent="#menu">
                    <li>
                        @canany('User access','User add','User edit','User delete')
                        <a href="{{ route('admin.users.index')}}" class="sidebar-sublink {{ Route::currentRouteNamed('admin.users.index') ? 'active' : '' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>

                            <span class="ml-3">User Information</span>
                        </a>
                        @endcanany
                    </li>
                    <li>
                        @canany('Role access','Role add','Role edit','Role delete')
                        <a href="{{ route('admin.roles.index') }}" class="sidebar-sublink {{ Route::currentRouteNamed('admin.roles.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                            <span class="ml-3">User Roles</span>
                        </a>
                        @endcanany
                    </li>
                    <li>
                        @canany('Permission access','Permission add','Permission edit','Permission delete')
                        <a href="{{ route('admin.permissions.index') }}" class="sidebar-sublink {{ Route::currentRouteNamed('admin.permissions.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                            </svg>
                            <span class="ml-3">User Permissions</span>
                        </a>
                        @endcanany
                    </li>

                </ul>
                {{-- Users Sub Menu End --}}

                <!-- @canany('Post access','Post add','Post edit','Post delete')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.posts.index') ? 'active' : '' }}"
                    href="{{ route('admin.posts.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc">
                        <rect fill="none" height="24" width="24" />
                        <path d="M3,10h11v2H3V10z M3,8h11V6H3V8z M3,16h7v-2H3V16z M18.01,12.87l0.71-0.71c0.39-0.39,1.02-0.39,1.41,0l0.71,0.71 c0.39,0.39,0.39,1.02,0,1.41l-0.71,0.71L18.01,12.87z M17.3,13.58l-5.3,5.3V21h2.12l5.3-5.3L17.3,13.58z" />
                    </svg>

                    <span class="mx-3">Post Information</span>
                </a>
                @endcanany -->

                {{-- Configurations Sub Menu Starting --}}
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0" id="menu">
                    <li>
                        @canany('Configuration access')
                        <a href="#configsubmenu" data-bs-toggle="collapse" class="dropdown-toggle sidebar-link">

                            <svg enable-background="new 0 0 32 32" id="Editable-line" version="1.1" viewBox="0 0 32 32" height="24px" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <circle cx="16" cy="16" fill="#62adfc" id="XMLID_224_" r="4" stroke="#62adfc" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" />
                                <path d="  M27.758,10.366l-1-1.732c-0.552-0.957-1.775-1.284-2.732-0.732L23.5,8.206C21.5,9.36,19,7.917,19,5.608V5c0-1.105-0.895-2-2-2h-2  c-1.105,0-2,0.895-2,2v0.608c0,2.309-2.5,3.753-4.5,2.598L7.974,7.902C7.017,7.35,5.794,7.677,5.242,8.634l-1,1.732  c-0.552,0.957-0.225,2.18,0.732,2.732L5.5,13.402c2,1.155,2,4.041,0,5.196l-0.526,0.304c-0.957,0.552-1.284,1.775-0.732,2.732  l1,1.732c0.552,0.957,1.775,1.284,2.732,0.732L8.5,23.794c2-1.155,4.5,0.289,4.5,2.598V27c0,1.105,0.895,2,2,2h2  c1.105,0,2-0.895,2-2v-0.608c0-2.309,2.5-3.753,4.5-2.598l0.526,0.304c0.957,0.552,2.18,0.225,2.732-0.732l1-1.732  c0.552-0.957,0.225-2.18-0.732-2.732L26.5,18.598c-2-1.155-2-4.041,0-5.196l0.526-0.304C27.983,12.546,28.311,11.323,27.758,10.366z  " fill="none" id="XMLID_242_" stroke="#62adfc" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" />
                            </svg>

                            <span class="mx-3">Settings</span>
                        </a>
                        @endcan

                        <ul class="collapse sidebar-submenu" id="configsubmenu" data-bs-parent="#menu">
                            <li>

                                @canany('HospitalConfig access','HospitalConfig create','HospitalConfig edit','HospitalConfig delete')
                                <a class="sidebar-sublink {{ Route::currentRouteNamed('admin.hospitals.index') ? 'active' : '' }}"
                                    href="{{ route('admin.hospitals.index')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>

                                    <span class="mx-3">Hospital Config</span>
                                </a>
                                @endcanany

                                @canany('PharmacyConfig access','PharmacyConfig add','PharmacyConfig edit','PharmacyConfig delete')
                                <a href="{{ route('admin.pharmacies.index')}}" class="sidebar-sublink {{ Route::currentRouteNamed('admin.pharmacies.index') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                    <span class="ml-3">Pharmacy Config</span>
                                </a>
                                @endcanany

                                @canany('Backup access','Backup create','Backup delete', 'Backup download', 'Backup restore')
                                <a href="{{ route('admin.backups.index')}}" class="sidebar-sublink {{ Route::currentRouteNamed('admin.backups.index') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                    </svg>
                                    <span class="ml-3">Backup Management</span>
                                </a>
                                @endcanany

                            </li>
                        </ul>
                    </li>
                </ul>

                {{-- Configurations Sub Menu End --}}

                {{-- General Menu Ending --}}

                {{-- Hospital Menu Starting --}}
                @can('Hospital access')
                <h6 class="sidebar-title">
                    <span>Hospital</span>
                </h6>
                @endcan

                @canany('Appointment access','Appointment create','Appointment edit','Appointment delete')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.appointments.index') ? 'active' : '' }}"
                    href="{{ route('admin.appointments.index')}}">

                    <svg fill="#62adfc" width="25px" height="25px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>calendar</title>
                        <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-1.952-1.12-3.488t-2.88-2.144v2.624q0 1.248-0.864 2.144t-2.144 0.864-2.112-0.864-0.864-2.144v-3.008h-12v3.008q0 1.248-0.896 2.144t-2.112 0.864-2.144-0.864-0.864-2.144v-2.624q-1.76 0.64-2.88 2.144t-1.12 3.488v20zM4 26.016v-16h24v16q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM6.016 3.008q0 0.416 0.288 0.704t0.704 0.288 0.704-0.288 0.288-0.704v-3.008h-1.984v3.008zM8 24h4v-4h-4v4zM8 18.016h4v-4h-4v4zM14.016 24h4v-4h-4v4zM14.016 18.016h4v-4h-4v4zM20 24h4v-4h-4v4zM20 18.016h4v-4h-4v4zM24 3.008q0 0.416 0.288 0.704t0.704 0.288 0.704-0.288 0.32-0.704v-3.008h-2.016v3.008z"></path>
                    </svg>

                    <span class="mx-3">Appointments</span>
                </a>
                @endcanany

                @canany('Patient access','Patient add','Patient edit','Patient delete')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.patients.index') ? 'active' : '' }}"
                    href="{{ route('admin.patients.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc">
                        <rect fill="none" height="24" width="24" />
                        <path d="M12,10c2.21,0,4-1.79,4-4c0-2.21-1.79-4-4-4S8,3.79,8,6C8,8.21,9.79,10,12,10z M12,4c1.1,0,2,0.9,2,2c0,1.1-0.9,2-2,2 s-2-0.9-2-2C10,4.9,10.9,4,12,4z M18.39,12.56C16.71,11.7,14.53,11,12,11c-2.53,0-4.71,0.7-6.39,1.56C4.61,13.07,4,14.1,4,15.22V22 h2v-6.78c0-0.38,0.2-0.72,0.52-0.88C7.71,13.73,9.63,13,12,13c0.76,0,1.47,0.07,2.13,0.2l-1.55,3.3H9.75C8.23,16.5,7,17.73,7,19.25 C7,20.77,8.23,22,9.75,22h2.18H18c1.1,0,2-0.9,2-2v-4.78C20,14.1,19.39,13.07,18.39,12.56z M10.94,20H9.75C9.34,20,9,19.66,9,19.25 c0-0.41,0.34-0.75,0.75-0.75h1.89L10.94,20z M18,20h-4.85l2.94-6.27c0.54,0.2,1.01,0.41,1.4,0.61C17.8,14.5,18,14.84,18,15.22V20z" />
                    </svg>

                    <span class="mx-3">Patient Registration</span>
                </a>
                @endcanany

                @canany('Token access','Token add','Token edit','Token delete')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.tokens.index') ? 'active' : '' }}"
                    href="{{ route('admin.tokens.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc">
                        <rect fill="none" height="24" width="24" />
                        <path d="M9,4c-4.42,0-8,3.58-8,8c0,4.42,3.58,8,8,8s8-3.58,8-8C17,7.58,13.42,4,9,4z M12,10.5h-2v5H8v-5H6V9h6V10.5z M20.25,3.75 L23,5l-2.75,1.25L19,9l-1.25-2.75L15,5l2.75-1.25L19,1L20.25,3.75z M20.25,17.75L23,19l-2.75,1.25L19,23l-1.25-2.75L15,19l2.75-1.25 L19,15L20.25,17.75z" />
                    </svg>

                    <span class="mx-3">Token Info</span>
                </a>
                @endcanany

                @canany('DoctorNotes access','DoctorNotes add','DoctorNotes edit','DoctorNotes delete')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.doctor_notes.index') ? 'active' : '' }}"
                    href="{{ route('admin.doctor_notes.index')}}">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.899 490.899" style="enable-background:new 0 0 490.899 490.899;" xml:space="preserve" height="24px" width="24px" fill="#62adfc">
                        <g>
                            <path d="M474.5,330.849l-104.3-104.3v-167.8c0-11.5-9.4-20.9-20.9-20.9h-73v-16.6c0-11.5-9.4-20.9-20.9-20.9H114.8 c-11.5,0-20.9,9.4-20.9,20.9v16.7h-73c-11.5,0-20.9,9.4-20.9,20.9v410.8c0,11.5,9.4,20.9,20.9,20.9h328.4 c11.5,0,20.9-9.4,20.9-20.9v-30.3c21.6,21.6,65.1,20.5,95.9-10.3C495.3,399.649,499.5,355.849,474.5,330.849z M135.6,41.049h99 v35.4h-99V41.049z M40.8,449.649v-370.1H94v16.7c0,11.5,9.4,20.9,20.9,20.9h140.6c10.4,0,19.8-9.4,20.9-19.8v-17.8h52.1v115.6 l-89.7-16.6c-7-3-25,3.1-22.9,22.9l17.7,95.9c0,4.2,2.1,7.3,5.2,10.4l89.7,89.7v52.1H40.8V449.649z M436.9,399.649 c-8.3,7.3-27.1,18.5-40.7,8.3l-124-124l-11.5-60.5l59.4,11.5l125.1,125.1C452.6,367.349,451.5,385.049,436.9,399.649z" />
                        </g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                        <g></g>
                    </svg>

                    <span class="mx-3">Doctor Notes</span>
                </a>
                @endcanany

                {{-- IPD Menu Start --}}
                @can('IPD access')
                <a class="sidebar-link {{ route::currentroutenamed('admin.ipd.index') ? 'active' : '' }}" href="{{ route('admin.ipd.index')}}">
                    <svg width="24px" height="24px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg">

                        <g fill="#62adfc">

                            <path d="M22 142.576h10.702M22 114.712h10.702M22 22v148h148M21.995 32.934h10.702m-10.702 27.32h10.702M21.995 87.356h10.702" style="#62adfc:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="#62adfc" />

                            <path d="M68.842 128.695a10.782 10.782 0 0 1-10.781 10.781 10.782 10.782 0 0 1-10.782-10.781 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782zM95.06 76.358A10.782 10.782 0 0 1 84.277 87.14a10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782Zm43.576 36.396a10.782 10.782 0 0 1-10.782 10.781 10.782 10.782 0 0 1-10.781-10.781 10.782 10.782 0 0 1 10.781-10.782 10.782 10.782 0 0 1 10.782 10.782zm21.604-73.396a10.782 10.782 0 0 1-10.782 10.782 10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.781 10.782 10.782 0 0 1 10.781 10.781z" style="fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;paint-order:stroke fill markers" />

                            <path d="m64.38 118.198 14.117-31.362m15.08-2.424 24.333 21.124m13.668-4.067 15.53-52.393" style="fill:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:8;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="none" />

                        </g>

                    </svg>

                    <span class="mx-3">IPD Dashboard</span>
                </a>
                @endcan

                {{-- IPD Menu End --}}

                @canany('TokenReport access')
                <a class="sidebar-link {{ Route::currentRouteNamed('admin.tokens.token_report') ? 'active' : '' }}"
                    href="{{ route('admin.tokens.token_report') }}">
                    {{-- SVG Icon --}}
                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg fill="#000000" width="24px" height="24px" viewBox="0 0 24 24" id="report-pie-chart-6" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                        <path id="primary" d="M16,19A7,7,0,0,1,16,5a6.63,6.63,0,0,1,1,.08V4a2,2,0,0,0-2-2H4A2,2,0,0,0,2,4V20a2,2,0,0,0,2,2H15a2,2,0,0,0,2-2V18.92A6.63,6.63,0,0,1,16,19Z" style="fill: #62adfc"></path>
                        <path id="secondary" d="M10,12a6,6,0,1,0,6-6A6,6,0,0,0,10,12Zm5-3.86V11H12.14A4,4,0,0,1,15,8.14ZM12.14,13H16a1,1,0,0,0,1-1V8.14A4,4,0,1,1,12.14,13Z" style="fill: rgb(44, 169, 188);"></path>
                    </svg>
                    <span class="mx-3">OPD Report</span>
                </a>
                @endcanany

                {{-- Hospital Menu Ending --}}

                {{-- Pharmacy Menu Starting --}}
                @canany('Pharmacy access')
                <h6 class="sidebar-title">
                    <span>pharmacy</span>
                </h6>
                @endcan

                @canany('Purchase access','Purchase add','Purchase edit','Purchase delete')
                <a class="sidebar-link {{ route::currentroutenamed('admin.purchases.index') ? 'active' : '' }}"
                    href="{{ route('admin.purchases.index')}}">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                        width="24px" height="24px" viewBox="0 0 512.000000 512.000000"
                        preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                            fill="#62adfc" stroke="none">
                            <path d="M415 4944 c-76 -39 -87 -71 -120 -324 -96 -754 -130 -1297 -129
                -2085 0 -644 18 -1024 74 -1562 25 -240 58 -341 155 -478 103 -144 262 -255
                442 -307 l78 -23 1685 0 c1542 0 1690 1 1745 17 274 76 473 253 564 505 46
                126 52 200 49 605 -3 352 -4 368 -24 394 -11 15 -33 37 -48 48 -27 21 -38 21
                -766 24 l-738 2 -9 108 c-13 167 -9 1257 5 1492 29 466 68 881 118 1254 14
                104 23 204 19 222 -7 42 -50 93 -92 110 -27 12 -284 14 -1505 14 -1316 0
                -1476 -2 -1503 -16z m1431 -810 c53 -39 69 -71 69 -134 0 -63 -16 -95 -69
                -134 -26 -20 -43 -21 -304 -24 -178 -2 -290 1 -314 7 -101 30 -140 169 -71
                252 49 57 60 59 375 56 272 -2 288 -3 314 -23z m800 0 c53 -39 69 -71 69 -134
                0 -63 -16 -95 -69 -134 -23 -18 -45 -22 -144 -24 -137 -4 -179 6 -221 53 -52
                59 -54 147 -4 206 44 52 73 59 215 57 110 -3 130 -6 154 -24z m-960 -800 c53
                -39 69 -71 69 -134 0 -63 -16 -95 -69 -134 -26 -20 -43 -21 -304 -24 -178 -2
                -290 1 -314 7 -101 30 -140 169 -71 252 49 57 60 59 375 56 272 -2 288 -3 314
                -23z m800 0 c53 -39 69 -71 69 -134 0 -63 -16 -95 -69 -134 -23 -18 -45 -22
                -144 -24 -137 -4 -179 6 -221 53 -52 59 -54 147 -4 206 44 52 73 59 215 57
                110 -3 130 -6 154 -24z m-800 -800 c53 -39 69 -71 69 -134 0 -63 -16 -95 -69
                -134 -26 -20 -43 -21 -304 -24 -178 -2 -290 1 -314 7 -101 30 -140 169 -71
                252 49 57 60 59 375 56 272 -2 288 -3 314 -23z m800 0 c53 -39 69 -71 69 -134
                0 -63 -16 -95 -69 -134 -23 -18 -45 -22 -144 -24 -137 -4 -179 6 -221 53 -52
                59 -54 147 -4 206 44 52 73 59 215 57 110 -3 130 -6 154 -24z m2154 -1356 c0
                -286 -8 -345 -56 -440 -59 -117 -202 -223 -333 -248 -35 -6 -486 -10 -1273
                -10 l-1220 0 22 33 c37 55 97 189 115 257 15 53 19 121 22 368 l5 302 1359 0
                1359 0 0 -262z" />
                        </g>
                    </svg>


                    <span class="mx-3">Purchase Invoice</span>
                </a>
                @endcanany

                @canany('Sale access','Sale add','Sale edit','Sale delete')
                <a class="sidebar-link {{ route::currentroutenamed('admin.sales.index') ? 'active' : '' }}"
                    href="{{ route('admin.sales.index')}}">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#62adfc" stroke="none">
                            <path d="M345 5096 c-84 -21 -147 -57 -211 -121 -65 -65 -105 -136 -123 -223 -16 -76 -16 -4309 0 -4384 37 -172 175 -310 347 -347 74 -16 2399 -16 2474 0 170 36 311 178 347 347 16 76 16 4309 0 4384 -37 172 -176 311 -347 347 -80 17 -2419 14 -2487 -3z m2125 -646 c26 -13 47 -34 60 -60 19 -38 20 -57 20 -710 0 -653 -1 -672 -20 -710 -13 -26 -34 -47 -60 -60 -38 -20 -57 -20 -871 -20 l-831 0 -40 22 c-24 14 -48 38 -59 60 -18 35 -19 69 -19 710 1 757 -3 716 76 764 l39 24 833 0 c815 0 834 0 872 -20z m-1440 -2080 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 1 c42 -22 80 -83 80 -129 0 -79 -73 -152 -152 -152 -46 0 -107 38 -129 80 -69 128 73 270 201 201z m640 -1 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m-1280 -640 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 0 c45 -23 80 -81 80 -132 0 -75 -74 -148 -150 -148 -47 0 -109 38 -131 80 -38 71 -13 157 57 197 49 28 93 29 144 3z m640 0 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m-1280 -640 c45 -23 80 -80 80 -130 0 -17 -9 -49 -20 -70 -23 -45 -80 -80 -130 -80 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 0 c45 -23 80 -80 80 -130 0 -50 -35 -107 -80 -130 -51 -26 -95 -25 -144 3 -52 30 -78 79 -73 138 9 111 117 170 217 119z m640 0 c45 -23 80 -80 80 -130 0 -50 -35 -107 -80 -130 -21 -11 -53 -20 -70 -20 -85 0 -157 81 -147 166 12 108 119 164 217 114z" />
                            <path d="M950 3680 l0 -490 650 0 650 0 0 490 0 490 -650 0 -650 0 0 -490z" />
                            <path d="M3490 2550 l0 -320 815 0 815 0 0 115 c0 193 -33 289 -135 391 -65 65 -136 105 -223 123 -36 7 -253 11 -662 11 l-610 0 0 -320z" />
                            <path d="M3490 1290 l0 -640 610 0 c410 0 626 4 662 11 170 36 311 178 347 347 7 34 11 208 11 487 l0 435 -815 0 -815 0 0 -640z" />
                        </g>
                    </svg>
                    <span class="mx-3">Sale Invoice</span>
                </a>
                @endcanany

                {{-- Pharmacy Menu End --}}

                {{-- Reports Menu Start --}}
                @canany('Stock_Report access')
                <a class="sidebar-link {{ route::currentroutenamed('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index')}}">
                    <svg width="24px" height="24px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg">

                        <g fill="#62adfc">

                            <path d="M22 142.576h10.702M22 114.712h10.702M22 22v148h148M21.995 32.934h10.702m-10.702 27.32h10.702M21.995 87.356h10.702" style="#62adfc:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="#62adfc" />

                            <path d="M68.842 128.695a10.782 10.782 0 0 1-10.781 10.781 10.782 10.782 0 0 1-10.782-10.781 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782zM95.06 76.358A10.782 10.782 0 0 1 84.277 87.14a10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782Zm43.576 36.396a10.782 10.782 0 0 1-10.782 10.781 10.782 10.782 0 0 1-10.781-10.781 10.782 10.782 0 0 1 10.781-10.782 10.782 10.782 0 0 1 10.782 10.782zm21.604-73.396a10.782 10.782 0 0 1-10.782 10.782 10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.781 10.782 10.782 0 0 1 10.781 10.781z" style="fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;paint-order:stroke fill markers" />

                            <path d="m64.38 118.198 14.117-31.362m15.08-2.424 24.333 21.124m13.668-4.067 15.53-52.393" style="fill:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:8;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="none" />

                        </g>

                    </svg>

                    <span class="mx-3">Stock Report</span>
                </a>
                @endcanany
                {{-- Reports Menu End --}}


    </nav>

    @push('scripts')

    <script>
        $(document).ready(function() {

            $("#search").on("keyup", function() {
                if (this.value.length > 0) {
                    $("a,h6").hide().filter(function() {
                        return $(this).text().toLowerCase().indexOf($("#search").val().toLowerCase()) != -1;
                    }).show();
                } else {
                    $("a,h6").show();
                }
            });

        });
    </script>
    @endpush