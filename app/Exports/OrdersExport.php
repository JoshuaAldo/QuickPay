<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil semua pesanan dengan relasi item
        return Order::with('items')
            ->select('id', 'order_number', 'customer_name', 'order_date', 'payment_method', 'payment_amount', 'cash_amount', 'qr_amount', 'settlement_status', 'payment_reference', 'discount')
            ->get();
    }

    public function map($order): array
    {
        $rows = [];
        $totalAmount = 0;  // Variabel untuk menghitung total transaksi sebelum diskon

        // Ambil data order untuk baris pertama
        $orderData = [
            'Order ID'          => $order->id,
            'Order Number'      => $order->order_number,
            'Customer Name'     => $order->customer_name,
            'Order Date'        => $order->order_date,
            'Payment Method'    => $order->payment_method,
            'Payment Amount'    => 'Rp ' . number_format($order->payment_amount, 0, ',', '.'),
            'Cash Amount'       => 'Rp ' . number_format($order->cash_amount, 0, ',', '.'),
            'QR Amount'         => 'Rp ' . number_format($order->qr_amount, 0, ',', '.'),
            'Settlement Status' => $order->settlement_status,
            'Payment Reference' => $order->payment_reference,
            'Discount'          => 'Rp ' . number_format($order->discount, 0, ',', '.'),
            'Product Name'      => '',  // Kosongkan untuk baris item
            'Quantity'          => '',  // Kosongkan untuk baris item
            'Price'             => '',  // Kosongkan untuk baris item
        ];

        // Untuk setiap item di order, buat baris baru
        foreach ($order->items as $index => $item) {
            // Jika ini adalah item pertama, masukkan data order
            if ($index == 0) {
                // Menambahkan data order untuk baris pertama
                $rows[] = [
                    'Order ID'          => $order->id,
                    'Order Number'      => $order->order_number,
                    'Customer Name'     => $order->customer_name,
                    'Order Date'        => $order->order_date,
                    'Payment Method'    => $order->payment_method,
                    'Payment Amount'    => 'Rp ' . number_format($order->payment_amount, 0, ',', '.'),
                    'Cash Amount'       => 'Rp ' . number_format($order->cash_amount, 0, ',', '.'),
                    'QR Amount'         => 'Rp ' . number_format($order->qr_amount, 0, ',', '.'),
                    'Settlement Status' => $order->settlement_status,
                    'Payment Reference' => $order->payment_reference,
                    'Discount'          => 'Rp ' . number_format($order->discount, 0, ',', '.'),
                    'Product Name'      => $item->product_name,
                    'Quantity'          => $item->quantity,
                    'Price'             => 'Rp ' . number_format($item->item_total, 0, ',', '.'),
                ];
            } else {
                // Menambahkan data item untuk baris berikutnya
                $rows[] = [
                    'Order ID'          => '',  // Kosongkan untuk baris item
                    'Order Number'      => '',  // Kosongkan untuk baris item
                    'Customer Name'     => '',  // Kosongkan untuk baris item
                    'Order Date'        => '',  // Kosongkan untuk baris item
                    'Payment Method'    => '',  // Kosongkan untuk baris item
                    'Payment Amount'    => '',  // Kosongkan untuk baris item
                    'Cash Amount'       => '',  // Kosongkan untuk baris item
                    'QR Amount'         => '',  // Kosongkan untuk baris item
                    'Settlement Status' => '',  // Kosongkan untuk baris item
                    'Payment Reference' => '',  // Kosongkan untuk baris item
                    'Discount'          => '',  // Kosongkan untuk baris item
                    'Product Name'      => $item->product_name,
                    'Quantity'          => $item->quantity,
                    'Price'             => 'Rp ' . number_format($item->item_total, 0, ',', '.'),
                ];
            }
            // Tambahkan total item ke totalAmount
            $totalAmount += $item->item_total;
        }

        // Menghitung total transaksi setelah diskon
        $totalTransaction = $totalAmount - $order->discount;

        // Tambahkan baris Total Transaction
        $rows[] = [
            'Order ID'          => '',  // Kosongkan untuk Total Transaction
            'Order Number'      => '',  // Kosongkan untuk Total Transaction
            'Customer Name'     => '',  // Kosongkan untuk Total Transaction
            'Order Date'        => '',  // Kosongkan untuk Total Transaction
            'Payment Method'    => '',  // Kosongkan untuk Total Transaction
            'Payment Amount'    => '',  // Kosongkan untuk Total Transaction
            'Cash Amount'       => '',  // Kosongkan untuk Total Transaction
            'QR Amount'         => '',  // Kosongkan untuk Total Transaction
            'Settlement Status' => '',  // Kosongkan untuk Total Transaction
            'Payment Reference' => '',  // Kosongkan untuk Total Transaction
            'Discount'          => '',  // Kosongkan untuk Total Transaction
            'Product Name'      => 'Total Transaction',
            'Quantity'          => '',
            'Price'             => 'Rp ' . number_format($totalTransaction, 0, ',', '.'),
        ];

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Order Number',
            'Customer Name',
            'Order Date',
            'Payment Method',
            'Payment Amount',
            'Cash Amount',
            'QR Amount',
            'Settlement Status',
            'Payment Reference',
            'Discount',
            'Product Name',
            'Quantity',
            'Price',
        ];
    }
}
