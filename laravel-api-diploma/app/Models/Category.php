<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'prevImage'
    ];

    public function setprevImageAttribute($value) {
        $attribute_name = "prevImage";
        $disk = "public";
        $destination_path = "image/preview";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
