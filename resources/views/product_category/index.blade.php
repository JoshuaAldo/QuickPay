<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <div class="container mx-auto p-6 font-zenMaruGothic">
        <h2 class="text-2xl font-bold mb-4">Product Categories</h2>
        @if (session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-4 rounded-lg mb-4 relative">
                <span class="absolute top-1 right-2 cursor-pointer" id="closeMessage">&times;</span>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-500 text-white p-3">
                {{ session('error') }}
            </div>
        @endif
        <!-- Button to Open the Modal -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('export.productsCategory') }}"
                class="bg-PinkTua text-white rounded-2xl p-2 mr-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Export
                to Excel</a>
            <button type="button"
                class="bg-PinkTua text-white px-4 py-2 rounded-2xl hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                onclick="toggleModal('addCategoryModal')">
                Add Category
            </button>
        </div>

        <!-- Category Table -->
        <div class="flex flex-col h-dekstop ipad-pro-11:h-ipad overflow-y-auto overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-PinkMuda2 text-gray-600 text-left text-sm">
                        <th class="py-3 px-6">Category Name</th>
                        <th class="py-3 px-6">Capital</th>
                        <th class="py-3 px-6 text-center">Total Stock</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-left">
                    @foreach ($categories as $category)
                        <tr class="border-b">
                            <td class="py-3 px-6">{{ $category->category_name }}</td>
                            <td class="py-3 px-6">Rp{{ number_format($category->capital, 0, ',', '.') }}</td>
                            <td class="py-3 px-6 text-center">{{ $category->total_stock }}</td>
                            <td class="py-3 px-6 text-center">

                                @if ($category->products_count > 0)
                                    <button
                                        class="bg-red-600 opacity-50 cursor-not-allowed rounded-3xl text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                                        onclick="openDeleteCategoryModal({{ $category->id }})" disabled>Delete</button>
                                @else
                                    <button
                                        class="bg-red-600 rounded-3xl text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                                        onclick="openDeleteCategoryModal({{ $category->id }})">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add Category Modal -->
        <div id="addCategoryModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Add New Category</h3>
                    <button class="text-gray-600 hover:text-gray-900"
                        onclick="toggleModal('addCategoryModal')">&times;</button>
                </div>
                <!-- Form to Add Category -->
                <form action="{{ route('product_category.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium text-gray-700 pb-1">Category
                            Name</label>
                        <input type="text"
                            class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none  p-2"
                            id="category_name" name="category_name" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-PinkTua rounded-3xl w-full text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Kategori -->
    <div id="deleteCategoryModal" class="hidden fixed z-10 inset-0 w-96 mx-auto overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-black opacity-30"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium" id="modal-title">Delete Product Category Confirmation</h3>
                    <p class="mt-2 text-red-500 pb-2">Do You confirm want delete this Product Category?</p>
                    <div class="mt-4">
                        <form id="deleteCategoryForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 rounded-xl text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Delete</button>
                            <button type="button"
                                class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-pink-900 hover:text-white focus:outline-none transition duration-200 transform hover:scale-95"
                                onclick="closeDeleteCategoryModal()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Toggle Script -->
    <script src="{{ asset('js/ProductCategory.js') }}"></script>
</x-layout>
