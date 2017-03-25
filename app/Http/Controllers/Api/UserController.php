<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\User;

class UserController extends ApiController
{
    protected $user;

    function __construct()
    {
        $this->user = new User;
    }

    public function setLocation(Request $request)
    {
        $this->validate($request, [
            'lat' => 'required',
            'lng' => 'required',
        ]);

       $user = $this->user->find(auth('api')->user()->id);

       $user->update([
            'lat' => $request->lat,
            'lng' => $request->lng
        ]);

       return $this->respondSuccess($user);

    }
}
