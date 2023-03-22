<section id="container-payment-method-boleto" class="container payment-method d-none">
    <div class="row">
        <div class="col-md mb-3">
            <h2 class="display-6">Boleto</h2>
        </div>
    </div>

    <form id="form-checkout-boleto" name="form-checkout-boleto" action="/process_payment" method="post">
        <fieldset disabled>
            @csrf
            <legend class="lead">Suas informações</legend>
            
            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" id="form-checkout__payerFirstName" name="payerFirstName" class="form-control form-control-sm" placeholder="Nome do títular do cartão" required />
                        <label for="form-checkout__payerFirstName">Nome</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" id="form-checkout__payerLastName" name="payerLastName" class="form-control form-control-sm" placeholder="Nome do títular do cartão" required />
                        <label for="form-checkout__payerLastName">Sobrenome</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="email" id="form-checkout__email" name="email" class="form-control form-control-sm" placeholder="E-mail" required />
                <label for="form-checkout__email">E-mail</label>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <select id="form-checkout-boleto__identificationType" name="identificationType" class="form-control form-control-sm" required></select>
                        <label for="form-checkout-boleto__identificationType">Tipo de documento</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" id="form-checkout__identificationNumber" name="identificationNumber" class="form-control form-control-sm" placeholder="Número do documento" required />
                        <label for="form-checkout__identificationNumber">Número do documento</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="transactionAmount" id="transactionAmount" value="{{ $amountValue }}">
            <input type="hidden" name="description" id="description" value="{{ $description }}">
            <input type="hidden" name="payment_method" id="paymentMethod" value="boleto">
        </fieldset>

        <div class="mb-3">
            <button type="submit" id="form-checkout__submit" class="btn btn-primary">Pagar</button>
            <button type="button" class="btn btn-link btn-sm link-secondary text-decoration-none btn-sm form-checkout-change-payment-method">&lt; Alterar forma de pagamento</button>
        </div>
    </form>
</section>

<script>
    (async function getIdentificationTypes() {
        try {
            const identificationTypes = await mp.getIdentificationTypes();
            const identificationTypeElement = document.getElementById('form-checkout-boleto__identificationType');

            createSelectOptions(identificationTypeElement, identificationTypes);
        } catch (e) {
            return console.error('Error getting identificationTypes: ', e);
        }
    })();

    function createSelectOptions(elem, options, labelsAndKeys = { label: "name", value: "id" }) {
        const { label, value } = labelsAndKeys;

        elem.options.length = 0;

        const tempOptions = document.createDocumentFragment();

        options.forEach(option => {
            const optValue = option[value];
            const optLabel = option[label];

            const opt = document.createElement('option');
            opt.value = optValue;
            opt.textContent = optLabel;

            tempOptions.appendChild(opt);
        });

        elem.appendChild(tempOptions);
    }
</script>
