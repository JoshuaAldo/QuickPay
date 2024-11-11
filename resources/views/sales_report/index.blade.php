<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <h1 class="text-2xl font-bold">Sales Report</h1>
    <div class="flex justify-end mb-4">
        <a href="{{ route('export.products') }}"
            class="bg-PinkTua text-white rounded-2xl p-2 mr-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95">Export
            to Excel</a>
        <button type="button"
            class="bg-PinkTua text-white px-4 py-2 rounded-2xl hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95"
            onclick="openModal()">
            Add Product
        </button>
    </div>

    <!-- Products Table -->
    <div class="flex flex-col h-dekstop ipad-pro-11:h-ipad overflow-y-auto overflow-x-auto">
        <table class="min-w-full max-w-full bg-white border-gray-200">
            <thead class="rounded-lg">
                <tr class="bg-PinkMuda2 text-gray-600 text-left text-sm">
                    <th class="py-2 px-4">Transaction ID</th>
                    <th class="py-2 px-4">Transaction Date</th>
                    <th class="py-2 px-4">Payment Method</th>
                    <th class="py-2 px-4">Total Transaction</th>
                    <th class="py-2 px-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-left">
                @foreach ($ordersWithTotals as $order)
                    <tr class="border-b-2">
                        <td class="py-2 px-4">{{ $order->order_number }}</td>
                        <td class="py-2 px-4">{{ $order->order_date }}</td>
                        <td class="py-2 px-4">{{ $order->payment_method }}</td>
                        <td class="py-2 px-4">{{ $order->total_item_value }}</td>
                        <td class="py-2 px-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <button
                                    class="bg-PinkTua rounded-3xl w-full text-white px-4 py-2 hover:bg-pink-900 focus:outline-none transition duration-200 transform hover:scale-95 mr-4"
                                    onclick="openEditModal({{ $order->id }})">Receipt</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
