<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\Agent;

class AgentController extends ApiController
{
    protected $agent;

    function __construct()
    {
        $this->agent = new Agent;
    }

    public function setLocation(Request $request)
    {
        $this->validate($request, [
            'lat' => 'required',
            'lng' => 'required',
        ]);

       $agent = $this->agent->where('user_id',auth('api')->user()->id)->first();

        $agent->update([
            'lat' => $request->lat,
            'lng' => $request->lng
        ]);



       return $this->respondSuccess($agent);

    }
}
