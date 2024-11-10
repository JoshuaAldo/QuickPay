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
            padding: 8px;
            /* Mengurangi padding untuk lebih banyak ruang */

        }

        .store-name {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            text-align: center;
        }

        .items tr {
            margin: 0;
        }

        .headNota tr {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: separate;
            /* Enable border-spacing */

            /* Space between cells */
        }

        .items {
            margin-bottom: 16px;
        }

        .header {
            text-align: left;
            margin-left: 8px;
        }

        .header-right {
            text-align: right;
        }

        /* .item-qty {
            margin-left: 4px
        } */

        .footer {
            font-size: 10px;
            text-align: center;
            font-weight: bold;
        }

        .total-container {
            margin-bottom: 12px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        hr {
            width: 100%;
            border: 0;
            border-top: 1px dashed black;
            /* Memberikan margin di atas dan bawah */
        }

        .footNota {
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="store-name">
            {{ $store_name }} <span style="font-weight: normal; font-size: 10px">Sukolilo/Semolowaru/Rumah Semolowaru
                Tengah
                11/5, Sukolilo,
                Semolowaru, Surabaya</span>
        </div>
        <table class="headNota">
            <tbody>
                <tr>
                    {{-- <td>
                        Tanggal:
                    </td> --}}
                    <td style="text-align: right;font-size: 9px">
                        <span>{{ $order_date }}</span>
                    </td>
                </tr>
                <tr>
                    {{-- <td>
                        Nomer Order:
                    </td> --}}
                    <td style="text-align: right;font-size: 9px">
                        <span>{{ $order_number }}</span>
                    </td>
                </tr>
                <tr>
                    {{-- <td style="font-size: 9.5px">
                        Nama Customer:
                    </td> --}}
                    <td style="text-align: right;font-size: 9px">
                        <span>{{ $customer_name }}</span>
                    </td>
                </tr>
            </tbody>
        </table>


        <table class="items">
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="item-qty">{{ $item['quantity'] }}x</td>
                        <td>{{ '@' }}{{ number_format($item['harga_makanan'], 0) }}
                        </td>
                        <td style="text-align: right">{{ number_format($item['item_total'], 0) }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $item['description'] }}</td>
                    </tr>
                    <td colspan="3">
                        <hr>
                    </td>
                @endforeach
            </tbody>
        </table>


        <table class="footNota">
            <tbody>
                <tr>
                    <td>
                        Subtotal
                    </td>
                    <td style="text-align: right">
                        <span>{{ number_format($total, 0) }}</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        Pajak
                    </td>
                    <td style="text-align: right">
                        <span>-</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        Total
                    </td>
                    <td style="text-align: right">
                        <span>{{ number_format($total, 0) }}</span>
                    </td>
                </tr>

                <td colspan="3">
                    <hr>
                </td>

                @if (
                    $Payment_Method === 'Cash' ||
                        $Payment_Method === 'QR' ||
                        $Payment_Method === 'Debit' ||
                        $Payment_Method === 'Credit Card' ||
                        $Payment_Method === 'Transfer')
                    <tr>
                        <td>
                            {{ $Payment_Method }}
                        </td>
                        <td style="text-align: right">
                            <span>{{ number_format($Payment_Amount, 0) }}</span>
                        </td>
                    </tr>
                @elseif($Payment_Method === 'Cash & QR')
                    <tr>
                        <td>
                            Cash
                        </td>
                        <td style="text-align: right">
                            <span>{{ number_format($Cash_Amount, 0) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            QR
                        </td>
                        <td style="text-align: right">
                            <span>{{ number_format($QR_Amount, 0) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $Payment_Method }}
                        </td>
                        <td style="text-align: right">
                            <span>{{ number_format($Payment_Amount, 0) }}</span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>
                        Kembalian
                    </td>
                    <td style="text-align: right">
                        <span>{{ number_format($change, 0) }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            Terima kasih telah Membeli Makan/Minum di {{ $store_name }}!
        </div>
    </div>
</body>

</html>
