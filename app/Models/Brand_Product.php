<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BrandProduct;
class Brand_Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $fillable = [
        'brand_name',
        'brand_desc',
        'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'brand_product';

}
