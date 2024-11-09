<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsCategoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Category::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category Name',
            'Capital',
            'Total Stock',
            'Created at',
            'Updated at'
        ];
    }
}
