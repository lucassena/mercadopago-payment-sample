<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;
use Exception;

class ProcessPayment extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            MercadoPago\SDK::setAccessToken(getenv('MERCADO_PAGO_ACCESS_TOKEN'));
    
            $paymentMethod = $request->input('payment_method');
    
            if ($paymentMethod == 'creditcard') {
                $payment = $this->creditCard($request);
            } elseif ($paymentMethod == 'boleto') {
                $payment = $this->boleto($request);
            }
    
            if (!$payment->save()) {
                $this->handlePaymentError($payment);
            }
    
            $response = [
                'status' => $payment->status,
                'status_detail' => $payment->status_detail,
                'id' => $payment->id,
            ];
    
            if ($paymentMethod == 'boleto') {
                $now = time();
                $dateOfExpiration = strtotime($payment->date_of_expiration);
                $datediff = $now - $dateOfExpiration;
    
                $response = [
                    ...$response,
                    'external_resource_url' => $payment->transaction_details->external_resource_url,
                    'date_of_expiration' => $payment->date_of_expiration,
                    'daysLeft' => abs(round($datediff / (60 * 60 * 24))),
                ];
                return redirect('/thankyou')->with('status', $response);
            } else {
                return response()->json($response);
            }
        } catch(Exception $exception) {
            $response = [
                'error_message' => $exception->getMessage(),
            ];
    
            return response()->json($response)->setStatusCode(400);
        }
    }

    private function creditCard(Request $request): MercadoPago\Payment
    {
        $payment = new MercadoPago\Payment();
        $payment->description = $request->input('description');
        $payment->transaction_amount = (float) $request->input('transaction_amount');
        $payment->token = $request->input('token');
        $payment->payment_method_id = $request->input('payment_method_id');
        $payment->installments = (int) $request->input('installments');
        $payment->issuer_id = (int) $request->input('issuer_id');
        
        $payer = new MercadoPago\Payer();
        $payer->email = $request->input('payer')['email'];
        $payer->identification = $request->input('payer')['identification'];
        $payment->payer = $payer;

        return $payment;
    }


    private function boleto(Request $request): MercadoPago\Payment
    {
        $payment = new MercadoPago\Payment();
        $payment->description = $request->input('description');
        $payment->transaction_amount = (float) $request->input('transactionAmount');
        $payment->payment_method_id = 'bolbradesco';
        $payment->payer = [
            "email" => $request->input('email'),
            "first_name" => $request->input('payerFirstName'),
            "last_name" => $request->input('payerLastName'),
            "identification" => [
                "type" => $request->input('identificationType'),
                "number" => $request->input('identificationNumber')
            ],
        ];

        return $payment;
    }

    private function handlePaymentError(MercadoPago\Payment $payment)
    {
        $errorMessage = "Houve um erro desconhecido no processo de pagamento!";
    
        if ($payment->Error() !== null) {
            $sdkErrorMessage = $payment->Error()->message;
            $errorMessage = $sdkErrorMessage ?? $errorMessage;
        }

        throw new Exception($errorMessage);
    }
}
