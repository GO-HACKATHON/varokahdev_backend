<?php

namespace App;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use HasPermissionsTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','status','lat','lng'
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

    public function login(Request $request)
    {
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credential)){
            return true;
        }else{
            return false;
        }
    }
}
