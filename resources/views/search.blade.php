<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>
     Car Rental
    </title>
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
    </style>
 </head>
 <body class="bg-gray-100">
    <header class="bg-white shadow-md">
     <div class="p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
         <img alt="Logo" class="mr-2 w-40" src="{{ asset('storage/img/new logo.png') }}"/>
        </div>
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
     <div class="shadow-md mt-4 rounded-lg">
        <div class="bg-white p-4 flex justify-between items-center rounded-lg" style="border-radius: 15px;">
         <div class="flex items-center flex-col">
            <img alt="Logo" class="mr-2 w-40" src="{{ asset('storage/img/logo new.png') }}"/>
            <div>
             <p>
                18 Nov 2024 - 1 Day
             </p>
            </div>
         </div>
         <button class="bg-orange-500 text-white px-4 py-2 rounded">
            Modify Search
         </button>
        </div>
     </div>
    </header>
    <main class="p-8">
     <div class="flex space-x-8">
        <aside class="bg-white p-4 rounded shadow-md w-1/4">
         <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">
             Filter
            </h3>
            <button class="text-orange-500">
             Reset
            </button>
         </div>
         <hr class="border-black mb-4"/>
         <div class="mb-4">
            <h4 class="font-bold mb-2">
             Price Range
            </h4>
            <input class="w-full" max="5000000" min="0" type="range" oninput="updatePrice(this.value)"/>
            <div class="flex justify-between text-sm">
             <span>
                Rp 0
             </span>
             <span id="price-display">
                Rp 5.000.000
             </span>
            </div>
         </div>
         <hr class="border-black mb-4"/>
         <div class="mb-4">
            <h4 class="font-bold mb-2">
             Seat Capacity
            </h4>
            <div class="flex space-x-2">
             <button class="seat-button border border-orange-500 text-orange-500 px-2 py-1 rounded" onclick="selectSeat(this)">
                4 Seat
             </button>
             <button class="seat-button border border-orange-500 text-orange-500 px-2 py-1 rounded" onclick="selectSeat(this)">
                5-6 Seat
             </button>
             <button class="seat-button border border-orange-500 text-orange-500 px-2 py-1 rounded" onclick="selectSeat(this)">
                &gt;6 Seat
             </button>
            </div>
         </div>
         <hr class="border-black mb-4"/>
         <div>
            <h4 class="font-bold mb-2">
             Transmition
            </h4>
            <div class="flex space-x-2">
             <button class="transmission-button border border-orange-500 text-orange-500 px-2 py-1 rounded" onclick="selectTransmission(this)">
                Manual
             </button>
             <button class="transmission-button border border-orange-500 text-orange-500 px-2 py-1 rounded" onclick="selectTransmission(this)">
                Matic
             </button>
            </div>
         </div>
        </aside>
        <section class="flex-1 space-y-6">
         <div class="bg-white p-6 rounded shadow-md flex items-center space-x-6 relative">
            <div class="absolute top-0 left-0 bg-yellow-500 text-white px-12 py-1 rounded-tr-lg rounded-br-lg" style="border-radius: 0 15px 15px 0;">
             Manual
            </div>
            <div class="flex items-center justify-center w-40">
             <img alt="Daihatsu Terios" class="w-32 h-20 object-cover" height="80" src="/Source/Terios.png" width="130"/>
            </div>
            <div class="flex-1">
             <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">
                 Daihatsu Terios
                </h3>
                <p class="text-2xl font-bold text-orange-500">
                 Rp 300.000 <span class="text-black">/ 1 Day</span>
                </p>
             </div>
             <p class="text-lg text-orange-500">
                <i class="fas fa-users">
                </i>
                6 Seat
             </p>
             <p class="text-lg text-orange-500">
                <i class="fas fa-suitcase">
                </i>
                2 Baggage
             </p>
             <button class="bg-orange-500 text-white px-4 py-2 rounded mt-1">
                Book Now
             </button>
            </div>
         </div>
         <div class="bg-white p-6 rounded shadow-md flex items-center space-x-6 relative">
            <div class="absolute top-0 left-0 bg-blue-500 text-white px-12 py-1 rounded-tr-lg rounded-br-lg" style="border-radius: 0 15px 15px 0;">
             Matic
            </div>
            <div class="flex items-center justify-center w-40">
             <img alt="Daihatsu Rocky" class="w-32 h-20 object-cover" height="80" src="/Source/roky.png" width="130"/>
            </div>
            <div class="flex-1">
             <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">
                 Daihatsu Rocky
                </h3>
                <p class="text-2xl font-bold text-orange-500">
                 Rp 600.000 <span class="text-black">/ 1 Day</span>
                </p>
             </div>
             <p class="text-lg text-orange-500">
                <i class="fas fa-users">
                </i>
                4 Seat
             </p>
             <p class="text-lg text-orange-500">
                <i class="fas fa-suitcase">
                </i>
                3 Baggage
             </p>
             <button class="bg-orange-500 text-white px-4 py-2 rounded mt-1">
                Book Now
             </button>
            </div>
         </div>
         <div class="bg-white p-6 rounded shadow-md flex items-center space-x-6 relative">
            <div class="absolute top-0 left-0 bg-blue-500 text-white px-12 py-1 rounded-tr-lg rounded-br-lg" style="border-radius: 0 15px 15px 0;">
             Matic
            </div>
            <div class="flex items-center justify-center w-40">
             <img alt="Toyota Agya" class="w-32 h-20 object-cover" height="80" src="/Source/agya no bg.png" width="130"/>
            </div>
            <div class="flex-1">
             <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">
                 Toyota Agya
                </h3>
                <p class="text-2xl font-bold text-orange-500">
                 Rp 320.000 <span class="text-black">/ 1 Day</span>
                </p>
             </div>
             <p class="text-lg text-orange-500">
                <i class="fas fa-users">
                </i>
                4 Seat
             </p>
             <p class="text-lg text-orange-500">
                <i class="fas fa-suitcase">
                </i>
                3 Baggage
             </p>
             <button class="bg-orange-500 text-white px-4 py-2 rounded mt-1">
                Book Now
             </button>
            </div>
         </div>
        </section>
     </div>
    </main>
 </body>
</html>
