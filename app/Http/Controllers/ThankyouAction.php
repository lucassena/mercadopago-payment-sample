<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThankyouAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = [];
        if ($request->get('status')) {
            $data['payment_status'] = $request->get('status');
        }
        return view('thankyou', $data);
    }
}
