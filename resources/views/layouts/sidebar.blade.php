<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    
    {{-- Logo --}}
    <div class="flex items-center justify-center mt-2 border-bottom border-primary">
        <div>
            <h1 class="font-bold text-center tracking-wider text-4xl" style="color:#DF752E">Amh<span class="text-primary">Logix</span></h1>
            <h6 class="text-indigo-200">Hospital Management System</span></h6>
        </div>
    </div>
    
    {{-- Searchbar --}}
    <div class="relative text-center pt-3" data-widget="sidebar-search">
        <span class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-center">
            <svg class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none">
                <path
                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                </path>
            </svg>
        </span>

        <input class="form-input w-32 sm:w-60 rounded-md pl-10 pr-2 focus:border-indigo-600" type="text"
        placeholder="Search Menu" id="search" autofocus>
    </div>
        

    <nav class="mt-1 pt-1">
        
        {{-- General Menu Starting --}}
        <h6 class="text-muted text-uppercase pl-3 mt-3">
            <span>General</span>
        </h6>

        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.dashboard') ? 'active' : '' }} " href="{{ route('admin.dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><path d="M0 0h24v24H0V0z" fill="none"/>
                <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"/>
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        {{-- Users Sub Menu Starting --}}
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0" id="menu">
            <li>
                @canany('UserMenu access')
                <a href="#submenu1" data-bs-toggle="collapse" class="dropdown-toggle text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.users.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><g><rect fill="none" height="24" width="24"/></g><g><g><path d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M7.35,18.5C8.66,17.56,10.26,17,12,17 s3.34,0.56,4.65,1.5C15.34,19.44,13.74,20,12,20S8.66,19.44,7.35,18.5z M18.14,17.12L18.14,17.12C16.45,15.8,14.32,15,12,15 s-4.45,0.8-6.14,2.12l0,0C4.7,15.73,4,13.95,4,12c0-4.42,3.58-8,8-8s8,3.58,8,8C20,13.95,19.3,15.73,18.14,17.12z"/><path d="M12,6c-1.93,0-3.5,1.57-3.5,3.5S10.07,13,12,13s3.5-1.57,3.5-3.5S13.93,6,12,6z M12,11c-0.83,0-1.5-0.67-1.5-1.5 S11.17,8,12,8s1.5,0.67,1.5,1.5S12.83,11,12,11z"/></g></g></svg>
                    <span class="mx-3">Users Management</span>
                </a>
                @endcan

                <ul class="collapse nav flex-column ms-1 bg-white py-3" id="submenu1" data-bs-parent="#menu">
                    <li>
                        @canany('User access','User add','User edit','User delete')
                        <a href="{{ route('admin.users.index')}}" class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500 {{ Route::currentRouteNamed('admin.users.index') ? 'active' : '' }}">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
                            
                            <span class="ml-3">User Information</span>
                        </a>
                        @endcanany
                    </li>
                    <li>
                        @canany('Role access','Role add','Role edit','Role delete')
                            <a href="{{ route('admin.roles.index') }}" class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500 {{ Route::currentRouteNamed('admin.roles.index') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
                                <span class="ml-3">User Roles</span>
                            </a>
                        @endcanany
                    </li>
                    <li>
                        @canany('Permission access','Permission add','Permission edit','Permission delete')
                            <a href="{{ route('admin.permissions.index') }}" class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500 {{ Route::currentRouteNamed('admin.permissions.index') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
                                <span class="ml-3">User Permissions</span>
                            </a>
                        @endcanany
                    </li>

                </ul>
        {{-- Users Sub Menu End --}}
        
        @canany('Post access','Post add','Post edit','Post delete')
         <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.posts.index') ? 'active' : '' }}"
            href="{{ route('admin.posts.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><rect fill="none" height="24" width="24"/><path d="M3,10h11v2H3V10z M3,8h11V6H3V8z M3,16h7v-2H3V16z M18.01,12.87l0.71-0.71c0.39-0.39,1.02-0.39,1.41,0l0.71,0.71 c0.39,0.39,0.39,1.02,0,1.41l-0.71,0.71L18.01,12.87z M17.3,13.58l-5.3,5.3V21h2.12l5.3-5.3L17.3,13.58z"/></svg>
            
            <span class="mx-3">Post Information</span>
        </a>
        @endcanany

        {{-- Configurations Sub Menu Starting --}}
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0" id="menu">
            <li>
                @canany('Configuration access')
                <a href="#configsubmenu" data-bs-toggle="collapse" class="dropdown-toggle text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white">
                                        
                    <?xml version="1.0" ?><svg enable-background="new 0 0 32 32" id="Editable-line" version="1.1" viewBox="0 0 32 32" height="24px" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><circle cx="16" cy="16" fill="#62adfc" id="XMLID_224_" r="4" stroke="#62adfc" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/><path d="  M27.758,10.366l-1-1.732c-0.552-0.957-1.775-1.284-2.732-0.732L23.5,8.206C21.5,9.36,19,7.917,19,5.608V5c0-1.105-0.895-2-2-2h-2  c-1.105,0-2,0.895-2,2v0.608c0,2.309-2.5,3.753-4.5,2.598L7.974,7.902C7.017,7.35,5.794,7.677,5.242,8.634l-1,1.732  c-0.552,0.957-0.225,2.18,0.732,2.732L5.5,13.402c2,1.155,2,4.041,0,5.196l-0.526,0.304c-0.957,0.552-1.284,1.775-0.732,2.732  l1,1.732c0.552,0.957,1.775,1.284,2.732,0.732L8.5,23.794c2-1.155,4.5,0.289,4.5,2.598V27c0,1.105,0.895,2,2,2h2  c1.105,0,2-0.895,2-2v-0.608c0-2.309,2.5-3.753,4.5-2.598l0.526,0.304c0.957,0.552,2.18,0.225,2.732-0.732l1-1.732  c0.552-0.957,0.225-2.18-0.732-2.732L26.5,18.598c-2-1.155-2-4.041,0-5.196l0.526-0.304C27.983,12.546,28.311,11.323,27.758,10.366z  " fill="none" id="XMLID_242_" stroke="#62adfc" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2"/></svg>
                    
                    <span class="mx-3">Configurations</span>
                </a>
                @endcan

                <ul class="collapse nav flex-column ms-1 bg-white py-3" id="configsubmenu" data-bs-parent="#menu">
                    <li>

                        @canany('HospitalConfig access','HospitalConfig create','HospitalConfig edit','HospitalConfig delete')
                        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500  {{ Route::currentRouteNamed('admin.hospitals.index') ? 'active' : '' }}"
                            href="{{ route('admin.hospitals.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
                            
                            <span class="mx-3">Hospital Config</span>
                        </a>
                        @endcanany

                        @canany('PharmacyConfig access','PharmacyConfig add','PharmacyConfig edit','PharmacyConfig delete')
                        <a href="{{ route('admin.pharmacies.index')}}" class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500 {{ Route::currentRouteNamed('admin.p_lab.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
                            <span class="ml-3">Pharmacy Config</span>
                        </a>
                        @endcanany

                        @canany('Backup access','Backup create','Backup delete', 'Backup download', 'Backup restore')
                        <a href="{{ route('admin.backups.index')}}" class="text-decoration-none flex items-center mt-2 py-2 px-6 text-dark fw-bold fs-6 hover:bg-red-500 {{ Route::currentRouteNamed('admin.backups.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/> </svg>
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
        <h6 class="text-muted text-uppercase pl-3 mt-3">
            <span>Hospital</span>
        </h6>    
        @endcan
        
        @canany('Speciality access','Speciality create','Speciality edit','Speciality delete')
        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.specialities.index') ? 'active' : '' }}"
            href="{{ route('admin.specialities.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3 1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
            
            <span class="mx-3">Specialty Info</span>
        </a>
        @endcanany

        @canany('Doctor access','Doctor create','Doctor edit','Doctor delete')
        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.doctors.index') ? 'active' : '' }}"
            href="{{ route('admin.doctors.index')}}">
            
            <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg width="25px" height="25px" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M154.43 82.5312C173.459 117.556 205.218 122.311 243.126 118.117" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M150.09 86.5879C140.296 98.5304 134.136 110.444 129.975 126.872" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M130.429 131.586C117.525 139.947 135.196 152.018 135.196 152.739C135.196 229.349 250.087 260.198 250.087 161.051" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M118.367 215.001C87.2977 146.373 97.9899 60.6461 164.799 33.3594" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M187.835 33C307.054 33.0003 275.092 138.363 282.29 203.481" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M186.274 144.558C186.274 141.486 186.274 138.409 186.274 135.336" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M212.424 144.452C212.424 139.561 213.503 138.736 212.424 135.019" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M144.154 218.021C130.491 255.064 179.516 277.407 185.35 311.852C185.489 312.657 186.432 356.683 188.884 356.683C197.622 356.683 188.825 310.119 192.414 304.557C218.528 264.074 247.734 267.575 247.734 213.848" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M45 364.747C60.1863 306.064 60.1863 250.394 141.759 217.304" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M250.039 217.304C306.492 219.949 354.861 302.323 354.861 356.683" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M247.454 214.385C252.064 225.679 270.412 261.433 272.454 273.673" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M264.979 274.103C308.843 245.731 308.11 334.174 263.765 302.154C252.367 293.926 265.752 280.95 271.052 272.934" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M144.572 219.081C125.029 233.198 104.685 262.672 102.722 285.53" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M69.0321 364.747C41.0835 350.369 78.0741 270.547 109.175 286.469C133.814 299.08 128.247 362.011 101.532 364.747" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M285.611 332.155C275.829 331.226 266.341 333.888 256.665 335.278" stroke="#62adfc" stroke-opacity="0.9" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            
            <span class="mx-3">Doctor Info</span>
        </a>
        @endcanany

        @canany('Appointment access','Appointment create','Appointment edit','Appointment delete')
        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.appointments.index') ? 'active' : '' }}"
            href="{{ route('admin.appointments.index')}}">
            
            <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg fill="#62adfc" width="25px" height="25px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <title>calendar</title>
            <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-1.952-1.12-3.488t-2.88-2.144v2.624q0 1.248-0.864 2.144t-2.144 0.864-2.112-0.864-0.864-2.144v-3.008h-12v3.008q0 1.248-0.896 2.144t-2.112 0.864-2.144-0.864-0.864-2.144v-2.624q-1.76 0.64-2.88 2.144t-1.12 3.488v20zM4 26.016v-16h24v16q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM6.016 3.008q0 0.416 0.288 0.704t0.704 0.288 0.704-0.288 0.288-0.704v-3.008h-1.984v3.008zM8 24h4v-4h-4v4zM8 18.016h4v-4h-4v4zM14.016 24h4v-4h-4v4zM14.016 18.016h4v-4h-4v4zM20 24h4v-4h-4v4zM20 18.016h4v-4h-4v4zM24 3.008q0 0.416 0.288 0.704t0.704 0.288 0.704-0.288 0.32-0.704v-3.008h-2.016v3.008z"></path>
            </svg>
            
            <span class="mx-3">Appointments</span>
        </a>
        @endcanany

        @canany('Patient access','Patient add','Patient edit','Patient delete')
        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.patients.index') ? 'active' : '' }}"
            href="{{ route('admin.patients.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><rect fill="none" height="24" width="24"/><path d="M12,10c2.21,0,4-1.79,4-4c0-2.21-1.79-4-4-4S8,3.79,8,6C8,8.21,9.79,10,12,10z M12,4c1.1,0,2,0.9,2,2c0,1.1-0.9,2-2,2 s-2-0.9-2-2C10,4.9,10.9,4,12,4z M18.39,12.56C16.71,11.7,14.53,11,12,11c-2.53,0-4.71,0.7-6.39,1.56C4.61,13.07,4,14.1,4,15.22V22 h2v-6.78c0-0.38,0.2-0.72,0.52-0.88C7.71,13.73,9.63,13,12,13c0.76,0,1.47,0.07,2.13,0.2l-1.55,3.3H9.75C8.23,16.5,7,17.73,7,19.25 C7,20.77,8.23,22,9.75,22h2.18H18c1.1,0,2-0.9,2-2v-4.78C20,14.1,19.39,13.07,18.39,12.56z M10.94,20H9.75C9.34,20,9,19.66,9,19.25 c0-0.41,0.34-0.75,0.75-0.75h1.89L10.94,20z M18,20h-4.85l2.94-6.27c0.54,0.2,1.01,0.41,1.4,0.61C17.8,14.5,18,14.84,18,15.22V20z"/></svg>
            
            <span class="mx-3">Patient Registration</span>
        </a>
        @endcanany
        
        @canany('Token access','Token add','Token edit','Token delete')
         <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.tokens.index') ? 'active' : '' }}"
            href="{{ route('admin.tokens.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#62adfc"><rect fill="none" height="24" width="24"/><path d="M9,4c-4.42,0-8,3.58-8,8c0,4.42,3.58,8,8,8s8-3.58,8-8C17,7.58,13.42,4,9,4z M12,10.5h-2v5H8v-5H6V9h6V10.5z M20.25,3.75 L23,5l-2.75,1.25L19,9l-1.25-2.75L15,5l2.75-1.25L19,1L20.25,3.75z M20.25,17.75L23,19l-2.75,1.25L19,23l-1.25-2.75L15,19l2.75-1.25 L19,15L20.25,17.75z"/></svg>
            
            <span class="mx-3">Token Info</span>
        </a>
        @endcanany

        @canany('DoctorNotes access','DoctorNotes add','DoctorNotes edit','DoctorNotes delete')
         <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.doctor_notes.index') ? 'active' : '' }}"
            href="{{ route('admin.doctor_notes.index')}}">
            <?xml version="1.0" encoding="iso-8859-1"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.899 490.899" style="enable-background:new 0 0 490.899 490.899;" xml:space="preserve" height="24px" width="24px" fill="#62adfc"><g><path d="M474.5,330.849l-104.3-104.3v-167.8c0-11.5-9.4-20.9-20.9-20.9h-73v-16.6c0-11.5-9.4-20.9-20.9-20.9H114.8 c-11.5,0-20.9,9.4-20.9,20.9v16.7h-73c-11.5,0-20.9,9.4-20.9,20.9v410.8c0,11.5,9.4,20.9,20.9,20.9h328.4 c11.5,0,20.9-9.4,20.9-20.9v-30.3c21.6,21.6,65.1,20.5,95.9-10.3C495.3,399.649,499.5,355.849,474.5,330.849z M135.6,41.049h99 v35.4h-99V41.049z M40.8,449.649v-370.1H94v16.7c0,11.5,9.4,20.9,20.9,20.9h140.6c10.4,0,19.8-9.4,20.9-19.8v-17.8h52.1v115.6 l-89.7-16.6c-7-3-25,3.1-22.9,22.9l17.7,95.9c0,4.2,2.1,7.3,5.2,10.4l89.7,89.7v52.1H40.8V449.649z M436.9,399.649 c-8.3,7.3-27.1,18.5-40.7,8.3l-124-124l-11.5-60.5l59.4,11.5l125.1,125.1C452.6,367.349,451.5,385.049,436.9,399.649z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
            
            <span class="mx-3">Doctor Notes</span>
        </a>
        @endcanany

        @canany('TokenReport access','TokenReport add','TokenReport edit','TokenReport delete')
        <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ Route::currentRouteNamed('admin.tokens.token_report') ? 'active' : '' }}"
        href="{{ route('admin.tokens.token_report') }}">
            {{-- SVG Icon --}}
            <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
            <svg fill="#000000" width="24px" height="24px" viewBox="0 0 24 24" id="report-pie-chart-6" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><path id="primary" d="M16,19A7,7,0,0,1,16,5a6.63,6.63,0,0,1,1,.08V4a2,2,0,0,0-2-2H4A2,2,0,0,0,2,4V20a2,2,0,0,0,2,2H15a2,2,0,0,0,2-2V18.92A6.63,6.63,0,0,1,16,19Z" style="fill: #62adfc"></path><path id="secondary" d="M10,12a6,6,0,1,0,6-6A6,6,0,0,0,10,12Zm5-3.86V11H12.14A4,4,0,0,1,15,8.14ZM12.14,13H16a1,1,0,0,0,1-1V8.14A4,4,0,1,1,12.14,13Z" style="fill: rgb(44, 169, 188);"></path></svg>
            <span class="mx-3">Token Report</span>
        </a>
        @endcanany

        {{-- Hospital Menu Ending --}}
        
        {{-- Pharmacy Menu Starting --}}
        @canany('Pharmacy access')
        <h6 class="text-muted text-uppercase pl-3 mt-3">
            <span>pharmacy</span>
        </h6>
        @endcan

        @canany('Manufacturer access','Manufacturer add','Manufacturer edit','Manufacturer delete')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.manufacturers.index') ? 'active' : '' }}"
            href="{{ route('admin.manufacturers.index')}}">
            <?xml version="1.0" encoding="utf-8" standalone="no"?><svg  viewbox="0 0 512 512"  xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#62adfc"><path d="m184.429688 101.929688c-1.859376 1.859374-2.929688 4.441406-2.929688 7.070312s1.070312 5.210938 2.929688 7.070312c1.859374 1.859376 4.441406 2.929688 7.070312 2.929688s5.210938-1.070312 7.070312-2.929688c1.859376-1.859374 2.929688-4.441406 2.929688-7.070312s-1.070312-5.210938-2.929688-7.070312c-1.859374-1.859376-4.441406-2.929688-7.070312-2.929688s-5.210938 1.070312-7.070312 2.929688zm0 0"/><path d="m502 316h-37.5v-104.5c0-3.53125-1.863281-6.800781-4.902344-8.601562-3.039062-1.804688-6.800781-1.867188-9.898437-.171876l-106.699219 58.402344v-49.628906c0-3.53125-1.863281-6.800781-4.902344-8.601562-3.039062-1.804688-6.800781-1.867188-9.898437-.171876l-106.699219 58.402344v-49.628906c0-3.53125-1.863281-6.800781-4.902344-8.601562-3.039062-1.804688-6.800781-1.867188-9.898437-.171876l-106.699219 58.402344v-132.191406c0-5.480469 4.457031-9.9375 9.9375-9.9375h41.5625c5.523438 0 10-4.476562 10-10s-4.476562-10-10-10h-41.5625c-16.507812 0-29.9375 13.429688-29.9375 29.9375v.0625h-60v-53.65625c0-30.515625 24.828125-55.34375 55.347656-55.34375 17.566406 0 33.707032 8.070312 44.277344 22.136719 3.316406 4.414062 9.585938 5.304687 14.003906 1.988281 4.414063-3.316406 5.304688-9.585938 1.988282-14-1.3125-1.75-2.691407-3.429688-4.128907-5.039062 8.269531-3.34375 17.144531-5.085938 26.199219-5.085938 22.621094 0 43.949219 11.054688 57.050781 29.574219 1.945313 2.753906 5.035157 4.222656 8.171875 4.222656 1.996094 0 4.011719-.597656 5.765625-1.835937 4.507813-3.191407 5.578125-9.429688 2.386719-13.9375-2.019531-2.859376-4.199219-5.574219-6.507812-8.148438h59.882812c19.058594 0 34.5625 15.503906 34.5625 34.5625s-15.503906 34.5625-34.5625 34.5625h-52.9375c-5.523438 0-10 4.476562-10 10s4.476562 10 10 10h52.9375c30.085938 0 54.5625-24.476562 54.5625-54.5625s-24.476562-54.5625-54.5625-54.5625h-85.3125c-.175781 0-.34375.015625-.515625.027344-12.511719-6.414063-26.511719-9.902344-40.921875-9.902344-15.140625 0-29.902344 3.777344-43.0625 10.972656-11.628906-7.117187-25.109375-10.972656-39.277344-10.972656-41.546875 0-75.347656 33.800781-75.347656 75.34375v426.65625c0 5.523438 4.476562 10 10 10h492c5.523438 0 10-4.476562 10-10v-176c0-5.523438-4.476562-10-10-10zm-57.5-87.628906v87.628906h-101.5v-32.074219zm-121.5 0v87.628906h-101.5v-32.074219zm-243-51.371094h-60v-28h60zm-60 20h60v295h-20v-60.617188c0-5.523437-4.476562-10-10-10s-10 4.476563-10 10v60.617188h-20zm80 86.925781 101.5-55.554687v87.628906h-39.5c-5.523438 0-10 4.476562-10 10v166h-52zm392 208.074219h-320v-156h320zm0 0"/><path d="m217 453h46c5.523438 0 10-4.476562 10-10v-48c0-5.523438-4.476562-10-10-10h-46c-5.523438 0-10 4.476562-10 10v48c0 5.523438 4.476562 10 10 10zm10-48h26v28h-26zm0 0"/><path d="m309 453h46c5.523438 0 10-4.476562 10-10v-48c0-5.523438-4.476562-10-10-10h-46c-5.523438 0-10 4.476562-10 10v48c0 5.523438 4.476562 10 10 10zm10-48h26v28h-26zm0 0"/><path d="m401 453h46c5.523438 0 10-4.476562 10-10v-48c0-5.523438-4.476562-10-10-10h-46c-5.523438 0-10 4.476562-10 10v48c0 5.523438 4.476562 10 10 10zm10-48h26v28h-26zm0 0"/><path d="m50 401.328125c2.628906 0 5.210938-1.058594 7.070312-2.929687 1.859376-1.859376 2.929688-4.429688 2.929688-7.070313 0-2.628906-1.070312-5.207031-2.929688-7.066406-1.859374-1.863281-4.441406-2.933594-7.070312-2.933594s-5.210938 1.070313-7.070312 2.933594c-1.859376 1.859375-2.929688 4.4375-2.929688 7.066406 0 2.640625 1.070312 5.210937 2.929688 7.070313 1.859374 1.871093 4.429687 2.929687 7.070312 2.929687zm0 0"/>
            </svg>
            <span class="mx-3">Manufacturer Info</span>
            </a>
        @endcanany
        
        @canany('Supplier access','Supplier add','Supplier edit','Supplier delete')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.suppliers.index') ? 'active' : '' }}"
            href="{{ route('admin.suppliers.index')}}">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                    width="24px" height="24px" viewBox="0 0 128.000000 128.000000"
                    preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
                    fill="#62adfc" stroke="none"><path d="M470 1195 c-19 -7 -62 -14 -95 -14 -115 -2 -176 -76 -149 -178 8 -29
                    34 -30 34 -3 0 53 49 100 105 100 18 0 22 4 18 20 -4 15 0 20 16 20 12 0 21-6 21 -15 0 -9 11 -27 25 -40 20 -21 34 -25 80 -25 60 0 95 -22 95 -60 0 -32 27 -23 34 11 9 48 7 118 -4 139 -10 19 -12 19 -45 3 -19 -9 -36 -15 -37 -12
                    -2 2 -10 17 -18 34 -18 35 -32 39 -80 20z"/><path d="M696 1027 c-4 -40 -4 -85 -1 -100 7 -25 11 -27 61 -27 30 0 54 3 54
                    8 0 4 -10 49 -22 100 l-22 92 -32 0 -32 0 -6 -73z"/><path d="M810 1093 c0 -5 10 -50 22 -100 l22 -93 78 0 c43 0 78 3 78 8 0 4
                    -10 49 -22 100 l-22 92 -78 0 c-43 0 -78 -3 -78 -7z"/><path d="M1010 1093 c0 -4 10 -50 22 -100 l22 -93 78 0 c43 0 78 3 77 8 0 4 -15 48 -32 97 l-32 90 -67 3 c-38 2 -68 -1 -68 -5z"/><path d="M320 1040 c-17 -17 -20 -33 -20 -120 0 -110 11 -145 51 -166 36 -18 142 -18 178 1 41 21 52 58 49 166 l-3 94 -63 6 c-36 3 -70 13 -80 22 -26 24 -87 22 -112 -3z m56 -71 c10 -17 -13 -36 -27 -22 -12 12 -4 33 11 33 5 0 12 -5 16 -11z m160 0 c10 -17 -13 -36 -27 -22 -12 12 -4 33 11 33 5 0 12 -5 16 -11z m4 -124 c0 -9 -11 -27 -25 -40 -20 -21 -34 -25 -80 -25 -48 0 -55 2 -55 20 0 17 7 20 50 20 39 0 53 4 62 20 15 24 48 27 48 5z"/><path d="M232 928 c-15 -15 -15 -41 0 -56 21 -21 28 -13 28 28 0 41 -7 49 -28 28z"/><path d="M620 900 c0 -43 13 -50 34 -17 8 12 8 22 0 34 -21 33 -34 26 -34 -17z"/><path d="M682 848 c-23 -23 -11 -29 60 -26 60 2 73 6 76 21 3 15 -5 17 -60 17 -37 0 -69 -5 -76 -12z"/><path d="M862 843 c3 -15 15 -18 78 -18 63 0 75 3 78 18 3 15 -6 17 -78 17 -72 0 -81 -2 -78 -17z"/><path d="M1062 843 c3 -15 15 -18 78 -18 63 0 75 3 78 18 3 15 -6 17 -78 17 -72 0 -81 -2 -78 -17z"/><path d="M610 790 c-6 -15 -22 -38 -36 -51 -39 -37 -31 -55 42 -89 41 -20 88 -54 125 -91 46 -46 66 -59 89 -59 l30 0 0 108 c0 71 4 112 12 120 17 17 239 17 256 0 17 -17 17 -599 0 -616 -17 -17 -359 -17 -376 0 -7 7 -12 25 -12 40 0 21 -5 28 -20 28 -18 0 -20 -7 -20 -60 l0 -60 240 0 240 0 0 360 0 360 -62 1 c-35 1 -152 1 -260 0 -183 -1 -199 0 -217 18 -19 19 -19 19 -31 -9z"/><path d="M367 686 c-4 -9 8 -19 34 -29 35 -14 43 -14 78 0 61 24 44 43 -39 43 -48 0 -69 -4 -73 -14z"/><path d="M900 600 l0 -100 100 0 100 0 0 100 c0 93 -1 100 -20 100 -17 0 -20-7 -20 -40 l0 -40 -60 0 -60 0 0 40 c0 33 -3 40 -20 40 -19 0 -20 -7 -20 -100z"/><path d="M980 680 c0 -13 7 -20 20 -20 13 0 20 7 20 20 0 13 -7 20 -20 20 -13 0 -20 -7 -20 -20z"/><path d="M325 630 c-7 -11 11 -50 23 -50 4 0 18 7 31 16 l23 17 -32 13 c-39 17 -37 17 -45 4z"/><path d="M506 625 l-29 -12 28 -19 c27 -17 28 -17 41 1 27 36 7 51 -40 30z"/><path d="M223 581 c-55 -40 -107 -103 -137 -167 -30 -63 -32 -93 -11 -134 21 -40 63 -60 130 -60 l55 0 0 40 0 40 -40 0 -40 0 0 60 c0 53 2 60 20 60 17 0 20 -7 20 -40 l0 -40 40 0 c37 0 40 2 40 28 0 33 16 52 45 52 17 0 25 11 38 52 19 61 10 79 -26 55 -24 -15 -25 -15 -47 34 -13 27 -29 49 -35 49 -7 0 -30 -13 -52 -29z"/><path d="M570 561 c-22 -49 -23 -49 -47 -34 -36 24 -45 6 -26 -55 13 -41 21 -52 38 -52 29 0 45 -19 45 -52 0 -26 3 -28 40 -28 l40 0 0 40 c0 33 3 40 20 40 18 0 20 -7 20 -60 l0 -60 -40 0 -40 0 0 -40 0 -40 55 0 c31 0 69 7 85 15 33 17 60 61 60 97 0 34 -52 138 -91 183 -38 43 -106 95 -124 95 -6 0 -22 -22 -35 -49z"/><path d="M423 574 c-8 -21 13 -42 28 -27 13 13 5 43 -11 43 -6 0 -13 -7 -17 -16z"/><path d="M426 476 c-3 -13 -9 -31 -12 -40 -5 -13 1 -16 26 -16 25 0 31 3 26 16 -3 9 -9 27 -12 40 -8 31 -20 31 -28 0z"/><path d="M825 443 c46 -108 44 -152 -11 -212 -20 -23 -34 -49 -34 -65 l0 -26 160 0 160 0 0 160 0 160 -40 0 -40 0 0 -40 0 -40 -80 0 -80 0 0 40 c0 34 -3 40 -21 40 -16 0 -19 -4 -14 -17z"/><path d="M900 440 c0 -17 7 -20 40 -20 33 0 40 3 40 20 0 17 -7 20 -40 20 -33 0 -40 -3 -40 -20z"/><path d="M340 363 c0 -10 15 -25 33 -33 38 -18 55 -58 41 -97 -5 -16 -23 -34 -41 -43 -18 -8 -33 -23 -33 -32 0 -16 11 -18 100 -18 89 0 100 2 100 18 0 9 -15 24 -33 32 -38 18 -55 58 -41 98 5 15 23 33 41 42 18 8 33 23 33 33 0 15 -11 17 -100 17 -89 0 -100 -2 -100 -17z"/>
                    <path d="M300 260 c0 -40 1 -41 31 -38 39 4 59 30 43 56 -6 9 -25 18 -43 20 -30 3 -31 2 -31 -38z"/><path d="M512 288 c-29 -29 -6 -68 40 -68 26 0 28 3 28 40 0 37 -2 40 -28 40 -15 0 -33 -5 -40 -12z"/><path d="M220 120 l0 -60 220 0 220 0 0 60 0 60 -40 0 c-37 0 -40 -2 -40 -28 0 -47 -14 -52 -140 -52 -126 0 -140 5 -140 52 0 26 -3 28 -40 28 l-40 0 0 -60z"/></g></svg>

            <span class="mx-3">Supplier Info</span>
            </a>
        @endcanany
                    
        @canany('Product access','Product add','Product edit','Product delete')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.products.index') ? 'active' : '' }}"
            href="{{ route('admin.products.index')}}">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="24px" height="24px" viewBox="0 0 512.000000 512.000000"
                preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                fill="#62adfc" stroke="none"><path d="M775 5106 c-95 -30 -149 -78 -190 -168 l-26 -57 3 -303 3 -303 27 -51 c29 -55 81 -106 134 -132 l34 -16 0 -139 0 -140 -267 -356 c-146 -196 -275 -376 -286 -401 -48 -107 -47 -83 -47 -1186 0 -1137 -3 -1080 58 -1199 33
                -66 143 -174 212 -207 120 -59 99 -58 1005 -58 l830 -1 34 -49 c45 -67 164 -178 239 -224 205 -124 466 -148 690 -63 56 21 305 159 707 391 341 197 643 373 670 391 118 76 211 184 276 320 61 126 74 189 74 350 0 119 -4 151 -23 215 -71 225 -215 397 -417 495 -132 64 -196 79 -350 79 -204 1 -273 -24 -630 -232 l-170 -99 -5 476 c-5 464 -6 478 -28 541 -30 85 -52 117 -334 492 l-238 318 0 145 0 145 25 10 c44 17 122 98 146 153 23 51 24 58 24 347 l0 295 -26 55 c-31 66 -82 118 -146 151 l-48 24 -960 2 c-755 1 -969 -1 -1000 -11z m1952-219 l28 -27 3 -253 c2 -225 1 -256 -15 -287 -10 -19 -29 -40 -43 -47 -34 -17-1850 -19 -1883 -2 -56 29 -57 32 -57 319 0 285 1 289 55 318 14 8 285 11 952 9 l933 -2 27 -28z m-167 -927 l0 -100 -461 0 c-479 0 -486 -1 -521 -44 -36 -43 -16 -117 39 -145 15 -8 169 -11 506 -11 l485 0 248 -331 c246 -329 294 -401 294 -446 l0 -23 -1396 0 -1396 0 7 33 c12 55 44 102 309 456 142 189 264
                358 272 377 10 24 14 77 14 184 l0 150 800 0 800 0 0 -100z m600 -1708 l0 -407 -302 -174 c-167 -96 -328 -191 -358 -212 -73 -48 -178 -155 -215 -218 l-30 -51 -947 0 -948 0 0 735 0 735 1400 0 1400 0 0 -408z m1144 -172 c205 -52 363 -197 427 -392 20 -61 24 -93 24 -193 -1 -136 -19 -204 -83 -309 -67 -111 -128 -159 -418 -326 -148 -85 -273 -156 -279 -158 -11 -3 -611 1025 -604 1033 12 11 522 301 559 317 112 49 251 60 374 28z m-811 -966 c164 -284 295 -520 290 -524 -11 -10 -516 -301 -571 -329 -63 -32 -185 -61 -256 -61 -283 1 -533 202 -591 477 -43 201 16 397 164 543 67 66 109 94 366 242 160 92 292 168 295 168 3 0 139 -232 303 -516z m-1327 -161 c-15 -95 -18 -177 -7 -253 7 -45 15 -88 18 -96 5 -12 -105 -14 -793 -12 -788 3 -800 3 -845 24 -68 32 -119
                82 -151 149 -24 51 -28 73 -28 143 l0 82 906 0 907 0 -7 -37z"/><path d="M1215 3849 c-80 -46 -68 -163 19 -185 89 -22 159 98 94 163 -28 27 -84 39 -113 22z"/><path d="M1715 2379 c-51 -30 -55 -43 -55 -221 l0 -168 -161 0 c-166 0 -190 -5 -221 -44 -36 -43 -16 -117 39 -145 13 -7 84 -11 182 -11 l161 0 0 -169 c0 -164 1 -169 24 -194 45 -49 111 -46 150 7 19 25 21 44 24 192 l3 164 154 0
                c85 0 165 4 179 10 61 23 79 112 32 159 -26 26 -28 26 -195 29 l-169 3 -4 169 c-3 166 -3 170 -29 195 -29 29 -85 41 -114 24z"/>
                </g>
            </svg>
            <span class="mx-3">Medicine Info</span>
            </a>
        @endcanany
        
        @canany('Purchase access','Purchase add','Purchase edit','Purchase delete')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.purchases.index') ? 'active' : '' }}"
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
                1359 0 0 -262z"/>
                </g>
            </svg>


            <span class="mx-3">Purchase Invoice</span>
            </a>
        @endcanany

        @canany('Sale access','Sale add','Sale edit','Sale delete')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.sales.index') ? 'active' : '' }}"
            href="{{ route('admin.sales.index')}}">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"width="24px" height="24px" viewBox="0 0 512.000000 512.000000"preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"fill="#62adfc" stroke="none"><path d="M345 5096 c-84 -21 -147 -57 -211 -121 -65 -65 -105 -136 -123 -223 -16 -76 -16 -4309 0 -4384 37 -172 175 -310 347 -347 74 -16 2399 -16 2474 0 170 36 311 178 347 347 16 76 16 4309 0 4384 -37 172 -176 311 -347 347 -80 17 -2419 14 -2487 -3z m2125 -646 c26 -13 47 -34 60 -60 19 -38 20 -57 20 -710 0 -653 -1 -672 -20 -710 -13 -26 -34 -47 -60 -60 -38 -20 -57 -20 -871 -20 l-831 0 -40 22 c-24 14 -48 38 -59 60 -18 35 -19 69 -19 710 1 757 -3 716 76 764 l39 24 833 0 c815 0 834 0 872 -20z m-1440 -2080 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 1 c42 -22 80 -83 80 -129 0 -79 -73 -152 -152 -152 -46 0 -107 38 -129 80 -69 128 73 270 201 201z m640 -1 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m-1280 -640 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 0 c45 -23 80 -81 80 -132 0 -75 -74 -148 -150 -148 -47 0 -109 38 -131 80 -38 71 -13 157 57 197 49 28 93 29 144 3z m640 0 c45 -23 80 -80 80 -130 0 -76 -74 -150 -150 -150 -85 0 -157 81 -147 166 12 108 119 164 217 114z m-1280 -640 c45 -23 80 -80 80 -130 0 -17 -9 -49 -20 -70 -23 -45 -80 -80 -130 -80 -85 0 -157 81 -147 166 12 108 119 164 217 114z m640 0 c45 -23 80 -80 80 -130 0 -50 -35 -107 -80 -130 -51 -26 -95 -25 -144 3 -52 30 -78 79 -73 138 9 111 117 170 217 119z m640 0 c45 -23 80 -80 80 -130 0 -50 -35 -107 -80 -130 -21 -11 -53 -20 -70 -20 -85 0 -157 81 -147 166 12 108 119 164 217 114z"/><path d="M950 3680 l0 -490 650 0 650 0 0 490 0 490 -650 0 -650 0 0 -490z"/><path d="M3490 2550 l0 -320 815 0 815 0 0 115 c0 193 -33 289 -135 391 -65 65 -136 105 -223 123 -36 7 -253 11 -662 11 l-610 0 0 -320z"/><path d="M3490 1290 l0 -640 610 0 c410 0 626 4 662 11 170 36 311 178 347 347 7 34 11 208 11 487 l0 435 -815 0 -815 0 0 -640z"/></g></svg>
            <span class="mx-3">Sale Invoice</span>
            </a>
        @endcanany

        {{-- Pharmacy Menu End --}}
        
        {{-- Reports Menu Start --}}
        @canany('Report access')
            <a class="text-decoration-none flex items-center mt-2 py-2 px-6 fw-bold fs-6 text-white hover:bg-indigo-600 hover:text-white {{ route::currentroutenamed('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index')}}">
                <svg width="24px" height="24px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg">

                <g fill="#62adfc">

                <path d="M22 142.576h10.702M22 114.712h10.702M22 22v148h148M21.995 32.934h10.702m-10.702 27.32h10.702M21.995 87.356h10.702" style="#62adfc:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="#62adfc"/>

                <path d="M68.842 128.695a10.782 10.782 0 0 1-10.781 10.781 10.782 10.782 0 0 1-10.782-10.781 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782zM95.06 76.358A10.782 10.782 0 0 1 84.277 87.14a10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.782 10.782 10.782 0 0 1 10.781 10.782Zm43.576 36.396a10.782 10.782 0 0 1-10.782 10.781 10.782 10.782 0 0 1-10.781-10.781 10.782 10.782 0 0 1 10.781-10.782 10.782 10.782 0 0 1 10.782 10.782zm21.604-73.396a10.782 10.782 0 0 1-10.782 10.782 10.782 10.782 0 0 1-10.782-10.782 10.782 10.782 0 0 1 10.782-10.781 10.782 10.782 0 0 1 10.781 10.781z" style="fill-opacity:0;stroke:#62adfc;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;paint-order:stroke fill markers"/>

                <path d="m64.38 118.198 14.117-31.362m15.08-2.424 24.333 21.124m13.668-4.067 15.53-52.393" style="fill:#62adfc;fill-opacity:0;stroke:#62adfc;stroke-width:8;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:6;stroke-dasharray:none;paint-order:stroke fill markers" fill="none"/>

                </g>

                </svg>

                <span class="mx-3">Stock Report</span>
            </a>
        @endcanany
    </nav>
</div>

@push('scripts')
    
    <script>
        $(document).ready(function () {

        $("#search").on("keyup", function () {
        if (this.value.length > 0) {   
        $("a,h6").hide().filter(function () {
        return $(this).text().toLowerCase().indexOf($("#search").val().toLowerCase()) != -1;
        }).show(); 
        }  
        else { 
        $("a,h6").show();
        }
        }); 

        });    
    </script>
@endpush