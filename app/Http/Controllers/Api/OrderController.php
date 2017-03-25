<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\Order;
use App\Models\Agent;
use App\Models\OrderItem;
use Auth;

class OrderController extends ApiController
{
    protected $order;

    function __construct()
    {
        $this->order = new Order;
    }

    public function order(Request $request)
    {
        $user_id = auth('api')->user()->id;

        $this->validate($request, [
            'location' => 'required',
            'address' => 'required',
            'note' => 'required',
        ]);


        $order = $this->order->create([
                'user_id' => $user_id,
                'service_id' => $request->service_id,
                'location' => $request->location,
                'to_location' => $request->location,
                'address' => $request->address,
                'note' => $request->note,
                'order_date' => date("Y-m-d"),
                'status' => 'new',
            ]);


        return $this->respondSuccess($order);

    }


    public function takeOrder($order_id)
    {
        $response = \GoogleMaps::load('distancematrix')
            ->setParam([
                'origins'          => '-6.2436223,106.8001397',
                'destinations'     => '-6.234121,106.7151269',
            ])
            ->get();


        $data = json_decode($response);

        $agent = Agent::where('user_id',auth('api')->user()->id)->first();
        $order = $this->order->find($order_id);

        if ($order->service_id ==  $agent->service_id){

            $take = $order->update([
                'agent_id'            => $agent->id,
                'take_order'          => date("Y-m-d"),
                'agent_arrival_time'  => $data->rows[0]->elements[0]->duration->text,
                'status'              => 'on progress'
            ]);

           return $this->respondSuccess($order);

        }else{
            return 0;
        }


    }

    public function doneOrder($order_id,Request $request)
    {
        $subTotal = $this->subTotal($request);

        $order = $this->order->find($order_id);
        $order->update([
            'done_date' => date("Y-m-d"),
            'total' => $subTotal,
            'status' => 'done'
        ]);

        $items = $request->items;



        foreach ($items as $item) {
            $orderItem =  new OrderItem;

            $orderItem->create([
                'order_id' => $order_id,
                'name' => $item['name'],
                'price' => $item['price']
            ]);
        }


        return $order;
    }


    public function show($order_id)
    {
         $order = $this->order->with('orderItem')->find($order_id);

         return $order;
    }

    public function subTotal(Request $request)
    {
        $items = $request->items;

        $total = 0;

        foreach ($items as $item) {

            $total = $total + $item['price'];
        }

        return $total;
    }
}
