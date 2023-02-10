<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'sort',
        'price',
        'category_id',
        'picture',
        'description',
        'isActual',
        'isAvailable'
    ];

    public function setPictureAttribute($value) {
        $attribute_name = "picture";
        $disk = "public";
        $destination_path = "image/product";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id');
    }

}
