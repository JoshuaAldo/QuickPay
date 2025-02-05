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
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Button to Open the Modal -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('export.productsCategory') }}"
                class="bg-blueRevamp w-24 lg:w-auto text-white text-center rounded-2xl p-2 mr-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Export
                to Excel</a>
            <button type="button"
                class="bg-blueRevamp w-24 lg:w-auto text-white text-center px-4 py-2 rounded-2xl hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95"
                onclick="toggleModal('addCategoryModal')">
                Add Category
            </button>
        </div>

        <!-- Category Table -->
        <div class="flex flex-col w-screen lg:w-full h-dekstop ipad-pro-11:h-ipad overflow-y-auto overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blueRevamp text-white text-left text-sm">
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
                                        class="bg-red-600 rounded-3xl px-4 py-2 opacity-50 focus:outline-none transition duration-200 cursor-not-allowed"
                                        onclick="openDeleteCategoryModal({{ $category->id }})" disabled><svg
                                            fill="#F5F5F5" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg"
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
                                        </svg></button>
                                @else
                                    <button
                                        class="bg-red-600 rounded-3xl text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                                        onclick="openDeleteCategoryModal({{ $category->id }})"><svg fill="#F5F5F5"
                                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
                                        </svg></button>
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
                            class="w-full h-8 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blueRevamp2  p-2"
                            id="category_name" name="category_name" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blueRevamp rounded-3xl w-full text-white px-4 py-2 hover:bg-blueRevamp3focus:outline-none transition duration-200 transform hover:scale-95">Save</button>
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
                                class="bg-red-600 rounded-xl text-white px-4 py-2 hover:bg-blueRevamp focus:outline-none transition duration-200 transform hover:scale-95">Delete</button>
                            <button type="button"
                                class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-blueRevamp hover:text-white focus:outline-none transition duration-200 transform hover:scale-95"
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
