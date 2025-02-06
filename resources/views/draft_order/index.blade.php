<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6 font-zenMaruGothic">Draft Orders</h1>
        @if (session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-4 rounded-lg mb-4 relative">
                <span class="absolute top-1 right-2 cursor-pointer" id="closeMessage">&times;</span>
                {{ session('success') }}
            </div>
        @endif
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 h-dekstop w-screen lg:w-full overflow-y-auto overflow-x-auto">
            @foreach ($draftOrders as $order)
                <div class="bg-white shadow-md rounded-lg p-6 overflow-y-auto">
                    <h2 class="text-lg font-semibold text-gray-800">Customer Name: {{ $order->customer_name }}</h2>

                    <div class="mt-4">
                        <h3 class="text-md font-semibold text-gray-600">Transaction Details</h3>
                        <ul class="mt-2 space-y-2">
                            @foreach ($order->items as $item)
                                <li class="flex items-start border-b pb-2">
                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                        class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <h4 class="text-gray-700 font-medium">{{ $item->product_name }}</h4>
                                        <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                        <p class="text-gray-600">Price: Rp{{ number_format($item->product_price, 2) }}
                                        </p>
                                        <p class="text-gray-600">Description: {{ $item->description }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="flex justify-between mt-4">
                            <p class="text-gray-600 bg-yellow-200 p-2 rounded-md">PENDING</p>
                            <div class="flex justify-between mr-3">
                                <button
                                    class="bg-red-600 rounded-lg text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95 mr-4"
                                    onclick="openDeleteDraftOrderModal({{ $order->id }})"><svg fill="#F5F5F5"
                                        version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                        viewBox="0 0 408.483 408.483" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M87.748,388.784c0.461,11.01,9.521,19.699,20.539,19.699h191.911c11.018,0,20.078-8.689,20.539-19.699l13.705-289.316
                                                        H74.043L87.748,388.784z M247.655,171.329c0-4.61,3.738-8.349,8.35-8.349h13.355c4.609,0,8.35,3.738,8.35,8.349v165.293
                                                        c0,4.611-3.738,8.349-8.35,8.349h-13.355c-4.61,0-8.35-3.736-8.35-8.349V171.329z M189.216,171.329
                                                        c0-4.61,3.738-8.349,8.349-8.349h13.355c4.609,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.737,8.349-8.349,8.349h-13.355
                                                        c-4.61,0-8.349-3.736-8.349-8.349V171.329L189.216,171.329z M130.775,171.329c0-4.61,3.738-8.349,8.349-8.349h13.356
                                                        c4.61,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.738,8.349-8.349,8.349h-13.356c-4.61,0-8.349-3.736-8.349-8.349V171.329z" />
                                                <path
                                                    d="M343.567,21.043h-88.535V4.305c0-2.377-1.927-4.305-4.305-4.305h-92.971c-2.377,0-4.304,1.928-4.304,4.305v16.737H64.916
                                                        c-7.125,0-12.9,5.776-12.9,12.901V74.47h304.451V33.944C356.467,26.819,350.692,21.043,343.567,21.043z" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                                <form action="{{ route('order.redirectToOrder', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blueRevamp text-white px-4 py-2 rounded-lg hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Pay</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Konfirmasi Hapus Draft Order -->
        <div id="deleteDraftOrderModal" class="hidden fixed z-10 inset-0 w-96 mx-auto overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-black opacity-30"></div>
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-medium" id="modal-title">Delete Draft Order Confirmation</h3>
                        <p class="mt-2 text-red-500 pb-2">Do You confirm want delete this Draft Order?</p>
                        <div class="mt-4">
                            <form id="deleteDraftOrderForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 rounded-xl text-white px-4 py-2 hover:bg-blueRevamp focus:outline-none transition duration-200 transform hover:scale-95">Delete</button>
                                <button type="button"
                                    class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-blueRevamp hover:text-white focus:outline-none transition duration-200 transform hover:scale-95"
                                    onclick="closeDeleteDraftOrderModal()">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/draftOrder.js') }}"></script>
</x-layout>
