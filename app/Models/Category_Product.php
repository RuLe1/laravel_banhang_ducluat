<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CategoryProduct;
class Category_Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'category_name',
        'category_desc',
        'category_parent',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $table = 'category_product';

    public function product(){
        return $this->hasMany('App\Models\Product','category_id','id');
    }
}
