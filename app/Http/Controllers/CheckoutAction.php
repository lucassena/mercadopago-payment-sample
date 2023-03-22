<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;

class CheckoutAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        MercadoPago\SDK::setAccessToken(getenv('MERCADO_PAGO_ACCESS_TOKEN'));

        return view('checkout', ['amountValue' => 100.5, 'description' => 'Descrição do produto']);
    }
}
