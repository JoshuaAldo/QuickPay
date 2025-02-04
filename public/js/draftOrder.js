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

function openDeleteDraftOrderModal(draftOrderId) {
    // Atur action form delete dengan URL yang sesuai
    document.getElementById('deleteDraftOrderForm').action = `/draftOrder/${draftOrderId}`;
    // Tampilkan modal
    document.getElementById('deleteDraftOrderModal').classList.remove('hidden');
}

function closeDeleteDraftOrderModal() {
    document.getElementById('deleteDraftOrderModal').classList.add('hidden');
}

let productDescriptions = {}; 

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

function syncModalQuantitiesToOrderPage() {
  document.querySelectorAll('input.modal-quantity-input').forEach(modalInput => {
      const productId = modalInput.dataset.productId;
      const mainInput = document.getElementById(`quantity_${productId}`);
      mainInput.value = modalInput.value; // Perbarui nilai di halaman utama
  });
}

function openCartModal(items) {
  const cartItems = document.getElementById('cartItems');
  cartItems.innerHTML = ''; // Bersihkan item sebelumnya

  // Loop untuk setiap item dalam draft order
  items.forEach(item => {
      const { quantity, product_name: productName, product_price: productPrice, product_image: productImage, description } = item;

      const cartItem = document.createElement('div');
      cartItem.className = 'flex items-center justify-between p-2 border-b';
      cartItem.innerHTML = `
          <div class="flex">
              <img src="${productImage}" alt="${productName}" class="w-10 h-10 object-cover rounded-md">
              <div class="ml-4">
                  <h2 class="text-xl font-semibold">${productName}</h2>
                  <input type="text" class="border mt-2 p-1 w-full focus:outline-none rounded-md" 
                         placeholder="Description" 
                         value="${description || ''}" 
                         readonly>
              </div>
          </div>
          <div class="flex flex-col items-end">
              <span class="text-gray-600 mt-1">Rp${parseInt(productPrice).toLocaleString()}</span>
              <span class="text-gray-500">Quantity: ${quantity}</span>
          </div>
      `;
      cartItems.appendChild(cartItem);
  });

  document.getElementById('cartModal').classList.remove('hidden'); // Tampilkan modal
}


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
                      <!-- Input untuk Description -->
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

async function loadDraftOrderData(draftOrderId) {
  try {
      // Ambil data draft order dari endpoint
      const response = await fetch(`/draftOrder/${draftOrderId}`);
      const draftOrder = await response.json();

      if (draftOrder && draftOrder.items.length > 0) {
          openCartModal(draftOrder.items); // Panggil openCartModal dengan data item
      } else {
          showToast("Draft order kosong atau tidak ditemukan.");
      }
  } catch (error) {
      console.error("Error loading draft order:", error);
  }
}

function updateProductDescription(event, productId) {
  const description = event.target.value;
  productDescriptions[productId] = description; // Menyimpan deskripsi dalam objek
}

function incrementModalQuantity(productId) {
  const quantityInput = document.getElementById(`modal_quantity_${productId}`);
  let currentQuantity = parseInt(quantityInput.value);
  quantityInput.value = currentQuantity + 1;
}

function decrementModalQuantity(productId) {
  const quantityInput = document.getElementById(`modal_quantity_${productId}`);
  let currentQuantity = parseInt(quantityInput.value);
  if (currentQuantity > 1) {
      quantityInput.value = currentQuantity - 1;
  }
}

// Menutup modal
function closeCartModal() {
  document.getElementById('cartModal').classList.add('hidden');
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

  // Loop through cart items in draft order and populate modal
  document.querySelectorAll('#cartItems > div').forEach(item => {
      const productName = item.querySelector('h2').textContent;
      const quantity = item.querySelector('.modal-quantity-input').value;
      const price = item.querySelector('.text-gray-600').textContent.replace('Rp', '').replace(',', '');
      const description = item.querySelector('input[type="text"]').value;

      const itemTotal = quantity * parseFloat(price);
      totalAmount += itemTotal;
      hasItems = true;

      // Append item details to modal content
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

  // Open payment modal
  document.getElementById("cartModal").classList.add("hidden");
  document.getElementById("paymentModal").classList.remove("hidden");
}
