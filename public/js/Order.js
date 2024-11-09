
function incrementQuantity(productId) {
    const input = document.getElementById(`quantity_${productId}`);
    let currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);

    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
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

function decrementQuantity(productId) {
    const input = document.getElementById(`quantity_${productId}`);
    let currentValue = parseInt(input.value);

    if (currentValue > 0) {
        input.value = currentValue - 1;
    }
}
const productDescriptions = {}; 

function openCartModal() {
    const cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = ''; // Bersihkan item sebelumnya

    // Loop untuk semua produk dan ambil informasi
    document.querySelectorAll('input[type="number"]').forEach(input => {
        const quantity = input.value;
        const productId = input.dataset.productId;
        const productName = input.dataset.productName;
        const productPrice = input.dataset.productPrice;
        const productImage = input.dataset.productImage;

        if (quantity > 0) {
            const item = document.createElement('div');
            item.className = 'flex items-center justify-between p-2 border-b';
            item.innerHTML = `
                <div class="flex">
                    <img src="${productImage}" alt="${productName}" class="w-10 h-10 object-cover rounded-md">
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold">${productName}</h2>
                        <input type="text" class="border mt-2 p-1 w-full focus:outline-none rounded-md" 
                               placeholder="Description" 
                               value="${productDescriptions[productId] || ''}" 
                               data-product-description-id="${productId}" 
                               oninput="updateProductDescription(event, ${productId})">
                    </div>
                </div>
                <div class="flex flex-col items-end">
                    <div class="flex items-center mt-2">
                        <button class="bg-white border w-8 text-gray-700 rounded-l-md px-2 hover:bg-PinkSelect transition duration-200" onclick="decrementModalQuantity(${productId})">-</button>
                        <input type="number" min="1" max="${input.max}" value="${quantity}"
                               class="border text-center focus:outline-none modal-quantity-input w-12"
                               id="modal_quantity_${productId}" data-product-id="${productId}" disabled>
                        <button class="bg-white border w-8 text-gray-700 rounded-r-md px-2 hover:bg-PinkSelect transition duration-200" onclick="incrementModalQuantity(${productId})">+</button>
                    </div>
                    <span class="text-gray-600 mt-1">Rp${productPrice}</span>
                </div>
            `;
            cartItems.appendChild(item);
        }
    });

    document.getElementById('cartModal').classList.remove('hidden'); // Tampilkan modal
}


function saveToDraft() {
    const customerName = document.getElementById('customerName').value;
    const cartItems = [];

    // Mengambil data cart items
    document.querySelectorAll('.draftData').forEach(input => {
        const quantity = input.value;
        const productId = input.dataset.productId;
        const productName = input.dataset.productName;
        const productPrice = input.dataset.productPrice;
        const productImage = input.dataset.productImage;

        if (quantity > 0) {
            cartItems.push({
                productId,
                productName,
                productPrice,
                quantity,
                productImage,
                description: document.querySelector(`[data-product-description-id="${productId}"]`).value // Ambil deskripsi
            });
        }
    });

    // Pastikan ada customer name dan cart items
    if (!customerName || cartItems.length === 0) {
        alert('Please enter customer name and add items to the cart before saving.');
        return;
    }

    // Mengisi input tersembunyi dengan data
    document.getElementById('hiddenCustomerName2').value = customerName;
    document.getElementById('hiddenCartItems').value = JSON.stringify(cartItems);
    // Mengirimkan form untuk menyimpan ke draft
    document.getElementById('saveToDraftForm').submit();
}

function updateProductDescription(event, productId) {
    productDescriptions[productId] = event.target.value; // Simpan deskripsi saat diubah
}

function closeCartModal() {
    // Simpan deskripsi untuk setiap produk
    document.querySelectorAll('input[data-product-description-id]').forEach(input => {
        const productId = input.dataset.productId;
        const description = input.value; // Ambil nilai dari input teks
        productDescriptions[productId] = description; // Simpan deskripsi
    });
    syncModalQuantitiesToOrderPage();
    document.getElementById('cartModal').classList.add('hidden');
}

function incrementModalQuantity(productId) {
    const input = document.getElementById(`modal_quantity_${productId}`);
    let currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);

    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
}

function decrementModalQuantity(productId) {
    const input = document.getElementById(`modal_quantity_${productId}`);
    let currentValue = parseInt(input.value);

    if (currentValue > 0) {
        input.value = currentValue - 1;
    }
    if (currentValue == 1){
        input.value = currentValue;
    }
    
}

// Function to handle manual input and enforce max stock limit
function validateQuantityInput(productId) {
    const input = document.getElementById(`quantity_${productId}`);
    let currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);

    // If the input value exceeds the max stock, reset it to the max stock
    if (currentValue > maxValue) {
        input.value = maxValue;
    } else if (currentValue < 0 || isNaN(currentValue)) {
        // If input is less than 0 or invalid, reset it to 0
        input.value = 0;
    }
}

// Function to handle manual input and enforce max stock limit in modal
function validateModalQuantityInput(productId) {
    const input = document.getElementById(`modal_quantity_${productId}`);
    let currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);

    // If the input value exceeds the max stock, reset it to the max stock
    if (currentValue > maxValue) {
        input.value = maxValue;
    } else if (currentValue < 0 || isNaN(currentValue)) {
        // If input is less than 0 or invalid, reset it to 0
        input.value = 0;
    }
}

function syncModalQuantitiesToOrderPage() {
    document.querySelectorAll('input.modal-quantity-input').forEach(modalInput => {
        const productId = modalInput.dataset.productId;
        const mainInput = document.getElementById(`quantity_${productId}`);
        mainInput.value = modalInput.value; // Perbarui nilai di halaman utama
    });
}

function showToast(message) {
    const toast = document.getElementById("toast");
    const toastMessage = document.getElementById("toastMessage");

    // Set pesan toast
    toastMessage.textContent = message;
    toast.classList.remove("hidden");

    // Sembunyikan toast setelah beberapa detik
    setTimeout(() => {
        toast.classList.add("hidden");
    }, 3000); // Toast akan tampil selama 3 detik
}

function showPaymentModal() {
    const customerName = document.getElementById("customerName").value.trim();

    if (!customerName) {
        showToast("Fill the Customer Name");
        return;
    }

    let hasItems = false;
    let totalAmount = 0;
    const transactionDetails = document.getElementById("transactionDetails");
    transactionDetails.innerHTML = '';

    // Loop through cart items and display product name, quantity, price, and description in Payment Modal
    document.querySelectorAll('#cartItems > div').forEach(item => {
        const productName = item.querySelector('h2').textContent;
        const quantity = item.querySelector('.modal-quantity-input').value;
        const price = item.querySelector('.text-gray-600').textContent.replace('Rp', '').replace(',', '');
        const description = item.querySelector('input[type="text"]').value;

        const itemTotal = quantity * parseFloat(price);
        totalAmount += itemTotal;
        hasItems = true;

        // Update Payment Modal content with product name, quantity, price, and description
        transactionDetails.innerHTML += `
            <div class="transaction-item flex flex-col border-b py-2">
             <div class="flex justify-between">
                <span class="font-semibold product-name">${productName}</span>
                <span class="text-gray-500 quantity">x ${quantity}</span>
                <span class="item-total">Rp${itemTotal.toLocaleString()}</span>
            </div>
              <p class="text-gray-500 text-sm mt-1 description">${description}</p>
            </div>
        `;
    });

    if (!hasItems) {
        showToast("Choose at least 1 Menu");
        return;
    }

    document.getElementById("transactionTotal").textContent = totalAmount.toLocaleString();
    const currentDate = new Date();
    document.getElementById("paymentCustomerName").textContent = customerName;
    document.getElementById("paymentDate").textContent = currentDate.toLocaleString();
    document.getElementById("orderNumber").textContent = `ORD-${currentDate.getTime()}`;

    document.getElementById("cartModal").classList.add("hidden");
    document.getElementById("paymentModal").classList.remove("hidden");
}

function closePaymentModal() {
    document.getElementById("paymentModal").classList.add("hidden");
}

function closePaymentStatusModal() {
    document.getElementById("paymentStatusModal").classList.add("hidden");
}

function addAmount(amount) {
    const paymentAmount = document.getElementById("paymentAmount");
    if (paymentAmount) {
        // Hapus tanda koma dari nilai saat ini
        const currentAmount = parseInt(paymentAmount.value.replace(/,/g, "") || "0");
        const newAmount = currentAmount + amount;
        
        // Set nilai tanpa koma ke input dan tampilkan dengan koma menggunakan toLocaleString di elemen terpisah
        paymentAmount.value = newAmount; // Nilai asli untuk input
    } else {
        console.error("Input field with id 'paymentAmount' not found.");
    }
}

function appendAmount(digit) {
    const paymentAmount = document.getElementById("paymentAmount");
    const currentAmount = parseInt(paymentAmount.value.replace(/,/g, "") || "0");
    if (currentAmount == 0 && digit == 0) {
        return; // Jika input hanya berisi "0" dan user menambah 0, tidak ada perubahan
    }
    paymentAmount.value += digit;
}

function clearAmount() {
    document.getElementById("paymentAmount").value = "";
}

function backToCartModal(){
    closePaymentModal();
    openCartModal();
}

function backspaceAmount() {
    const paymentAmountInput = document.getElementById("paymentAmount");
    paymentAmountInput.value = paymentAmountInput.value.slice(0, -1);
}

function updatePaymentInputs() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    const paymentAmountContainer = document.getElementById('paymentAmount');
    const cashInputContainer = document.getElementById('cashInputContainer');
    const qrInputContainer = document.getElementById('qrInputContainer');
    const numberInputContainer = document.getElementById('numberInput');
    const numberInputContainer2 = document.getElementById('numberInput2');
    // Sembunyikan kedua input cash dan QR secara default
    cashInputContainer.classList.add('hidden');
    qrInputContainer.classList.add('hidden');

    // Tampilkan input sesuai dengan metode pembayaran yang dipilih
    if (paymentMethod == 'Cash & QR') {
        cashInputContainer.classList.remove('hidden');
        qrInputContainer.classList.remove('hidden');
        paymentAmountContainer.disabled = true;
        numberInputContainer.classList.add('hidden');
        numberInputContainer2.classList.add('hidden');
    } 
    else{
        paymentAmountContainer.disabled = false;
        numberInputContainer.classList.remove('hidden');
        numberInputContainer2.classList.remove('hidden');
    }
}

function updatePaymentAmount() {
    const cashAmount = parseFloat(document.getElementById('cashAmount').value) || 0;
    const qrAmount = parseFloat(document.getElementById('qrAmount').value) || 0;
    const totalAmount = cashAmount + qrAmount;

    // Update nilai pada input payment amount
    const paymentAmountInput = document.getElementById('paymentAmount');
    paymentAmountInput.value = totalAmount;
}

function populateHiddenInputs() {
    // Ambil nilai dari elemen <span> di modal
    document.getElementById('paymentAmount').disabled = false;
    const customerName = document.getElementById('paymentCustomerName').innerText;
    const orderDate = document.getElementById('paymentDate').innerText;
    const orderNumber = document.getElementById('orderNumber').innerText;
    
    // Array untuk menyimpan detail transaksi sebagai JSON
    let transactionDetails = [];

    // Ambil semua item transaksi dari elemen HTML
    document.querySelectorAll('#transactionDetails .transaction-item').forEach(item => {
        const productName = item.querySelector('.product-name').innerText;
        const quantity = parseInt(item.querySelector('.quantity').innerText.replace('x ', ''));
        const itemTotal = item.querySelector('.item-total').innerText.replace('Rp', '').replace(',', '');
        const description = item.querySelector('.description').innerText;

        // Push item transaksi sebagai objek JSON
        transactionDetails.push({
            productName,
            quantity,
            itemTotal: parseInt(itemTotal),
            description
        });
    });

    // Set nilai hidden input dengan JSON string
    document.getElementById('hiddenTransactionDetails').value = JSON.stringify(transactionDetails);
    document.getElementById('hiddenCustomerName').value = customerName;
    document.getElementById('hiddenDate').value = orderDate;
    document.getElementById('hiddenOrderNumber').value = orderNumber;
}

// Fungsi untuk menutup modal
function closePaymentStatusModal() {
    document.getElementById('paymentStatusModal').style.display = 'none';
}

function openReceiptPreview(orderId) {
    fetch(`/receipt-preview/${orderId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('receiptModal').classList.remove('hidden');
            document.getElementById('receiptModal').classList.add('flex');
        })
        .catch(error => console.error('Error:', error));
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
    document.getElementById('receiptModal').classList.remove('flex');
}

// function saveToDraft() {
//     const customerName = document.getElementById('customerName').value;
//     const cartItems = getCartItems(); // Fungsi ini harus mengembalikan array cart items dari modal

//     fetch('/save-draft', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({ customer_name: customerName, cart_items: cartItems })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.message) {
//             alert(data.message); // Atau tampilkan toast di UI
//         }
//     })
//     .catch(error => console.error('Error:', error));
// }