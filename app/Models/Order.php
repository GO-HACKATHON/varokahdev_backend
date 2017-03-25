<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'agent_id',
        'service_id',
        'location',
        'to_location',
        'address',
        'note',
        'order_date',
        'done_date',
        'cancel_date',
        'take_date',
        'total',
        'status',
        'agent_arrival_time'
    ];
}
