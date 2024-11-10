<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintController extends Controller
{
    public function printReceipt(Request $request)
    {
        // // Ambil ID order dari query parameter atau dari request
        $orderId = $request->input('order_id');

        // Validasi ID order
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Ambil data order items
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $change = $order->payment_amount - $orderItems->sum('item_total');

        // Siapkan data struk
        $receiptData = [
            'store_name' => 'Delicious Foodies',
            'order_date' => $order->order_date,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'items' => $orderItems->map(function ($item) {
                $harga_makanan = $item->item_total / $item->quantity;
                return [
                    'name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'description' => $item->description,
                    'item_total' => $item->item_total,
                    'harga_makanan' => $harga_makanan,
                ];
            }),
            'Payment_Method' => $order->payment_method,
            'total' => $orderItems->sum('item_total'),
            'Payment_Amount' => (int)$order->payment_amount,
            'Cash_Amount' => (int)$order->cash_amount,
            'QR_Amount' => (int)$order->qr_amount,
            'change' => $change,
        ];

        $itemHeight = 40;
        if ($order->payment_method === "Cash & QR") {
            $pageHeight = 220 + (count($receiptData['items']) * $itemHeight) + 20;
        } else {
            $pageHeight = 220 + (count($receiptData['items']) * $itemHeight);
        }

        // $pageHeight = min($pageHeight, 2000);
        // Generate PDF menggunakan data struk dan view Blade
        $pdf = Pdf::loadView('receipts.receipt', $receiptData)
            ->setPaper([0, 0, 164.8, $pageHeight], 'portrait'); // Atur lebar kertas 58mm (164.8px), tinggi sementara

        // Kembalikan PDF sebagai respons download
        // return $pdf->download('receipt.pdf');
        $fileName = 'receipt_' . $receiptData['order_number'] . '.pdf';
        return response()->make($pdf->output(), 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function receiptPreview($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $orderItems = OrderItem::where('order_id', $id)->get();
        $change = $order->payment_amount - $orderItems->sum('item_total');

        $receiptData = [
            'store_name' => 'Delicious Foodies',
            'order_date' => $order->order_date,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'items' => $orderItems->map(function ($item) {
                return [
                    'name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'item_total' => $item->item_total,
                ];
            }),
            'Payment_Method' => $order->payment_method,
            'total' => $orderItems->sum('item_total'),
            'Payment_Amount' => (int)$order->payment_amount,
            'change' => $change,
        ];

        return view('receipts.modal-view', $receiptData);
    }
}
