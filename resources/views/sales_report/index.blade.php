<x-layout>
    <x-slot name="redirect">{{ $redirect }}</x-slot>
    <h1 class="text-2xl font-bold font-zenMaruGothic">Sales Report</h1>
    <div class="flex-wrap lg:flex justify-end mb-4 font-zenMaruGothic w-screen lg:w-full overflow-x-auto">
        <form method="GET" action="{{ url('sales-report') }}">
            <div class="flex justify-end space-x-4 ">
                <!-- Start Date -->
                <div class="flex flex-col">
                    <label for="start_date" class="mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request()->start_date }}" required
                        class="border p-2 rounded-lg">
                </div>

                <!-- End Date -->
                <div class="flex flex-col">
                    <label for="end_date" class="mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request()->end_date }}" required
                        class="border p-2 rounded-lg">
                </div>

                <!-- Filter Button -->
                <div class="flex justify-end h-10 m-7">
                    <button type="submit"
                        class="w-20 bg-blueRevamp text-white rounded-2xl p-2 mr-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Filter</button>
                    <!-- Reset Button -->
                    <a href="{{ route('sales-report.index') }}">
                        <button type="button"
                            class="w-20 bg-blueRevamp text-white rounded-2xl p-2 mr-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95">Reset</button>
                    </a>
                </div>
            </div>
        </form>
        <div class="flex justify-end h-10 lg:m-7">
            <a href="{{ route('export.orders') }}"
                class="bg-blueRevamp text-white rounded-2xl p-2 mr-2 hover:bg-blueRevamp focus:outline-none transition duration-200 transform hover:scale-95">Export
                to Excel</a>
        </div>
    </div>

    <!-- Products Table -->
    <div
        class="flex flex-col w-screen lg:w-full h-dekstop ipad-pro-11:h-ipad overflow-y-auto overflow-x-auto font-zenMaruGothic">
        <table class="min-w-full max-w-full bg-white border-gray-200">
            <thead class="rounded-lg">
                <tr class="bg-blueRevamp text-white text-left text-sm">
                    <th class="py-2 px-4">Transaction ID</th>
                    <th class="py-2 px-4">Customer Name</th>
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
                        <td class="py-2 px-4">{{ $order->customer_name }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}
                        </td>
                        <td class="py-2 px-4">{{ $order->payment_method }}</td>
                        <td class="py-2 px-4">Rp{{ number_format($order->total_item_value, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <button type="button" id="seeReceiptBtn"
                                    onclick="openReceiptPreview('{{ $order->id }}', '{{ $order->discount }}')"
                                    class="bg-blueRevamp text-white rounded-3xl p-2 mr-2 hover:bg-blueRevamp3 focus:outline-none transition duration-200 transform hover:scale-95 w-40">See
                                    Receipt
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="receiptModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center z-50">
        <div id="modalContent" class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg p-4 ">
            <!-- Konten struk akan dimuat di sini -->
        </div>
    </div>

    <script src="{{ asset('js/Order.js') }}"></script>
</x-layout>
