@extends('layouts.app')

@section('title', 'Exemplo de Pagamento')

@section('content')
    <div class="container p-3 mb-3 bg-body-secondary rounded">
        <h2 class="lead text-uppercase">Resumo</h2>
        <p class="mb-0">
            Produto: {{ $description }}<br>
            Valor total: R$ {{ $amountValue }}
        </p>
    </div>

    @include('payment-methods.list')
    @include('payment-methods.creditcard')
    @include('payment-methods.boleto')

    <script>
        document.querySelector('form#form-payment-method').addEventListener("submit", function (e) {
            e.preventDefault();

            const chosenPaymentMethod = document.querySelector('input[name="payment-method-options"]:checked').value;
            
            document.getElementById('container-payment-method').classList.add('d-none');
            document.getElementById('container-payment-method-' + chosenPaymentMethod).classList.remove('d-none');
            document.querySelectorAll('#container-payment-method-' + chosenPaymentMethod + ' fieldset').forEach((fieldset) => {
                fieldset.removeAttribute('disabled');
            });
        });

        document.querySelectorAll('button.form-checkout-change-payment-method').forEach((button) => {
            button.addEventListener('click', function (e) {
                document.querySelectorAll('.payment-method fieldset').forEach((fieldset) => {
                    fieldset.setAttribute('disabled', true);
                });
                document.querySelectorAll('.payment-method').forEach((paymentMethodContainer) => {
                    paymentMethodContainer.classList.add('d-none');
                });
                document.getElementById('container-payment-method').classList.remove('d-none');
            });
        });
    </script>
@endsection
