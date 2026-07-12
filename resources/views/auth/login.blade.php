@php
    $hospital = \App\Models\Hospital::first();
@endphp
<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
     style="background-image: url('{{ asset('images/healthcare.jpg') }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black opacity-60"></div>

    <div class="relative z-10 w-full max-w-md px-4">

        <!-- Logo Section -->
        <div class="text-center mb-8">
            <p class="font-extrabold text-4xl">
                <span style="color:#DF752E">{{ $hospital->title ?? config('app.name') }}</span>
            </p>

            <p class="text-white text-sm mt-2">
                Hospital Information Management System
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">
                    Welcome Back
                </h2>

                <p class="text-gray-500 mt-2">
                    Sign in to continue
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email"
                        required
                        autofocus>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password"
                        required>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember_me"
                        class="rounded border-gray-300">

                    <label for="remember_me" class="ml-2 text-sm text-gray-600">
                        Remember Me
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-md">

                    Sign In
                </button>

                <!-- Forgot Password -->
                <div class="text-center mt-4">
                    <a href="#"
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Forgot Password?
                    </a>
                </div>

            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white text-xs">
            © {{ now()->year }} AmhLogix HIMS. All Rights Reserved.
        </div>

    </div>

</div>

</x-guest-layout>