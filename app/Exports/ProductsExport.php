<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua produk
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Base Price',
            'Sell Price',
            'Stock',
            'Category ID',
            'Created at',
            'Updated at'
        ];
    }
}
