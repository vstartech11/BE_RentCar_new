    @php
        $rental_duration = $rental_duration ?? 1;
        $start_date = $start_date ?? date('Y-m-d');
        $start_time = $start_time ?? date('H:i');
    @endphp

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Car Rental</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
        <style>
            body {
                font-family: 'Roboto', sans-serif;
            }
            .hover-underline:hover {
                text-decoration: underline;
            }
            .hidden-info {
                display: none;
                position: absolute;
                background-color: white;
                border: 1px solid #ccc;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="bg-gray-100">
    <header class="bg-white shadow-md">
        <div class="p-4 flex justify-between items-center shadow-lg">
            <div class="flex items-center">
                <img alt="Logo" class="mr-2 w-40" src="{{ asset('storage/img/new logo.png') }}"/>
            </div>
            <div class="flex space-x-4 items-center">
                <div class="relative z-50">
                    <button id="user-menu-btn" class="bg-orange-500 text-white px-4 py-2 rounded">Welcome {{ Auth::user()->name }}</button>
                    <div id="user-menu" class="absolute hidden top-full right-0 bg-white text-gray-700 shadow-lg rounded w-48 z-50">
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
        <div class="shadow-md mt-4 rounded-lg">
            <div class="bg-white p-4 flex justify-between items-center rounded-lg" style="border-radius: 15px;">
                <div class="flex items-center justify-center flex-col w-full">
                    <img alt="Logo" class="mr-2 w-40" src="{{ asset('storage/img/logo new.png') }}"/>
                    <div class="text-center mt-2">
                        <p class="text-lg font-semibold text-gray-700">Rental Details</p>
                        <div class="flex justify-center space-x-4 text-sm text-gray-500">
                            <span>Start Date: <span class="font-medium">{{ $start_date }}</span></span>
                            <span>Start Time: <span class="font-medium">{{ $start_time }}</span></span>
                            <span>Duration: <span class="font-medium">{{ $rental_duration }} Day(s)</span></span>
                        </div>
                    </div>
                </div>
                <div class="relative z-50">
                    <button id="modify-search-btn" class="bg-orange-500 text-white px-4 py-2 rounded z-10">
                        Modify Search
                    </button>
                    <div id="modifySearchForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                        <div class="bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl">
                            <div class="flex justify-between items-center mb-4">
                                <h2 id="formTitle" class="text-2xl font-bold text-orange-500 border-b-4 border-[#ea580c] pb-4">
                                    Modify Search
                                </h2>
                                <button onclick="toggleForm('close')" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <form id="searchForm" action="{{ route('search') }}" method="POST">
                                @csrf
                                <div class="flex space-x-4">
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Start Date</label>
                                        <input id="startDate" class="w-full border border-orange-500 rounded px-4 py-2" type="date" name="start_date" value="{{ $start_date }}" required/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Start Time</label>
                                        <input id="startTime" class="w-full border border-orange-500 rounded px-4 py-2" type="time" name="start_time" value="{{ $start_time }}" required/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Rental Duration (Days)</label>
                                        <input id="rentalDuration" class="w-full border border-orange-500 rounded px-4 py-2" type="number" name="rental_duration" value="{{ $rental_duration }}" required/>
                                    </div>
                                </div>
                                <div class="flex space-x-4 mt-4">
                                    <div class="flex-1 flex items-end">
                                        <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="p-8">
        @if (session('status'))
            <div id="status-message" class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('status') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('status-message').style.display = 'none';
                }, 5000); // Hide after 5 seconds
            </script>
        @endif    <div class="flex space-x-8">
            <aside class="bg-white p-4 rounded shadow-md w-1/4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Filter</h3>
                    <button class="text-orange-500">Reset</button>
                </div>
                <hr class="border-black mb-4"/>
                <div class="mb-4">
                    <h4 class="font-bold mb-2">Price Range</h4>
                    @php
                    $maxPrice = $vehicles->max('price');
                    @endphp
                    <input class="w-full" max="{{ $maxPrice }}" min="0" type="range" id="price-range" value="{{ $maxPrice }}" disabled/>
                    <div class="flex justify-between text-sm">
                        <span>Rp 0</span>
                        <span id="price-display">Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
                <hr class="border-black mb-4"/>
                <div>
                    <h4 class="font-bold mb-2">Type Vehicle</h4>
                    <select class="w-full border border-gray-300 rounded p-2">
                        <option value="">All</option>
                        @foreach($typeVehicles as $typeVehicle)
                        <option value="{{ $typeVehicle->id }}">{{ $typeVehicle->name }}</option>
                        @endforeach
                    </select>
                </div>
            </aside>
            <section class="flex-1 space-y-6">
                <script>
                function updatePrice(value) {
                    const priceDisplay = document.getElementById('price-display');
                    priceDisplay.textContent = `Rp ${parseInt(value).toLocaleString()}`;
                    const vehicles = document.querySelectorAll('section > div[data-type-id]');
                    vehicles.forEach(vehicle => {
                        const vehiclePrice = parseInt(vehicle.querySelector('.text-orange-500').textContent.replace(/[^0-9]/g, ''));
                        if (vehiclePrice <= parseInt(value)) {
                            vehicle.style.display = 'flex';
                        } else {
                            vehicle.style.display = 'none';
                        }
                    });
                }
                document.addEventListener('DOMContentLoaded', function () {
                    const typeVehicleSelect = document.querySelector('select');
                    typeVehicleSelect.addEventListener('change', function () {
                        const selectedType = this.value;
                        const vehicles = document.querySelectorAll('section > div');
                        vehicles.forEach(vehicle => {
                            if (vehicle.dataset.typeId === selectedType || selectedType === '') {
                                vehicle.style.display = 'flex';
                            } else {
                                vehicle.style.display = 'none';
                            }
                        });
                    });

                    const modifySearchBtn = document.getElementById('modify-search-btn');
                    const form = document.getElementById('modifySearchForm');
                    modifySearchBtn.addEventListener('click', function () {
                        form.classList.toggle('hidden');
                    });

                    const userMenuBtn = document.getElementById('user-menu-btn');
                    const userMenu = document.getElementById('user-menu');
                    userMenuBtn.addEventListener('mouseenter', function () {
                        userMenu.classList.remove('hidden');
                    });
                    userMenuBtn.addEventListener('mouseleave', function () {
                        userMenu.classList.add('hidden');
                    });
                    userMenu.addEventListener('mouseenter', function () {
                        userMenu.classList.remove('hidden');
                    });
                    userMenu.addEventListener('mouseleave', function () {
                        userMenu.classList.add('hidden');
                    });

                    const priceRange = document.getElementById('price-range');
                    const priceDisplay = document.getElementById('price-display');
                    priceRange.addEventListener('input', function () {
                        const selectedPrice = this.value;
                        priceDisplay.textContent = `Rp ${parseInt(selectedPrice).toLocaleString()}`;
                        const vehicles = document.querySelectorAll('section > div');
                        vehicles.forEach(vehicle => {
                            const vehiclePrice = parseInt(vehicle.querySelector('.text-orange-500').textContent.replace(/[^0-9]/g, ''));
                            if (vehiclePrice <= selectedPrice) {
                                vehicle.style.display = 'flex';
                            } else {
                                vehicle.style.display = 'none';
                            }
                        });
                    });
                });

                function toggleForm(action) {
                    const form = document.getElementById('modifySearchForm');
                    if (action === 'close') {
                        form.classList.add('hidden');
                    }
                }
                </script>
                @foreach($vehicles as $vehicle)
                @php
                $typeVehicle = $typeVehicles->firstWhere('id', $vehicle->type_id);
                @endphp
                <div class="bg-white p-6 rounded shadow-md flex items-center space-x-6 relative" data-type-id="{{ $vehicle->type_id }}">
                    <div class="flex items-center justify-center w-40">
                        <img alt="{{ $vehicle->name }}" class="w-32 h-20 object-contain" height="80" src="{{ asset('storage/img/cars/' . $typeVehicle->locationImg) }}" width="130"/>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold">{{ $vehicle->name }}</h3>
                            <div class="flex flex-col items-start">
                                <p class="text-sm text-gray-500">License Plate:</p>
                                <p class="text-lg bg-gray-200 px-2 py-1 rounded text-gray-700">{{ $vehicle->license_plate }}</p>
                            </div>
                            <p class="text-2xl font-bold text-orange-500">Rp {{ number_format($vehicle->price, 0, ',', '.') }} <span class="text-black">/ 1 Day</span></p>
                        </div>
                        <p class="text-lg text-orange-500"><i class="fas fa-info-circle"></i> Status: {{ $vehicle->status }}</p>
                        <p class="text-lg text-gray-700">Description: {{ $typeVehicle->description }}</p>
                        <div class="flex justify-end">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded mt-1" onclick="togglePaymentForm({{ $vehicle->id }})">Book Now</button>
                        </div>
                        <div id="paymentForm-{{ $vehicle->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                            <div class="bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-2xl font-bold text-orange-500 border-b-4 border-[#ea580c] pb-4">Payment Form</h2>
                                    <button onclick="togglePaymentForm({{ $vehicle->id }}, 'close')" class="text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form action="{{ route('payment') }}" method="POST">
                                    @csrf
                                    <div class="flex space-x-4">
                                        <div class="flex-1">
                                            <label class="block text-gray-700 font-bold">Payment Method</label>
                                            <p class="font-bold">Cash on Delivery</p>
                                            <input type="hidden" name="paymentMethod" value="cash">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-700 font-bold">Amount</label>
                                            <p class="font-bold">Rp {{ number_format($rental_duration * $vehicle->price, 0, ',', '.') }}</p>
                                            <input type="hidden" name="amount" value="{{ $rental_duration * $vehicle->price }}">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-700 font-bold">Pickup Date</label>
                                            <p class="font-bold">{{ $start_date }}</p>
                                            <input type="hidden" name="pickup_date" value="{{ $start_date }}">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-700 font-bold">Pickup Time</label>
                                            <p class="font-bold">{{ $start_time }}</p>
                                            <input type="hidden" name="pickup_time" value="{{ $start_time }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                    <input type="hidden" name="rental_duration" value="{{ $rental_duration }}">
                                    <div class="flex space-x-4 mt-4">
                                        <div class="flex-1 flex items-end">
                                            <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Pay Now</button>
                                        </div>
                                    </div>
                                </form>    </div>
                        </div>
                        <script>
                        function togglePaymentForm(vehicleId, action) {
                            const form = document.getElementById(`paymentForm-${vehicleId}`);
                            if (action === 'close') {
                                form.classList.add('hidden');
                            } else {
                                form.classList.toggle('hidden');
                            }
                        }
                        </script>
                    </div>
                </div>
                @endforeach
            </section>
        </div>
    </main>
    </body>
    </html>
