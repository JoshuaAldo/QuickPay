<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <div class="container mx-auto mt-6 font-zenMaruGothic">
        <p>Order ID: {{ $draftId }}</p>
        <h1 class="text-2xl font-bold mb-4">Order Products</h1>
        @if (session('success'))
            <!-- Modal untuk menampilkan status transaksi -->
            <div id="paymentStatusModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-lg w-[500px] max-w-3xl overflow-y-auto my-8">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">Transaction Complete</h3>
                            <button class="text-gray-600 hover:text-gray-900 text-xl font-bold"
                                onclick="closePaymentStatusModal()">&times;</button>
                        </div>

                        <div class="bg-green/10 mr-5 flex h-[150px] w-full items-center justify-center rounded-md mb-2">
                            <svg width="150" height="150" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_961_15629)">
                                    <path
                                        d="M8.99998 0.506256C4.3031 0.506256 0.506226 4.30313 0.506226 9.00001C0.506226 13.6969 4.3031 17.5219 8.99998 17.5219C13.6969 17.5219 17.5219 13.6969 17.5219 9.00001C17.5219 4.30313 13.6969 0.506256 8.99998 0.506256ZM8.99998 16.2563C5.00623 16.2563 1.77185 12.9938 1.77185 9.00001C1.77185 5.00626 5.00623 1.77188 8.99998 1.77188C12.9937 1.77188 16.2562 5.03438 16.2562 9.02813C16.2562 12.9938 12.9937 16.2563 8.99998 16.2563Z"
                                        fill="#22AD5C" />
                                    <path
                                        d="M11.4187 6.38438L8.07183 9.64688L6.55308 8.15626C6.29996 7.90313 5.90621 7.93126 5.65308 8.15626C5.39996 8.40938 5.42808 8.80313 5.65308 9.05626L7.45308 10.8C7.62183 10.9688 7.84683 11.0531 8.07183 11.0531C8.29683 11.0531 8.52183 10.9688 8.69058 10.8L12.3187 7.31251C12.5718 7.05938 12.5718 6.66563 12.3187 6.41251C12.0656 6.15938 11.6718 6.15938 11.4187 6.38438Z"
                                        fill="#22AD5C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_961_15629">
                                        <rect width="18" height="18" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>

                        <!-- Info section for change -->
                        <div class="flex justify-between items-center bg-pink-200 p-2 rounded-md mb-10">
                            <span class="text-gray-700 font-medium">Change:</span>
                            <span class="text-gray-700 font-semibold">Rp{{ session('change') }}</span>
                        </div>

                        <form id="printReceiptForm" method="POST" action="{{ route('print.receipt') }}">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ session('orderId') }}">
                            <button type="submit"
                                class="w-full bg-PinkTua text-white py-2 rounded-md mb-2 font-semibold hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">
                                Print Receipt
                            </button>
                        </form>

                        <!-- Tombol untuk melihat preview struk -->
                        <button type="button" id="seeReceiptBtn"
                            onclick="openReceiptPreview('{{ session('orderId') }}')"
                            class="w-full bg-gray-500 text-white py-2 rounded-md mb-2 font-semibold hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">See
                            Receipt</button>

                        <!-- Modal -->
                        <div id="receiptModal"
                            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center z-50">
                            <div id="modalContent" class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg p-4 ">
                                <!-- Konten struk akan dimuat di sini -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        <div class="flex justify-end mb-4">
            <button type="button"
                class="bg-PinkTua w-36 text-white px-4 py-2 rounded-2xl hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
                onclick="openCartModal()">
                Cart
            </button>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 dekstopScreen:h-dekstopOrder ipad-pro-11:h-ipadOrder overflow-y-auto overflow-x-auto">
            @foreach ($products as $product)
                <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col dekstopScreen:h-52 ipad-pro-11:h-30">
                    <div class="flex">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                            class="dekstopScreen:w-32 dekstopScreen:h-32 object-cover rounded-md ipad-pro-11:w-20 ipad-pro-11:h-16">
                        <div class="ml-4 flex-grow">
                            <h2 class="dekstopScreen:text-xl font-semibold mt-2 ipad-pro-11:text-sm">
                                {{ $product->product_name }}</h2>
                            <p class="text-gray-600 dekstopScreen:text-xl ipad-pro-11:text-ipad-font">Price:
                                Rp{{ number_format($product->sell_price, 0, ',', '.') }}</p>
                            <p class="text-gray-600 dekstopScreen:text-xl ipad-pro-11:text-ipad-font">Stock:
                                {{ $product->stock }}</p>
                        </div>
                    </div>

                    <!-- Memindahkan input dan tombol ke bawah -->
                    <div class="mt-4 flex items-center justify-end">
                        <button
                            class="bg-white border dekstopScreen:text-lg ipad-pro-11:text-ipad-font-input dekstopScreen:w-8 dekstopScreen:h-8 ipad-pro-11:w-4 ipad-pro-11:h-4 text-gray-700 rounded-l-md px-2 hover:bg-PinkSelect transition duration-200"
                            onclick="decrementQuantity({{ $product->id }})">-</button>

                        <!-- Mengecek apakah ada quantity dari draftOrder untuk produk ini -->
                        <input type="number" min="0" max="{{ $product->stock }}"
                            value="{{ isset($productQuantities[$product->product_name]) ? $productQuantities[$product->product_name] : 0 }}"
                            class="dekstopScreen:text-lg ipad-pro-11:text-ipad-font-input dekstopScreen:w-8 dekstopScreen:h-8 ipad-pro-11:w-4 ipad-pro-11:h-4 border text-center focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none draftData"
                            id="quantity_{{ $product->id }}" data-product-id="{{ $product->id }}"
                            data-product-name="{{ $product->product_name }}"
                            data-product-image="{{ asset('storage/' . $product->image) }}"
                            data-product-price="{{ $product->sell_price }}"
                            data-product-description="{{ isset($productDescription[$product->product_name]) ? $productDescription[$product->product_name] : '' }}">

                        <button
                            class="bg-white border dekstopScreen:text-lg ipad-pro-11:text-ipad-font-input dekstopScreen:w-8 dekstopScreen:h-8 ipad-pro-11:w-4 ipad-pro-11:h-4 text-gray-700 rounded-r-md hover:bg-PinkSelect transition duration-200"
                            onclick="incrementQuantity({{ $product->id }})">+</button>
                    </div>
                </div>
                <script>
                    document.querySelectorAll('input[type="number"]').forEach(input => {
                        input.addEventListener('input', function() {
                            const productId = input.dataset.productId;
                            validateQuantityInput(productId);
                        });
                    });
                </script>
            @endforeach
        </div>

        <!-- Modal -->
        <div id="cartModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div
                class="bg-white rounded-lg shadow-lg w-full max-w-3xl dekstopScreen:max-h-dekstop-order-max ipad-pro-11:max-h-ipad-order-max overflow-y-auto my-8">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold mb-4">Cart Details</h2>
                        <button class="text-gray-600 hover:text-gray-900 text-2xl font-bold mb-4"
                            onclick="closeCartModal()">&times;</button>
                    </div>

                    <div id="cartItems" class="mt-4">
                        <!-- Cart items will be injected here -->
                    </div>
                    <div class="p-4 flex flex-col">
                        <label for="customerName" class="mt-4">Customer Name:</label>
                        <input type="text" id="customerName" placeholder="Enter your name"
                            class="border border-gray-300 rounded-lg p-2 mt-1 focus:outline-none"
                            value="{{ $custName }}" required>
                        <div id="toast" class=" mt-4 hidden bg-red-500 text-white p-2 rounded-lg shadow-lg">
                            <span id="toastMessage"></span>
                        </div>
                        <div class="flex justify-between mt-4">
                            <form id="saveToDraftForm" method="POST" action="{{ route('draftOrder.store') }}"
                                style="display: none;">
                                @csrf
                                <input type="text" id="hiddenCustomerName2" name="customer_name" value="">
                                <input type="hidden" id="hiddenCartItems" name="cart_items" value="">
                            </form>
                            <button type="button"
                                class="bg-orange-500 text-white hover:bg-orange-900 focus:outline-none transition duration-200 transform hover:scale-95 rounded-lg px-4 py-2"
                                onclick="saveToDraft()">Save to Draft</button>
                            <button
                                class="bg-PinkTua text-white hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95 rounded-lg px-4 py-2"
                                onclick="showPaymentModal()">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Payment Modal -->
        <div id="paymentModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div
                class="bg-white rounded-lg shadow-lg dekstopScreen:w-[1080px] dekstopScreen:max-w-3xl dekstopScreen:h-3/4 ipad-pro-11:max-w-3xl ipad-pro-11:h-5/6  overflow-x-auto my-8">

                <div class="flex justify-between items-center p-6 border-b">
                    <button class="text-gray-600 hover:text-gray-900 text-sm font-bold mb-4"
                        onclick="backToCartModal()">
                        <span class="text-2xl">&lt;</span>
                    </button>
                    <h2 class="text-lg font-bold">Payment Summary</h2>
                    <button class="text-gray-600 hover:text-gray-900 text-2xl font-bold"
                        onclick="closePaymentModal()">&times;</button>
                </div>


                <form id="orderForm" method="POST" action="{{ route('order.store') }}"
                    onsubmit="populateHiddenInputs()">
                    @csrf
                    <div class="p-6 flex-grow overflow-y-auto"> <!-- Make the content area scrollable -->
                        <div class="mb-4">
                            <p>Customer Name: <span id="paymentCustomerName"></span></p>
                            <p>Date: <span id="paymentDate"></span></p>
                            <p>Order Number: <span id="orderNumber"></span></p>
                        </div>

                        <!-- Transaction Details -->
                        <div class="bg-gray-100 p-4 rounded-md mb-4 max-h-48 overflow-auto">
                            <!-- Set maximum height and enable scrolling -->
                            <h3 class="font-bold mb-2">Transaction Details</h3>
                            <div id="transactionDetails"></div>
                        </div>
                        <p class="font-semibold mt-2 bg-gray-100 p-4 rounded-md mb-4 overflow-auto">Total: Rp<span
                                id="transactionTotal">0</span></p>
                        <!-- Hidden inputs untuk menyimpan nilai dari span -->
                        <input type="hidden" id="hiddenCustomerName" name="customer_name">
                        <input type="hidden" id="hiddenDate" name="order_date">
                        <input type="hidden" id="hiddenOrderNumber" name="order_number">
                        <input type="hidden" id="hiddenTransactionDetails" name="transaction_details">

                        <!-- Payment Method and Amount -->
                        <div class="flex">
                            <div class="w-1/2 pr-4">
                                <label for="paymentMethod" class="block font-bold mb-2">Payment Method</label>
                                <select id="paymentMethod" name="payment_method" class="border rounded-lg p-2 w-full"
                                    onchange="updatePaymentInputs()">
                                    <option value="Cash">Cash</option>
                                    <option value="QR">QR</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Cash & QR">Cash & QR</option>
                                </select>

                                <label for="settlementStatus" class="block font-bold mb-2 mt-2">Settlement
                                    Status</label>
                                <select id="settlementStatus" name="settlement_status"
                                    class="border rounded-lg p-2 w-full">
                                    <option value="Pending">Pending</option>
                                    <option value="Settled">Settled</option>
                                </select>

                                <label for="paymentReff" class="block font-bold mb-2 mt-2">Payment Reference</label>
                                <input type="text" id="paymentReff" name="payment_reference"
                                    placeholder="Reff ID"
                                    class="border border-gray-300 rounded-lg p-2 mt-1 focus:outline-none w-full">

                            </div>
                            <div class="w-1/2 mb-4">
                                <label for="paymentAmount" class="block font-bold mb-2">Payment Amount</label>
                                <input id="paymentAmount" name="payment_amount" type="number"
                                    class="border rounded-lg p-2 w-full text-right  [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    placeholder="0" min="0" required>

                                <div id="cashInputContainer" class="hidden mt-4">
                                    <label for="cashAmount" class="block font-bold mb-2">Cash Amount</label>
                                    <input id="cashAmount" name="cash_amount" type="number"
                                        class="border rounded-lg p-2 w-full text-right  [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        placeholder="Enter Cash Amount" oninput="updatePaymentAmount()">
                                </div>

                                <div id="qrInputContainer" class="hidden mt-4">
                                    <label for="qrAmount" class="block font-bold mb-2">QR Amount</label>
                                    <input id="qrAmount" name="qr_amount" type="number"
                                        class="border rounded-lg p-2 w-full text-right  [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        placeholder="Enter QR Amount" oninput="updatePaymentAmount()">
                                </div>

                                <!-- Quick Amount Buttons -->
                                <div class="flex space-x-2 mt-2 overflow-y-auto max-h-20" id="numberInput">
                                    <button type="button" onclick="addAmount(5000)"
                                        class="bg-gray-200 rounded-lg p-2">Rp5000</button>
                                    <button type="button" onclick="addAmount(10000)"
                                        class="bg-gray-200 rounded-lg p-2">Rp10000</button>
                                    <button type="button" onclick="addAmount(20000)"
                                        class="bg-gray-200 rounded-lg p-2">Rp20000</button>
                                    <button type="button" onclick="addAmount(50000)"
                                        class="bg-gray-200 rounded-lg p-2">Rp50000</button>
                                    <button type="button" onclick="addAmount(100000)"
                                        class="bg-gray-200 rounded-lg p-2">Rp100000</button>
                                </div>

                                <!-- Numeric Layout for Custom Amount -->
                                <div class="grid grid-cols-3 gap-2 mt-2" id="numberInput2">
                                    <button type="button" onclick="appendAmount('1')"
                                        class="bg-gray-100 p-2">1</button>
                                    <button type="button" onclick="appendAmount('2')"
                                        class="bg-gray-100 p-2">2</button>
                                    <button type="button" onclick="appendAmount('3')"
                                        class="bg-gray-100 p-2">3</button>
                                    <button type="button" onclick="appendAmount('4')"
                                        class="bg-gray-100 p-2">4</button>
                                    <button type="button" onclick="appendAmount('5')"
                                        class="bg-gray-100 p-2">5</button>
                                    <button type="button" onclick="appendAmount('6')"
                                        class="bg-gray-100 p-2">6</button>
                                    <button type="button" onclick="appendAmount('7')"
                                        class="bg-gray-100 p-2">7</button>
                                    <button type="button" onclick="appendAmount('8')"
                                        class="bg-gray-100 p-2">8</button>
                                    <button type="button" onclick="appendAmount('9')"
                                        class="bg-gray-100 p-2">9</button>
                                    <button type="button" onclick="clearAmount()" class="bg-red-200 p-2">C</button>
                                    <button type="button" onclick="appendAmount('0')"
                                        class="bg-gray-100 p-2">0</button>
                                    <!-- Backspace Button -->
                                    <button type="button" onclick="backspaceAmount()"
                                        class="bg-gray-100 p-2">&larr;</button>

                                </div>
                                <input type="hidden" name="draftId" value="{{ $draftId }}">
                                <button type="submit"
                                    class="bg-PinkTua text-white rounded-lg p-2 col-span-3 mt-4 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95 w-full">Confirm
                                    Order</button>
                </form>
            </div>
        </div>

        <script src="{{ asset('js/Order.js') }}"></script>
</x-layout>
