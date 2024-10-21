function openEditModal(productId) {
    fetch(`/product/${productId}/edit`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Mengisi form dengan data produk yang didapat
            document.getElementById('editProductname').value = data.product.product_name;
            document.getElementById('edit_base_price').value = data.product.base_price;
            document.getElementById('edit_sell_price').value = data.product.sell_price;
            document.getElementById('edit_stock').value = data.product.stock;
            document.getElementById('edit_category_id').value = data.product.category_id;

            // Update action URL untuk form
            document.getElementById('editForm').action = `/product/${productId}`;

            // Menampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching product:', error));
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openModal() {
    const modal = document.getElementById('addProductModal');
    modal.classList.remove('hidden');
    modal.classList.add('opacity-100');
}

function closeModal() {
    const modal = document.getElementById('addProductModal');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('opacity-100');
    }, 0); // Waktu yang sama dengan durasi transisi 
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