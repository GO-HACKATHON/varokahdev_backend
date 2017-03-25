<?php

namespace App;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasPermissionsTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function register(Request $request)
    {
        return self::create([
                'email'     => $request->email,
                'name'      => $request->name,
                'password'  => bcrypt($request->password),
                'phone'    => $request->phone,
                'api_token' => str_random(40),
            ]);
    }
}
