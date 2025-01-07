<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&amp;display=swap" rel="stylesheet"/>
    <style>
        .custom-font {
            font-family: 'Fredoka One', cursive;
        }
    </style>
</head>
<body class="bg-gray-200">
    <div class="bg-gray-300 h-12 w-full"></div>
    <div class="flex min-h-screen">
        <div class="w-1/2 relative">
        <img alt="Cover Image" class="w-full h-full object-cover" src="{{ asset('storage/img/coverlogin.png') }}"/>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white text-6xl custom-font text-center">
                    <p>anytime</p>
                    <p>anywhere</p>
                    <p>with ease</p>
                    <p>and no</p>
                    <p>hassle</p>
                </div>
            </div>
        </div>
        <div class="w-1/2 bg-white flex items-center justify-center">
            <div class="w-3/4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Login</h2>
                </div>
                <!-- Menampilkan pesan error -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <!-- Menampilkan alert jika password salah -->
                @if(session('password_error'))
                    <div class="alert alert-danger">
                        {{ session('password_error') }}
                    </div>
                @endif
                <!-- Form login -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                        <input class="mt-1 block w-full px-3 py-2 border border-orange-500 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm" id="email" name="email" placeholder="Enter your Email" type="email" value="{{ old('email') }}" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                        <input class="mt-1 block w-full px-3 py-2 border border-orange-500 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm" id="password" name="password" placeholder="Enter your Password" type="password" required/>
                    </div>
                    <button class="w-full bg-orange-500 text-white py-2 rounded-md" type="submit">Login</button>
                </form>
                <div class="flex justify-center mt-4">
                    <p class="text-sm">Don't have an account? <a class="text-red-500" href="{{ route('register') }}">Sign up now</a></p>
                </div>
                <p class="mt-4 text-xs text-gray-500 text-center">By logging in, you agree to the <a class="text-red-500" href="#">Terms and Conditions</a> and <a class="text-red-500" href="#">Privacy Policy</a> of TurismoGT</p>
            </div>
        </div>
    </div>
</body>
</html>
