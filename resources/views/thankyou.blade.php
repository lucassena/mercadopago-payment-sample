@extends('layouts.app')

@section('title', 'Obrigado')

@section('content')
    <div>
        <div class="container text-center">
            <div class="container p-3 mb-3 bg-body-secondary rounded">
                <h2 class="lead text-success">Obrigado pela compra em nossa loja. :)</h2>
                <p class="mb-0">Volte sempre!</p> 
            </div>

            @if (isset($payment_status) && $payment_status == 'in_process')
                <p class="alert alert-warning" role="alert">
                    <small>Seu pagamento está em processamento!</small>
                </p>
            @endif

            @if ($status = session('status'))
                @if (isset($status['external_resource_url']))
                    <div>
                        <p>
                            <small>
                                Segue o link para pagamento do boleto: <br>
                                <a href="{{ $status['external_resource_url'] }}" target="__blank" class="text-break">{{ $status['external_resource_url'] }}</a>
                            </small>
                        </p>
                        <p class="alert alert-light" role="alert">Fique atento, pois o boleto vence em {{ $status['daysLeft'] }} dias!</p>
                    </div>
                @endif
            @endif

            <a href="/" class="btn btn-link btn-sm link-secondary text-decoration-none btn-sm form-checkout-change-payment-method">Voltar ao inicio</button>
        </div>
    </div>
@endsection
