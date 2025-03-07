<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <h1 class="text-2xl font-bold font-zenMaruGothic">Products</h1>
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
    <div class="flex justify-end mb-4 font-zenMaruGothic">
        <div class="flex justify-end mb-4">
            <a href="{{ route('export.products') }}"
                class="bg-blueRevamp w-24 lg:w-auto text-white text-center rounded-2xl p-2 mr-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Export
                to Excel</a>
            <button type="button"
                class="bg-blueRevamp w-24 lg:w-auto text-white text-center px-4 py-2 rounded-2xl hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95"
                onclick="openModal()">
                Add Product
            </button>
        </div>
    </div>

    <!-- Products Table -->
    <div class="flex flex-col w-screen lg:w-full h-dekstop overflow-y-auto overflow-x-auto">
        <table
            class="min-w-full max-w-full w-screen lg:w-full bg-white border-gray-200 overflow-y-auto overflow-x-auto">
            <thead class="rounded-lg">
                <tr class="bg-blueRevamp text-white text-left text-sm">
                    <th class="py-2 px-4">Product Image</th>
                    <th class="py-2 px-4">Product Name</th>
                    <th class="py-2 px-4">Base Price</th>
                    <th class="py-2 px-4">Sell Price</th>
                    <th class="py-2 px-4">Stock</th>
                    <th class="py-2 px-4">Category</th>
                    <th class="py-2 px-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-left">
                @foreach ($products as $product)
                    <tr class="border-b-2">
                        <td class="py-3 px-6">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                    style="max-width: 50px; max-height: 50px;">
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $product->product_name }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($product->base_price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($product->sell_price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4">{{ $product->stock }}</td>
                        <td class="py-2 px-4">{{ $product->category->category_name ?? 'No Category' }}</td>
                        <td class="py-2 px-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <button
                                    class="bg-blueRevamp rounded-3xl w-full text-white px-4 py-2 hover:blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95 mr-4"
                                    onclick="openEditModal({{ $product->id }})">Edit</button>
                                <button
                                    class="bg-red-600 rounded-3xl w-full flex justify-center items-center px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                                    onclick="openDeleteModal({{ $product->id }})">
                                    <svg fill="#F5F5F5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                        viewBox="0 0 408.483 408.483" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M87.748,388.784c0.461,11.01,9.521,19.699,20.539,19.699h191.911c11.018,0,20.078-8.689,20.539-19.699l13.705-289.316
                                                        H74.043L87.748,388.784z M247.655,171.329c0-4.61,3.738-8.349,8.35-8.349h13.355c4.609,0,8.35,3.738,8.35,8.349v165.293
                                                        c0,4.611-3.738,8.349-8.35,8.349h-13.355c-4.61,0-8.35-3.736-8.35-8.349V171.329z M189.216,171.329
                                                        c0-4.61,3.738-8.349,8.349-8.349h13.355c4.609,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.737,8.349-8.349,8.349h-13.355
                                                        c-4.61,0-8.349-3.736-8.349-8.349V171.329L189.216,171.329z M130.775,171.329c0-4.61,3.738-8.349,8.349-8.349h13.356
                                                        c4.61,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.738,8.349-8.349,8.349h-13.356c-4.61,0-8.349-3.736-8.349-8.349V171.329z" />
                                                <path
                                                    d="M343.567,21.043h-88.535V4.305c0-2.377-1.927-4.305-4.305-4.305h-92.971c-2.377,0-4.304,1.928-4.304,4.305v16.737H64.916
                                                        c-7.125,0-12.9,5.776-12.9,12.901V74.47h304.451V33.944C356.467,26.819,350.692,21.043,343.567,21.043z" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add New Product</h3>
                <button class="text-gray-600 hover:text-gray-900 text-xl font-bold"
                    onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product
                        Name</label>
                    <input type="text"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                        id="product_name" name="product_name" required>
                </div>
                <div class="mb-4">
                    <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price</label>
                    <input type="number" step="0.01"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                        id="base_price" name="base_price" required>
                </div>
                <div class="mb-4">
                    <label for="sell_price" class="block text-sm font-medium text-gray-700">Sell Price</label>
                    <input type="number" step="0.01"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                        id="sell_price" name="sell_price" required>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number"
                        class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:blueRevamp2 p-2"
                        id="stock" name="stock" required>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                        class="w-full h-10 mt-1 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:blueRevamp2 p-2"
                        id="category_id" name="category_id">
                        <option value="">No Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="addImage" class="block text-sm font-medium">Product Image</label>

                    <!-- Input untuk memilih gambar baru -->
                    <input type="file" name="image" id="addImage" class="hidden" accept="image/*"
                        onchange="previewAddImage(this)">

                    <label for="addImage"
                        class="cursor-pointer inline-block bg-blueRevamp rounded-xl text-white px-4 py-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">
                        Choose File
                    </label>

                    <!-- Tampilkan gambar saat ada, dinamis berdasarkan produk -->
                    <img id="addProductImage" src="" alt="Product Image" class="mt-2"
                        style="max-width: 150px; max-height: 150px; display: none;">
                </div>
                <!-- Tidak ada gambar produk yang ditampilkan dalam form Add Product -->
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-blueRevamp rounded-3xl w-full text-white px-4 py-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Save
                        Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold mb-4 text-center">Edit Product</h2>
                <button class="text-gray-600 hover:text-gray-900 text-xl font-bold"
                    onclick="closeEditModal()">&times;</button>
            </div>
            @if (isset($product))
                <form action="{{ route('product.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="editProductname" class="block text-sm font-medium">Product Name</label>
                        <input type="text" id="editProductname" name="product_name"
                            value="{{ old('product_name', $product->product_name) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_base_price" class="block text-sm font-medium">Base Price</label>
                        <input type="number" id="edit_base_price" name="base_price"
                            value="{{ old('base_price', $product->base_price) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_sell_price" class="block text-sm font-medium">Sell Price</label>
                        <input type="number" id="edit_sell_price" name="sell_price"
                            value="{{ old('sell_price', $product->sell_price) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_stock" class="block text-sm font-medium">Stock</label>
                        <input type="number" id="edit_stock" name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_category_id" class="block text-sm font-medium">Category</label>
                        <select id="edit_category_id" name="category_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2 p-2">
                            <option value="">Pilih kategori (opsional)</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="editImage" class="block text-sm font-medium">Product Image</label>

                        <!-- Input untuk memilih gambar baru -->
                        <input type="file" name="image" id="editImage" class="hidden" accept="image/*"
                            onchange="previewImage(this)">

                        <label for="editImage"
                            class="cursor-pointer inline-block bg-blueRevamp rounded-xl text-white px-4 py-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">
                            Choose File
                        </label>

                        <!-- Tampilkan gambar saat ada, dinamis berdasarkan produk -->
                        <img id="editProductImage" src="" alt="Product Image" class="mt-2"
                            style="max-width: 150px; max-height: 150px; display: none;">
                    </div>


                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blueRevamp rounded-3xl w-full text-white px-4 py-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Save
                            Changes</button>
                    </div>
                </form>
            @else
                <p class="text-red-500">Produk tidak ditemukan.</p>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed z-10 inset-0 w-96 mx-auto overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-black opacity-30"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium" id="modal-title">Delete Product Confirmation</h3>
                    <p class="mt-2 text-red-500 pb-2">Do You confirm want delete this Product?</p>
                    <div class="mt-4">
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class=" bg-red-600 rounded-xl text-white px-4 py-2 hover:bg-blueRevamp focus:outline-none transition duration-200 transform hover:scale-95">Delete</button>
                            <button type="button"
                                class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-blueRevamp hover:text-white focus:outline-none transition duration-200 transform hover:scale-95"
                                onclick="closeDeleteModal()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Toggle Script -->
    <script src="{{ asset('js/Product.js') }}"></script>
</x-layout>
