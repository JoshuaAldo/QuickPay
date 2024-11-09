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

            // Menampilkan gambar produk jika ada
            const productImageElement = document.getElementById('editProductImage');
            if (data.product.image) {
                productImageElement.src = `/storage/${data.product.image}`; // Pastikan path gambar benar
                productImageElement.style.display = 'block'; // Menampilkan gambar
            } else {
                productImageElement.style.display = 'none'; // Sembunyikan jika tidak ada gambar
            }

            // Update action URL untuk form
            document.getElementById('editForm').action = `/product/${productId}`;

            // Menampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching product:', error));
}

function previewImage(input) {
    const file = input.files[0];

    if (file) {
        console.log('File selected:', file.name); // Log nama file untuk debugging
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const productImageElement = document.getElementById('editProductImage');
            productImageElement.src = e.target.result; // Menampilkan pratinjau gambar baru yang dipilih
            productImageElement.style.display = 'block'; // Tampilkan gambar jika pengguna memilih file
        }
        
        reader.readAsDataURL(file); // Baca file gambar dan tampilkan pratinjau
    } else {
        console.log('No file selected'); // Log jika tidak ada file yang dipilih
    }
}

function previewAddImage(input) {
    const file = input.files[0];

    if (file) {
        console.log('File selected:', file.name); // Log nama file untuk debugging
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const productImageElement = document.getElementById('addProductImage');
            productImageElement.src = e.target.result; // Menampilkan pratinjau gambar baru yang dipilih
            productImageElement.style.display = 'block'; // Tampilkan gambar jika pengguna memilih file
        }
        
        reader.readAsDataURL(file); // Baca file gambar dan tampilkan pratinjau
    } else {
        console.log('No file selected'); // Log jika tidak ada file yang dipilih
    }
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

function openDeleteModal(productId) {
    // Atur action form delete dengan URL yang sesuai
    document.getElementById('deleteForm').action = `/product/${productId}`;
    // Tampilkan modal
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
