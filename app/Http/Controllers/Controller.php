<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //status code
    const BAD_REQUEST = 400;

    public function successResponse($data, $msg)
    {
        return response()->json([
           'err'    => 0,
           'data'   => $data,
           'msg'    => $msg
        ]);
    }

    public function errorResponse($err, $data, $msg)
    {
        return response()->json([
            'err'    => $err,
            'data'   => $data,
            'msg'    => $msg
        ]);
    }
}
