function openDeleteCategoryModal(categoryId) {
    // Atur action form delete dengan URL yang sesuai
    document.getElementById('deleteCategoryForm').action = `/product_category/${categoryId}`;
    // Tampilkan modal
    document.getElementById('deleteCategoryModal').classList.remove('hidden');
}

function closeDeleteCategoryModal() {
    document.getElementById('deleteCategoryModal').classList.add('hidden');
}

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
}