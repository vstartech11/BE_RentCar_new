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
    <title>Vehicle</title>
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

        <div class="absolute top-20 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-11/12 max-w-6xl mt-20 overflow-y-auto" style="max-height: 80vh;">
            <div class="flex justify-end">
            <button class="bg-orange-500 text-white px-4 py-2 rounded" onclick="toggleForm('add')">Add New Vehicle</button>
            </div>
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            List Car
            </h2>

            <div class="overflow-x-auto">
            @if($vehicles->isEmpty())
                <p class="text-center text-gray-500">No vehicles available.</p>
            @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="py-4 px-6 text-left">Car Name</th>
                    <th class="py-4 px-6 text-left">Car License</th>
                    <th class="py-4 px-6 text-left">Car Image</th>
                    <th class="py-4 px-6 text-left">Rental Price</th>
                    <th class="py-4 px-6 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vehicles as $vehicle)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-4 px-6">{{ $vehicle->name }}</td>
                    <td class="py-4 px-6">{{ $vehicle->license_plate }}</td>
                    <td class="py-4 px-6">
                    @foreach($typeVehicles as $typeVehicle)
                    @if($typeVehicle->id == $vehicle->type_id)
                        <img src="{{ asset('storage/img/cars/' . $typeVehicle->locationImg) }}" alt="{{ $vehicle->name }}" class="h-32 w-32 object-cover rounded" style="object-fit: contain;">
                    @endif
                    @endforeach
                    </td>
                    <td class="py-4 px-6">{{ $vehicle->price }}</td>
                    <td class="py-4 px-6">
                    <a href="javascript:void(0)" onclick="toggleForm('edit', {{ $vehicle }})" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('delete_vehicle', $vehicle->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                    </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
            </div>
        </div>

        <div id="addVehicleForm" class="absolute top-64 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl hidden">
            <div class="flex justify-between items-center mb-4">
            <h2 id="formTitle" class="text-2xl font-bold text-orange-500 border-b-4 border-[#ea580c] pb-4">
                Add Car
            </h2>
            <button onclick="toggleForm('close')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            </div>
            <form id="vehicleForm" action="{{ route('add_vehicle') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">
            <div class="flex space-x-4">
                <div class="flex-1">
                <label class="block text-gray-700">Car Name</label>
                <input id="carName" class="w-full border border-orange-500 rounded px-4 py-2" type="text" name="name" placeholder="Enter car name" required/>
                </div>
                <div class="flex-1">
                <label class="block text-gray-700">Car License</label>
                <input id="carLicense" class="w-full border border-orange-500 rounded px-4 py-2" type="text" name="license" placeholder="Enter car license" required/>
                </div>
                <div class="flex-1">
                <label class="block text-gray-700">Car Type</label>
                <select id="carType" class="w-full border border-orange-500 rounded px-4 py-2" name="type_id" required>
                    <option value="" disabled selected>Select car type</option>
                    @foreach($typeVehicles as $typeVehicle)
                    <option value="{{ $typeVehicle->id }}">
                    <div class="flex flex-col">
                        <span class="font-bold">{{ $typeVehicle->name }}, </span>
                        <span class="text-sm text-gray-500">{{ $typeVehicle->description }}</span>
                    </div>
                    </option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="flex space-x-4 mt-4">
                <div class="flex-1">
                <label class="block text-gray-700">Rental Price</label>
                <input id="rentalPrice" class="w-full border border-orange-500 rounded px-4 py-2" type="number" name="price" placeholder="Enter rental price" required/>
                </div>
                <div class="flex-1 flex items-end">
                <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Save Car</button>
                </div>
            </div>
            </form>
        </div>

        <script>
            function toggleForm(action, vehicle = null) {
            const form = document.getElementById('addVehicleForm');
            const formTitle = document.getElementById('formTitle');
            const formMethod = document.getElementById('formMethod');
            const vehicleForm = document.getElementById('vehicleForm');
            const carName = document.getElementById('carName');
            const carLicense = document.getElementById('carLicense');
            const carType = document.getElementById('carType');
            const rentalPrice = document.getElementById('rentalPrice');

            if (action === 'add') {
                formTitle.textContent = 'Add Car';
                formMethod.value = 'POST';
                vehicleForm.action = "{{ route('add_vehicle') }}";
                carName.value = '';
                carLicense.value = '';
                carType.value = '';
                rentalPrice.value = '';
            } else if (action === 'edit' && vehicle) {
                formTitle.textContent = 'Edit Car';
                formMethod.value = 'PUT';
                vehicleForm.action = vehicle ? "{{ route('edit_vehicle', '') }}/" + vehicle.id : "{{ route('add_vehicle') }}";
                carName.value = vehicle.name;
                carLicense.value = vehicle.license_plate;
                carType.value = vehicle.type_id;
                rentalPrice.value = vehicle.price;
            } else if (action === 'close') {
                form.classList.add('hidden');
                return;
            }

            form.classList.toggle('hidden');
            }
        </script>
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
