<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'meal_raw' => 'array'
    ];

    protected $fillable = [
        'order_no',
        'meal_raw',
        'amount',
        'status',
        'user_id',
        'purchase_id',
    ];

//    public function user()
//    {
//        $this->belongsTo('App\Models\User');
//    }
//
//    public function purchase()
//    {
//        $this->belongsTo('App\Models\Purchase');
//    }
}
