<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\User;
use Auth;


class AuthController extends ApiController
{
    protected $user;

    function __construct()
    {
        $this->user = new User;
    }

    public function login(Request $request)
    {
       $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($this->user->login($request)){
            return $this->respondSuccess(Auth::guard('user')->user());
        }else{
            return $this->respondUnauthorizedError('password/email anda salah');
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'password'  => 'required',
            'phone'    => 'required',
        ]);

        $user = $this->user->register($request);

        return $this->respondCreated($user);
    }
}
