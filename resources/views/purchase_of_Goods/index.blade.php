<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <h1 class="text-2xl font-bold">Purchase of Goods</h1>
    @if (session('success'))
        <div id="successMessage" class="bg-green-500 text-white p-4 rounded-lg mb-4 relative">
            <span class="absolute top-1 right-2 cursor-pointer" id="closeMessage">&times;</span>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex justify-end mb-4">
        <form method="GET" action="{{ url('purchase-of-goods') }}">
            <div class="flex justify-end mb-4 space-x-4">
                <!-- Start Date -->
                <div class="flex flex-col">
                    <label for="start_date" class="mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request()->start_date }}" required
                        class="border p-2 rounded-lg">
                </div>

                <!-- End Date -->
                <div class="flex flex-col">
                    <label for="end_date" class="mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request()->end_date }}" required
                        class="border p-2 rounded-lg">
                </div>

                <!-- Filter Button -->
                <div class="flex justify-end mb-4 h-10 m-7">
                    <button type="submit"
                        class="w-20 bg-PinkTua text-white rounded-2xl p-2 mr-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Filter</button>
                    <!-- Reset Button -->
                    <a href="{{ route('purchase-of-goods.index') }}">
                        <button type="button"
                            class="w-20 bg-PinkTua text-white rounded-2xl p-2 mr-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Reset</button>
                    </a>
                </div>
            </div>
        </form>
        <div class="flex justify-end mb-4 h-10 m-7">
            <a href="{{ route('export.purchase') }}"
                class="bg-PinkTua text-white rounded-2xl p-2 mr-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Export
                to Excel</a>
            <button type="button"
                class="bg-PinkTua text-white px-4 py-2 rounded-2xl hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                onclick="openModal()">
                Add Product
            </button>
        </div>
    </div>

    <!-- Products Table -->
    <div class="flex flex-col h-dekstop ipad-pro-11:h-ipad overflow-y-auto overflow-x-auto">
        <table class="min-w-full max-w-full bg-white border-gray-200">
            <thead class="rounded-lg">
                <tr class="bg-PinkMuda2 text-gray-600 text-left text-sm">
                    <th class="py-2 px-4">Item Name</th>
                    <th class="py-2 px-4">Quantity</th>
                    <th class="py-2 px-4">Transaction Date</th>
                    <th class="py-2 px-4">Payment Method</th>
                    <th class="py-2 px-4">Item Category</th>
                    <th class="py-2 px-4">Price per Item</th>
                    <th class="py-2 px-4">Total Price</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-left">
                @foreach ($purchases as $purchase)
                    <tr class="border-b-2">
                        <td class="py-2 px-4">{{ $purchase->item_name }}</td>
                        <td class="py-2 px-4">{{ $purchase->quantity }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($purchase->transaction_date)->format('Y-m-d') }}
                        <td class="py-2 px-4">{{ $purchase->payment_method }}</td>
                        <td class="py-2 px-4">{{ $purchase->item_category }}</td>
                        <td class="py-2 px-4">{{ $purchase->price }}</td>
                        <td class="py-2 px-4">{{ $purchase->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Product Modal -->
    <div id="addPurchaseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add New Purchase</h3>
                <button class="text-gray-600 hover:text-gray-900 text-xl font-bold"
                    onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('purchase-of-goods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="item_name" class="block text-sm font-medium text-gray-700">Item
                        Name</label>
                    <input type="text"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-pink-200 p-2"
                        id="item_name" name="item_name" required>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-pink-200 p-2"
                        id="quantity" name="quantity" required>
                </div>
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select
                        class="w-full h-10 mt-1 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-pink-200 p-2"
                        id="payment_method" name="payment_method">
                        <option value="Cash">Cash</option>
                        <option value="QR">QR</option>
                        <option value="Debit">Debit</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Cash & QR">Cash & QR</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="item_category" class="block text-sm font-medium text-gray-700">Item Category</label>
                    <input type="text" step="0.01"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-pink-200 p-2"
                        id="item_category" name="item_category" required>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-pink-200 p-2"
                        id="price" name="price" required>
                </div>

                <!-- Tidak ada gambar produk yang ditampilkan dalam form Add Product -->
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-PinkTua rounded-3xl w-full text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Save
                        Item</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/Purchases.js') }}"></script>
</x-layout>
