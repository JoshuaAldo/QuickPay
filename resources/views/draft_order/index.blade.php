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
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 dekstopScreen:h-dekstopOrder ipad-pro-11:h-ipadOrder overflow-y-auto overflow-x-auto">
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
                            {{-- <button class="bg-PinkTua text-white px-4 py-2 rounded-lg">
                                Pay
                            </button> --}}

                            <form action="{{ route('order.redirectToOrder', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-PinkTua text-white px-4 py-2 rounded-lg">Pay</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

</x-layout>
