<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua produk
        return Purchase::select('id', 'item_name', 'quantity', 'transaction_date', 'payment_method', 'price', 'total_price')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item Name',
            'Quantity',
            'Transaction Date',
            'Payment Method',
            'Price per Item',
            'Total Price',
        ];
    }
}
