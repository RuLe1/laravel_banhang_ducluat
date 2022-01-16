<?php

namespace App\Imports;

use App\Models\Category_Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category_Product([
            'category_name' =>$row[0],
            'meta_keywords' =>$row[1],
            'category_desc' =>$row[2],
            'category_parent' =>$row[3],
            'status' =>$row[4],
        ]);
    }
}
