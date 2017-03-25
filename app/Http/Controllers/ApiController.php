<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Contracts\Validation\Validator;


/**
 * Class ApiController
 */
class ApiController extends BaseController{

    use ValidatesRequests;

    /*
        Function to return validate error response
     */

    protected function formatValidationErrors(Validator $validator)
    {
        return  [
                    'status_code'=>'422',
                    'message' => $validator->errors()->all()
                ];
    }
    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorizedError($message = 'Unauthorized!')
    {
        $response = [
            'status_code' => 401,
            'status_message' => $message,
        ];

        return response()->json($response,401);
    }

    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        $response = [
            'status_code' => 404,
            'status_message' => $message,
        ];

        return response()->json($response,404);
    }

    /**
     * Function to return a generic response.
     *
     * @param $data Data to be used in response.
     * @return mixed Return the response.
     */
    public function respondSuccess($data=null)
    {
        $response = [
            'status_code' => 200,
            'data' => $data,
        ];

        return response()->json($response,200);

    }

    /**
     * @param $message
     * @return mixed
     */
    protected function respondCreated($message)
    {
        $response = [
            'status_code' => 201,
            'data' => $message,
        ];

        return response()->json($response,201);
    }

    public function responseExists($message)
    {
        $response = [
            'status_code' => 409,
            'data' => $message,
        ];

        return response()->json($response,409);
    }


}
