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
        'user_id',
        'delivery'
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }

    public function pictures()
    {
        $ord = $this->products()->select('picture');
        
        return $ord;
    }
    
}
