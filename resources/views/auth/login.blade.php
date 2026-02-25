@extends('frontend.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" type="email" id="email" name="email" value="{{ old('email', 'admin@example.com') }}" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" type="password" id="password" name="password" value="123456" required>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200" type="submit">Sign In</button>
                </form>

                <div class="mt-8">
                    <p class="text-center text-gray-600 text-sm mb-4">Quick Login:</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="populateCredentials('admin@example.com', '123456')" class="bg-green-500 text-white py-2 px-3 rounded-lg hover:bg-green-600 transition duration-200 text-sm font-semibold">Admin</button>
                        <button type="button" onclick="populateCredentials('manager@example.com', '123456')" class="bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600 transition duration-200 text-sm font-semibold">Manager</button>
                        <button type="button" onclick="populateCredentials('customer@example.com', '123456')" class="bg-orange-500 text-white py-2 px-3 rounded-lg hover:bg-orange-600 transition duration-200 text-sm font-semibold">Customer</button>
                    </div>
                </div>
            </div>
        </div>
         <script>
            function populateCredentials(email, password) {
                document.getElementById('email').value = email;
                document.getElementById('password').value = password;
            }
        </script>
@endsection