<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'image',
    ];

    public function setPictureAttribute($value) {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "image/reviews";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
