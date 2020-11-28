<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_no',
        'user_id',
        'amount',
        'status',
    ];

    public function user()
    {
        $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order');

    }
}
