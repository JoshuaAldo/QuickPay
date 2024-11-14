<div class="receipt-container bg-white p-4 rounded shadow-lg w-full text-gray-800 text-xs">
    <button class="text-gray-600 hover:text-gray-900 text-2xl font-bold mb-4"
        onclick="closeReceiptModal()">&times;</button>
    <div class="text-center font-bold text-xl">{{ $store_name }}</div>
    <div class="text-sm my-2">
        <div>Tanggal: {{ $order_date }}</div>
        <div>Nomer Order: {{ $order_number }}</div>
        <div>Nama Customer: {{ $customer_name }}</div>
    </div>
    <table class="w-full text-sm mt-4">
        <thead>
            <tr class="border-b">
                <th class="text-left py-1">Nama Makanan</th>
                <th class="text-center py-1">Jumlah</th>
                <th class="text-right py-1">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="py-1">{{ $item['name'] }}</td>
                    <td class="text-center py-1">{{ $item['quantity'] }}</td>
                    <td class="text-right py-1">{{ number_format($item['item_total'], 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <div class="flex justify-between">
            <span>Total:</span>
            <span>{{ number_format($total, 0) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Diskon:</span>
            <span>-{{ $discount }}</span>
        </div>
        <div class="flex justify-between">
            <span>Dibayar:</span>
            <span>{{ number_format($Payment_Amount, 0) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Kembali:</span>
            <span>{{ number_format($change, 0) }}</span>
        </div>
    </div>
    <div class="text-center font-bold mt-4">
        Terima kasih telah Membeli di {{ $store_name }}!
    </div>
</div>
