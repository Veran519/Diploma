<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'order';

    protected $fillable = [
        'name',
        'adress',
        'phone',
        'product_id',
        'delivery'
    ];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
    
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order_product() {
        return $this->belongsTo(Order_Product::class, 'id', 'order_id');
    }
}
