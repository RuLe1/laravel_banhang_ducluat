<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $fillable = [
        'category_id',
        'brand_id',
        'product_name',
        'product_quantity',
        'product_price',
        'product_desc',
        'product_content',
        'product_image',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $table = 'product';

    public function categoryproduct(){
        return $this->belongsTo('App\Models\Category_Product','category_id','id');
    }
    public function brandproduct(){
        return $this->belongsTo('App\Models\Brand_Product','brand_id','id');
    }
}
