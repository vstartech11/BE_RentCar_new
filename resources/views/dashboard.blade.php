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
                Drive in style with our
                <span class="text-orange-500">top rated car</span>
                rentals
            </h1>
        </div>
        <div class="absolute top-64 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Reservation
            </h2>
            <form action="{{ route('search') }}" method="POST">
            @csrf
            <div class="flex space-x-4">
            <div class="flex-1">
            <label class="block text-gray-700">Rental Duration</label>
            <input class="w-full border border-orange-500 rounded px-4 py-2" type="number" name="rental_duration" placeholder="Enter duration in days" min="1" max="10" value="1"/>
            </div>
            <div class="flex-1">
            <label class="block text-gray-700">Start Date</label>
            <input class="w-full border border-orange-500 rounded px-4 py-2" type="date" name="start_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"/>
            </div>
            <div class="flex-1">
            <label class="block text-gray-700">Start Time (GMT+8)</label>
            <input class="w-full border border-orange-500 rounded px-4 py-2" type="time" name="start_time" value="{{ \Carbon\Carbon::now()->addHours(8)->format('H:i') }}"/>
            </div>
            <div class="flex-1 flex items-end">
            <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Search</button>
            </div>
            </div>
            </form>
        </div>
        <div class="absolute top-[calc(100%-30rem)] left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl">
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            Your Order
            </h2>
            @if ($transactions->isEmpty())
            <p class="text-gray-700">You have no transactions.</p>
            @else
            <table class="min-w-full bg-white">
                <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Vehicle Name</th>
                    <th class="py-2 px-4 border-b">Reservation Date</th>
                    <th class="py-2 px-4 border-b">Payment Date</th>
                    <th class="py-2 px-4 border-b">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                    <td class="py-2 px-4 border-b">{{ $transaction->date }}</td>
                    <td class="py-2 px-4 border-b">{{ $transaction->vehicleName }}</td>
                    <td class="py-2 px-4 border-b">{{ $transaction->reservationDate }}</td>
                    <td class="py-2 px-4 border-b">{{ $transaction->paymentDate }}</td>
                    <td class="py-2 px-4 border-b">
                        @if ($transaction->status == 'pending')
                            <span class="text-gray-500">{{ $transaction->status }}</span>
                        @elseif ($transaction->status == 'confirmed')
                            <span class="text-green-500">{{ $transaction->status }}</span>
                        @elseif ($transaction->status == 'completed')
                            <span class="text-blue-500">{{ $transaction->status }}</span>
                        @elseif ($transaction->status == 'cancelled')
                            <span class="text-red-500">{{ $transaction->status }}</span>
                        @endif
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>

        @if (session('status'))
            <div class="absolute top-80 left-1/2 transform -translate-x-1/2 bg-green-500 text-white rounded px-4 py-2">
                {{ session('status') }}
            </div>
        @endif

    </div>
</body>
</html>
