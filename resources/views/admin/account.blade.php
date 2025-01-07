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
    <title>Manage Vehicle</title>
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
            <button class="bg-orange-500 text-white px-4 py-2 rounded" onclick="toggleForm('add')">Add New Account</button>
            </div>
            <h2 class="text-2xl font-bold text-orange-500 mb-4 border-b-4 border-[#ea580c] pb-4">
            List Accounts
            </h2>

            <div class="overflow-x-auto">
            @if($accounts->isEmpty())
            <p class="text-center text-gray-500">No accounts available.</p>
            @else
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mx-auto">
            <thead class="bg-orange-500 text-white">
            <tr>
            <th class="py-4 px-6 text-left">Name</th>
            <th class="py-4 px-6 text-left">Email</th>
            <th class="py-4 px-6 text-left">Role</th>
            <th class="py-4 px-6 text-left">Customer Validate</th>
            <th class="py-4 px-6 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
            @if($account->id !== Auth::user()->id)
            <tr class="border-b hover:bg-gray-100">
            <td class="py-4 px-6">{{ $account->name }}</td>
            <td class="py-4 px-6">{{ $account->email }}</td>
            <td class="py-4 px-6">{{ $account->role }}</td>
            <td class="py-4 px-6">
            @if($account->role == 'customer')
            <select disabled>
            <option value="1" {{ $account->customer_validate ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$account->customer_validate ? 'selected' : '' }}>No</option>
            </select>
            @endif
            </td>
            <td class="py-4 px-6">
            <a href="javascript:void(0)" onclick="toggleForm('edit', {{ $account }})" class="text-blue-500 hover:underline">Edit</a>
            <form action="{{ route('delete_account', $account->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this account?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
            </form>
            </td>
            </tr>
            @endif
            @endforeach
            </tbody>
            </table>
            @endif
            </div>
        </div>

        <div id="addAccountForm" class="absolute top-64 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-lg p-8 w-3/4 max-w-4xl hidden">
            <div class="flex justify-between items-center mb-4">
            <h2 id="formTitle" class="text-2xl font-bold text-orange-500 border-b-4 border-[#ea580c] pb-4">
            Add Account
            </h2>
            <button onclick="toggleForm('close')" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
            </button>
            </div>
            <form id="accountForm" action="{{ route('add_account') }}" method="POST">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">
            <div class="flex space-x-4">
            <div class="flex-1">
            <label class="block text-gray-700">Name</label>
            <input id="accountName" class="w-full border border-orange-500 rounded px-4 py-2" type="text" name="name" placeholder="Enter name" required/>
            </div>
            <div class="flex-1">
            <label class="block text-gray-700">Email</label>
            <input id="accountEmail" class="w-full border border-orange-500 rounded px-4 py-2" type="email" name="email" placeholder="Enter email" required/>
            </div>
            <div class="flex-1">
            <label class="block text-gray-700">Password</label>
            <input id="accountPassword" class="w-full border border-orange-500 rounded px-4 py-2" type="password" name="password" placeholder="Enter password" required/>
            </div>
            <div class="flex-1">
            <label class="block text-gray-700">Role</label>
            <select id="accountRole" class="w-full border border-orange-500 rounded px-4 py-2" name="role" required onchange="toggleValidateSelect()">
            <option value="" disabled selected>Select role</option>
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
            </select>
            </div>
            </div>
            <div class="flex space-x-4 mt-4">
            <div class="flex-1" id="validateSelect" style="display: none;">
            <label class="block text-gray-700">Customer Validate</label>
            <select id="accountValidate" class="w-full border border-orange-500 rounded px-4 py-2" name="customer_validate">
            <option value="1">Yes</option>
            <option value="0">No</option>
            </select>
            </div>
            <div class="flex-1 flex items-end">
            <button class="w-full bg-orange-500 text-white rounded px-4 py-2" type="submit">Save Account</button>
            </div>
            </div>
            </form>
        </div>

        <script>
            function toggleForm(action, account = null) {
            const form = document.getElementById('addAccountForm');
            const formTitle = document.getElementById('formTitle');
            const formMethod = document.getElementById('formMethod');
            const accountForm = document.getElementById('accountForm');
            const accountName = document.getElementById('accountName');
            const accountEmail = document.getElementById('accountEmail');
            const accountPassword = document.getElementById('accountPassword');
            const accountRole = document.getElementById('accountRole');
            const accountValidate = document.getElementById('accountValidate');
            const validateSelect = document.getElementById('validateSelect');

            if (action === 'add') {
            formTitle.textContent = 'Add Account';
            formMethod.value = 'POST';
            accountForm.action = "{{ route('add_account') }}";
            accountName.value = '';
            accountEmail.value = '';
            accountPassword.required = true;
            accountPassword.value = '';
            accountRole.value = '';
            accountValidate.value = '0'; // Ensure the value is set to 0
            validateSelect.style.display = 'none';
            } else if (action === 'edit' && account) {
            formTitle.textContent = 'Edit Account';
            formMethod.value = 'PUT';
            accountForm.action = account ? "{{ route('edit_account', '') }}/" + account.id : "{{ route('add_account') }}";
            accountName.value = account.name;
            accountEmail.value = account.email;
            accountPassword.required = false;
            accountPassword.value = '';
            accountRole.value = account.role;
            accountValidate.value = account.customer_validate ? '1' : '0';
            validateSelect.style.display = account.role === 'customer' ? 'block' : 'none';
            } else if (action === 'close') {
            form.classList.add('hidden');
            return;
            }

            form.classList.toggle('hidden');
            }

            function toggleValidateSelect() {
            const accountRole = document.getElementById('accountRole');
            const validateSelect = document.getElementById('validateSelect');
            validateSelect.style.display = accountRole.value === 'customer' ? 'block' : 'none';
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
