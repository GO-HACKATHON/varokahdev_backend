<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'price'
    ];

    protected $hidden = [
        'created_at', 'updated_at','price','qty','total'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }



}
