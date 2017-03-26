<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\Service;
use App\Models\Agent;
use App\User;

class ServiceController extends ApiController
{
    protected $service;

    protected $agent;

    function __construct()
    {
        $this->service = new Service;
        $this->agent = new Agent;
    }
    public function index()
    {
        $services = $this->service->all();

        return $this->respondSuccess($services);
    }

    public function showAgent($id)
    {
        $user = auth('api')->user();
        $lat = $user->lat;
        $lng = $user->lng;

        $agents = $this->agent
                        ->selectRaw("*,( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance")
                        ->having("distance", "<", 5)
                        ->where('service_id',$id)
                        ->get();

         return $this->respondSuccess($agents);

    }
}
