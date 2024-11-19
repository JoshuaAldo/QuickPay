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