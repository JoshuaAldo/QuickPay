<x-layout>
    <div class="container mx-auto p-6 font-zenMaruGothic">
        <h2 class="text-2xl font-bold mb-4">Products</h2>
        @if (session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-4 rounded-lg mb-4 relative">
                <span class="absolute top-1 right-2 cursor-pointer" id="closeMessage">&times;</span>
                {{ session('success') }}
            </div>
        @endif
        <!-- Button to Open the Modal -->
        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none"
            onclick="openModal()">
            Add Product
        </button>

        <!-- Products Table -->
        <div class="overflow-x-auto mt-5">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-left text-sm">
                        <th class="py-3 px-6">Product Name</th>
                        <th class="py-3 px-6">Base Price</th>
                        <th class="py-3 px-6">Sell Price</th>
                        <th class="py-3 px-6">Stock</th>
                        <th class="py-3 px-6">Category</th>
                        <th class="py-3 px-6">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($products as $product)
                        <tr class="border-b">
                            <td class="py-3 px-6">{{ $product->product_name }}</td>
                            <td class="py-3 px-6">{{ $product->base_price }}</td>
                            <td class="py-3 px-6">{{ $product->sell_price }}</td>
                            <td class="py-3 px-6">{{ $product->stock }}</td>
                            <td class="py-3 px-6">{{ $product->category->category_name ?? 'No Category' }}</td>
                            <td class="py-3 px-6">
                                <button class="bg-blue-500 text-white rounded px-4 py-2"
                                    onclick="openEditModal({{ $product->id }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add Product Modal -->
        <div id="addProductModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Add New Product</h3>
                    <button class="text-gray-600 hover:text-gray-900" onclick="closeModal()">&times;</button>
                </div>
                <!-- Form to Add Product -->
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-4">
                        <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price</label>
                        <input type="number" step="0.01"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="base_price" name="base_price" required>
                    </div>
                    <div class="mb-4">
                        <label for="sell_price" class="block text-sm font-medium text-gray-700">Sell Price</label>
                        <input type="number" step="0.01"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="sell_price" name="sell_price" required>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="stock" name="stock" required>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="category_id" name="category_id">
                            <option value="">No Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                            onclick="closeModal()">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save
                            Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
            <h2 class="text-xl font-semibold mb-4">Edit Product</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT') <!-- Ini digunakan untuk memberitahu Laravel bahwa ini adalah permintaan update -->

                <div class="mb-4">
                    <label for="editProductname" class="block text-sm font-medium">Product Name</label>
                    <input type="text" id="editProductname" name="product_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="edit_base_price" class="block text-sm font-medium">Base Price</label>
                    <input type="number" id="edit_base_price" name="base_price"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="edit_sell_price" class="block text-sm font-medium">Sell Price</label>
                    <input type="number" id="edit_sell_price" name="sell_price"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="edit_stock" class="block text-sm font-medium">Stock</label>
                    <input type="number" id="edit_stock" name="stock"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="edit_category_id" class="block text-sm font-medium">Category</label>
                    <select id="edit_category_id" name="category_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                        <option value="">Pilih kategori (opsional)</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Toggle Script -->
    <script src="{{ asset('js/Product.js') }}"></script>
</x-layout>
