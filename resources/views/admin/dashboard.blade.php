<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .hover-underline:hover {
            text-decoration: underline;
        }
    </style>
    <title>Dashboard</title>
</head>
<body class="bg-gray-100 font-inter">
    <div class="relative w-full h-screen">
        <img alt="Background image of a car on a scenic road" class="absolute top-0 left-0 w-full h-full object-cover" height="671" src="{{ asset('storage/img/newbackround.png') }}" width="1280"/>
        <div class="absolute top-0 left-0 w-full h-8 bg-gray-300"></div>
        <div class="absolute top-8 left-0 w-full h-12 bg-white shadow-md flex items-center justify-between px-4">
            <img alt="Company logo" class="h-10" height="41" src="{{ asset('storage/img/new logo.png') }}" width="138"/>
            <div class="flex space-x-4 items-center">
                <div class="relative group">
                    <button class="bg-orange-500 text-white px-4 py-2 rounded">Welcome {{ Auth::user()->name }}</button>
                    <div class="absolute hidden group-hover:block top-full right-0 bg-white text-gray-700 shadow-lg rounded w-48 group-hover:flex">
                        <ul class="py-2">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Profile</li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Settings</li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute top-40 left-1/2 transform -translate-x-1/2 text-center">
            <h1 class="text-4xl font-bold">
            Manage your
            <span class="text-orange-500">fleet</span>
            </h1>
        </div>
        <div class="absolute top-56 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl text-center">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Edit Type Vehicles
            </h2>
            <a href="{{ route('admin.type_vehicle') }}" class="inline-block bg-orange-500 text-white rounded px-4 py-2 hover:bg-orange-600">
            Edit Type Vehicles
            </a>
        </div>
        <div class="absolute top-[26rem] left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl text-center">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Edit Vehicle
            </h2>
            <a href="{{ route('admin.vehicle') }}" class="inline-block bg-orange-500 text-white rounded px-4 py-2 hover:bg-orange-600">
            Edit Vehicle
            </a>
        </div>
        <div class="absolute top-[38rem] left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl text-center">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Edit Payment
            </h2>
            <a href="{{ route('admin.payment') }}" class="inline-block bg-orange-500 text-white rounded px-4 py-2 hover:bg-orange-600">
            Edit Payment
            </a>
        </div>
        <div class="absolute top-[50rem] left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl text-center">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Manage Account
            </h2>
            <a href="{{ route('admin.account') }}" class="inline-block bg-orange-500 text-white rounded px-4 py-2 hover:bg-orange-600">
            Manage Account
            </a>
        </div>
        @if (session('status'))
            <div id="statusMessage" class="absolute top-80 left-1/2 transform -translate-x-1/2 bg-green-500 text-white rounded px-4 py-2">
            {{ session('status') }}
            </div>
            <script>
            setTimeout(function() {
                document.getElementById('statusMessage').style.display = 'none';
            }, 3000); // Adjust the time (in milliseconds) as needed
            </script>
        @endif
        @if(session('error'))
            <div id="errorMessage" class="alert alert-danger mb-4">
            {{ session('error') }}
            </div>
            <script>
            setTimeout(function() {
            document.getElementById('errorMessage').style.display = 'none';
            }, 3000); // Adjust the time (in milliseconds) as needed
            </script>
        @endif
    </div>
</body>
</html>
