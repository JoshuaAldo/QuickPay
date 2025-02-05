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

document.addEventListener('DOMContentLoaded', (event) => {
    const successMessage = document.getElementById('successMessage');
    const closeMessageButton = document.getElementById('closeMessage');
  
    if (successMessage) {
        // Sembunyikan elemen setelah 5 detik (5000 milidetik)
        const timeoutId = setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
  
        // Jika tanda "X" diklik, sembunyikan pesan dan batalkan timeout
        if (closeMessageButton) {
            closeMessageButton.addEventListener('click', () => {
                clearTimeout(timeoutId); // Batalkan timeout
                successMessage.style.display = 'none'; // Sembunyikan pesan
            });
        }
    }
  });