<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Meal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['meal_img_url'];

    protected $fillable = [
        'meal_name',
        'price',
        'description',
        'meal_img',
        'status',
    ];

    public function getMealImgUrlAttribute()
    {
        return Storage::disk('public')->url($this->meal_img);
    }
}
