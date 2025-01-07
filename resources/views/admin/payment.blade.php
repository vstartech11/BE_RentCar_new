<!-- resources/views/admin/payment.blade.php -->
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
    <title>Manage Payment</title>
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

        <div class="absolute top-20 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-11/12 max-w-6xl mt-20 overflow-y-auto" style="max-height: 80vh;">
            <div class="flex justify-end">
            <button class="bg-orange-500 text-white px-4 py-2 rounded" onclick="toggleForm('add')">Add New Payment</button>
            </div>
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            List Payments
            </h2>

            <div class="overflow-x-auto">
            @if($payments->isEmpty())
                <p class="text-center text-gray-500">No payments available.</p>
            @else
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mx-auto">
                <thead class="bg-orange-500 text-white">
                    <tr>
                    <th class="py-4 px-6 text-left">Payment ID</th>
                    <th class="py-4 px-6 text-left">Payment Date</th>
                    <th class="py-4 px-6 text-left">Amount</th>
                    <th class="py-4 px-6 text-left">Payment Method</th>
                    <th class="py-4 px-6 text-left">Pickup Date</th>
                    <th class="py-4 px-6 text-left">Return Date</th>
                    <th class="py-4 px-6 text-left">Vehicle Name</th>
                    <th class="py-4 px-6 text-left">Admin Name</th>
                    <th class="py-4 px-6 text-left">Customer Name</th>
                    <th class="py-4 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-4 px-6">{{ $payment->id }}</td>
                        <td class="py-4 px-6">{{ $payment->paymentDate }}</td>
                        <td class="py-4 px-6">{{ $payment->amount }}</td>
                        <td class="py-4 px-6">{{ $payment->paymentMethod }}</td>
                        <td class="py-4 px-6">{{ $payment->pickupDate }}</td>
                        <td class="py-4 px-6">{{ $payment->returnDate }}</td>
                        <td class="py-4 px-6">{{ $payment->vehicleName }}</td>
                        <td class="py-4 px-6">{{ $payment->adminName }}</td>
                        <td class="py-4 px-6">{{ $payment->customerName }}</td>
                        <td class="py-4 px-6">
                        <a href="javascript:void(0)" onclick="toggleForm('edit', @json($payment))" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('delete_payment', $payment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this payment?');">
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

        <div id="addPaymentForm" class="absolute top-64 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 id="formTitle" class="text-2xl font-bold text-orange-500 border-b-4 border-[#ea580c] pb-4">
                    Add Payment
                </h2>
                <button onclick="toggleForm('close')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="paymentForm" action="{{ route('add_payment') }}" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-gray-700">User</label>
                        <select id="paymentUser" class="w-full border border-orange-500 rounded px-4 py-2" name="user_id" required>
                            <option value="" disabled selected>Select user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700">Amount</label>
                        <input id="paymentAmount" class="w-full border border-orange-500 rounded px-4 py-2" type="number" name="amount" placeholder="Enter amount" required/>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700">Status</label>
                        <select id="paymentStatus" class="w-full border border-orange-500 rounded px-4 py-2" name="status" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
                <div class="flex space-x-4 mt-4">
                    <div class="flex-1 flex items-end">
                        <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Save Payment</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function toggleForm(action, payment = null) {
                const form = document.getElementById('addPaymentForm');
                const formTitle = document.getElementById('formTitle');
                const formMethod = document.getElementById('formMethod');
                const paymentForm = document.getElementById('paymentForm');
                const paymentUser = document.getElementById('paymentUser');
                const paymentAmount = document.getElementById('paymentAmount');
                const paymentStatus = document.getElementById('paymentStatus');

                if (action === 'add') {
                    formTitle.textContent = 'Add Payment';
                    formMethod.value = 'POST';
                    paymentForm.action = "{{ route('add_payment') }}";
                    paymentUser.value = '';
                    paymentAmount.value = '';
                    paymentStatus.value = '';
                } else if (action === 'edit' && payment) {
                    formTitle.textContent = 'Edit Payment';
                    formMethod.value = 'PUT';
                    paymentForm.action = "{{ route('edit_payment', '') }}/" + payment.id;
                    paymentUser.value = payment.user_id;
                    paymentAmount.value = payment.amount;
                    paymentStatus.value = payment.status;
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
            <div id="errorMessage" class="absolute top-80 left-1/2 transform -translate-x-1/2 bg-red-500 text-white rounded px-4 py-2">
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
