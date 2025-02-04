function openModal() {
  const modal = document.getElementById('addPurchaseModal');
  modal.classList.remove('hidden');
  modal.classList.add('opacity-100');
}

function closeModal() {
  const modal = document.getElementById('addPurchaseModal');
  setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('opacity-100');
  }, 0); // Waktu yang sama dengan durasi transisi 
}

function openDeletePurchaseModal(purchaseId) {
  // Atur action form delete dengan URL yang sesuai
  document.getElementById('deletePurchaseForm').action = `/purchase-of-goods/${purchaseId}`;
  // Tampilkan modal
  document.getElementById('deletePurchaseModal').classList.remove('hidden');
}

function closeDeletePurchaseModal() {
  document.getElementById('deletePurchaseModal').classList.add('hidden');
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