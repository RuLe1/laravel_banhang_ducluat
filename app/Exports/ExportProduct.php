<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class ExportProduct implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::query()->select('id',
                                        'category_id',
                                        'brand_id',
                                        'product_name',
                                        'product_quantity',
                                        'product_price',
                                        'product_image',
                                        'status')->get();
    }
    public function headings(): array
    {
        return [
            'id',
            'category_id',
            'brand_id',
            'product_name',
            'product_quantity',
            'product_price',
            'product_image',
            'status'
        ];
    } 
}
