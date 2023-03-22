<section id="container-payment-method" class="container">
    <form id="form-payment-method" name="form-payment-method">
        <fieldset>
            <legend class="lead">Selecione o método de pagamento</legend>
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <input type="radio" class="form-check-input me-1" name="payment-method-options" value="creditcard" id="btn-creditcard" autocomplete="off" />
                    <label class="form-check-label" for="btn-creditcard">Cartão de Crédito</label>
                </li>
                <li class="list-group-item">
                    <input type="radio" class="form-check-input me-1" name="payment-method-options" value="boleto" id="btn-boleto" autocomplete="off" />
                    <label class="form-check-label" for="btn-boleto">Boleto</label>
                </li>
            </ul>
        </fieldset>
        <div class="mb-3">
            <button type="submit" id="form-checkout__submit" class="btn btn-primary">Continuar</button>
        </div>
    </form>
</section>