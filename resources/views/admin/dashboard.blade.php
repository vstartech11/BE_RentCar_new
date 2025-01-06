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
        <img alt="Background image of a car on a scenic road" class="absolute top-0 left-0 w-full h-full object-cover" height="671" src="{{ asset('img/newbackround.png') }}" width="1280"/>
        <div class="absolute top-0 left-0 w-full h-8 bg-gray-300"></div>
        <div class="absolute top-8 left-0 w-full h-12 bg-white shadow-md flex items-center justify-between px-4">
            <img alt="Company logo" class="h-10" height="41" src="{{ asset('img/new logo.png') }}" width="138"/>
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
                Add a new
                <span class="text-orange-500">car</span>
                to the fleet
            </h1>
        </div>
        <div class="absolute top-64 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Add Car
            </h2>
            <form action="{{ route('add_vehicle') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-gray-700">Car Name</label>
                        <input class="w-full border border-orange-500 rounded px-4 py-2" type="text" name="name" placeholder="Enter car name" required/>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700">Car License</label>
                        <input class="w-full border border-orange-500 rounded px-4 py-2" type="text" name="license" placeholder="Enter car license" required/>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700">Car Type</label>
                        <select class="w-full border border-orange-500 rounded px-4 py-2" name="type_vehicle_id" required>
                            <option value="" disabled selected>Select car type</option>
                            @foreach($typeVehicle as $typeVehicles)
                                <option value="{{ $typeVehicles->id }}">name: {{ $typeVehicles->name }}, brand: {{ $typeVehicles->brand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex space-x-4 mt-4">
                    <div class="flex-1">
                        <label class="block text-gray-700">Rental Price</label>
                        <input class="w-full border border-orange-500 rounded px-4 py-2" type="number" name="price" placeholder="Enter rental price" required/>
                    </div>
                    <div class="flex-1 flex items-end">
                        <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Add Car</button>
                    </div>
                </div>
            </form>
        </div>
        @if (session('status'))
            <div class="absolute top-80 left-1/2 transform -translate-x-1/2 bg-green-500 text-white rounded px-4 py-2">
                {{ session('status') }}
            </div>
        @endif
        <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 text-center w-3/4 max-w-4xl">
            <p class="mt-4 text-xl">
            Add new cars to expand your fleet and offer more options to your customers.
            </p>
        </div>
    </div>
</body>
</html>
