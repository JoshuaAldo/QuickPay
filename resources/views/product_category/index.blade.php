<x-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Product Categories</h2>

        <!-- Button to Open the Modal -->
        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none"
            onclick="toggleModal('addCategoryModal')">
            Add Category
        </button>

        <!-- Category Table -->
        <div class="overflow-x-auto mt-5">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-left text-sm">
                        <th class="py-3 px-6">Category Name</th>
                        <th class="py-3 px-6">Capital</th>
                        <th class="py-3 px-6">Total Stock</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($categories as $category)
                        <tr class="border-b">
                            <td class="py-3 px-6">{{ $category->category_name }}</td>
                            <td class="py-3 px-6">{{ $category->capital }}</td>
                            <td class="py-3 px-6">{{ $category->total_stock }}</td>
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
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                        <input type="text"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            id="category_name" name="category_name" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                            onclick="toggleModal('addCategoryModal')">Cancel</button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>
</x-layout>
