<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Agent extends Model
{
    protected $hidden = [
        'created_at', 'updated_at','user'
    ];

    protected $appends = ['name','location','phone'];

     protected $fillable = [
        'user_id',
        'service_id',
        'photo',
        'no_ktp',
        'no_rekening',
        'nama_rekening',
        'address',
        'register_date',
        'lat',
        'lng'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }



    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone;
    }

    public function getLocationAttribute()
    {
        return $this->user->location;
    }
}
