<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProduct implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'category_id' =>$row[0],
            'brand_id'=>$row[1],
            'product_name'=>$row[2],
            'product_quantity'=>$row[3],
            'product_price'=>$row[4],
            'product_desc'=>$row[5],
            'product_content'=>$row[6],
            'product_image'=>$row[7],
            'status'=>$row[8],
        ]);
    }
}
