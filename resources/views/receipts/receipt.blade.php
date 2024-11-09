<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            width: 58mm;
            font-family: monospace;
            font-size: 12px;
            /* Sesuaikan ukuran font */
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            padding: 10px;
            /* Mengurangi padding untuk lebih banyak ruang */

        }

        .receipt-details {
            margin-bottom: 5px;
        }

        .store-name {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            text-align: center;
        }

        .items td {
            padding: 3px 0;
            margin-right: 4px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            /* Enable border-spacing */
            border-spacing: 10px;
            /* Space between cells */
        }

        .items {
            margin-bottom: 26px;
        }

        .header {
            text-align: left;
            margin-left: 8px;
        }

        .header-right {
            text-align: right;
        }

        .item-qty {
            text-align: center;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            font-weight: bold;
        }

        .total-container {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="store-name">{{ $store_name }}</div>
        <div class="receipt-details">
            <div>Tanggal: {{ $order_date }}</div>
            <div>Nomer Order: {{ $order_number }}</div>
            <div>Nama Customer: {{ $customer_name }}</div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th class="header">Nama Makanan</th>
                    <th class="header">Jumlah</th>
                    <th class="header-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td class="item-qty">{{ $item['quantity'] }}</td>
                        <td style="text-align: right">{{ number_format($item['item_total'], 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total-container">
            <span>Total:</span>
            <span style="text-align: right"> {{ number_format($total, 0) }}</span>
            <div>Dibayar: {{ number_format($Payment_Amount, 0) }}</div>
            <div>Kembali: {{ number_format($change, 0) }}</div>
        </div>

        <div class="total-section">
            <div style="margin-bottom: 8px">Metode Pembayaran: {{ $Payment_Method }}</div>
        </div>

        <div class="footer">
            Terima kasih telah Membeli Makan/Minum di {{ $store_name }}!
        </div>
    </div>
</body>

</html>
