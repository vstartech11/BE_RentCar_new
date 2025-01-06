<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>
        Registration
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&amp;display=swap" rel="stylesheet"/>
    <style>
        .custom-font {
            font-family: 'Fredoka One', cursive;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="bg-gray-300 h-12"></div>
    <div class="flex flex-col lg:flex-row min-h-screen">
        <div class="lg:w-1/2 relative">
            <img alt="A car parked on the side of a road with a scenic mountain view" class="w-full h-full object-cover" height="600" src="{{ asset('img/coverlogin.png') }}" width="800"/>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white text-center custom-font text-4xl md:text-5xl lg:text-6xl">
                    <p>anytime</p>
                    <p>anywhere</p>
                    <p>with ease</p>
                    <p>and no</p>
                    <p>hassle</p>
                </div>
            </div>
        </div>
        <div class="lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <h2 class="text-2xl font-bold mb-6">Registration</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <!-- Menampilkan pesan error -->
                    @if(session('error'))
                        <div class="alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="mb-4">
                        <label class="block text-gray-700">Full Name</label>
                        <input class="w-full px-3 py-2 border border-orange-500 rounded" name="name" placeholder="Enter your Full Name" type="text" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input class="w-full px-3 py-2 border border-orange-500 rounded" name="email" placeholder="Enter your Email" type="email" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Password</label>
                        <input class="w-full px-3 py-2 border border-orange-500 rounded" name="password" placeholder="Enter your Password" type="password" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Confirm Password</label>
                        <input class="w-full px-3 py-2 border border-orange-500 rounded" name="password_confirmation" placeholder="Confirm your Password" type="password" required/>
                    </div>
                    <button class="w-full bg-orange-500 text-white py-2 rounded" type="submit">Continue</button>
                </form>
                <div class="mt-4 text-center">
                    <p>Already have an account? <a class="text-orange-500" href="#">Sign In now</a></p>
                    <p class="text-sm text-gray-500 mt-2">
                        By creating an account, you agree to the
                        <a class="text-orange-500" href="#">Terms and Conditions</a> and
                        <a class="text-orange-500" href="#">Privacy Policy</a> of TurismoGT
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
