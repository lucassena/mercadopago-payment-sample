<section id="container-payment-method-creditcard" class="container payment-method d-none">
    <div class="row">
        <div class="col-md mb-3">
            <h2 class="display-6">Cartão de crédito</h2>
        </div>
    </div>
    <div id="alert-errors" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        <strong>Poxa!</strong> O pagamento com o cartão foi recusado, revise os campos e tente novamente!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div id="liveAlertPlaceholder"></div>
    <form id="form-checkout-creditcard" name="form-checkout-creditcard">
        <fieldset disabled>
            <legend class="lead">Dados do cartão</legend>

            <div class="form-floating mb-3">
                <input type="text" id="form-checkout__cardholderName" class="form-control form-control-sm" placeholder="Nome do títular do cartão" />
                <label for="form-checkout__cardholderName">Nome do títular do cartão</label>
            </div>
            <div class="form-floating mb-3">
                <div id="form-checkout__cardNumber" class="form-control form-control-sm input-iframe" placeholder="Número do cartão"></div>
                <label for="form-checkout__cardNumber">Número do cartão</label>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <div id="form-checkout__expirationDate" class="form-control form-control-sm input-iframe"></div>
                        <label for="form-checkout__expirationDate">Data de Expiração</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <div id="form-checkout__securityCode" class="form-control form-control-sm input-iframe"></div>
                        <label for="securityCode">Código de Segurança</label>
                    </div>
                </div>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <select id="form-checkout__issuer" class="form-control form-control-sm"></select>
                        <label for="form-checkout__issuer">Bandeira</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <select id="form-checkout__installments" class="form-control form-control-sm"></select>
                        <label for="form-checkout__installments">Nº de Parcelas</label>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset disabled>
            <legend class="lead">Suas informações</legend>

            <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <select id="form-checkout__identificationType" class="form-control form-control-sm"></select>
                        <label for="form-checkout__identificationType">Tipo de documento</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" id="form-checkout__identificationNumber" class="form-control form-control-sm" placeholder="Número do documento" />
                        <label for="form-checkout__identificationNumber">Número do documento</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="email" id="form-checkout__cardholderEmail" class="form-control form-control-sm" placeholder="E-mail" />
                <label for="form-checkout__cardholderEmail">E-mail</label>
            </div>
        </fieldset>

        <div class="mb-3">
            <button type="submit" id="form-checkout__submit" class="btn btn-primary">Pagar</button>
            <button type="button" class="btn btn-link btn-sm link-secondary text-decoration-none btn-sm form-checkout-change-payment-method">&lt; Alterar forma de pagamento</button>
        </div>
    </form>
</section>

<script>
    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')

    const alert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('')

        alertPlaceholder.append(wrapper)
    }

    function sleep (time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }
</script>
<script>
    const cardForm = mp.cardForm({
        amount: "{{ $amountValue }}",
        iframe: true,
        form: {
            id: "form-checkout-creditcard",
            cardNumber: {
                id: "form-checkout__cardNumber",
                placeholder: "Número do cartão",
                style: {
                    color: "#212529",
                    fontSize: ".875rem",
                },
            },
            expirationDate: {
                id: "form-checkout__expirationDate",
                placeholder: "MM/YY",
                style: {
                    color: "#212529",
                    fontSize: ".875rem",
                },
            },
            securityCode: {
                id: "form-checkout__securityCode",
                placeholder: "Código de segurança",
                style: {
                    color: "#212529",
                    fontSize: ".875rem",
                },
            },
            cardholderName: {
                id: "form-checkout__cardholderName",
                placeholder: "Titular do cartão",
            },
            issuer: {
                id: "form-checkout__issuer",
                placeholder: "Banco emissor",
            },
            installments: {
                id: "form-checkout__installments",
                placeholder: "Parcelas",
            },        
            identificationType: {
                id: "form-checkout__identificationType",
                placeholder: "Tipo de documento",
            },
            identificationNumber: {
                id: "form-checkout__identificationNumber",
                placeholder: "Número do documento",
            },
            cardholderEmail: {
                id: "form-checkout__cardholderEmail",
                placeholder: "E-mail",
            },
        },
        callbacks: {
            onFormMounted: error => {
                if (error) return console.warn("Form Mounted handling error: ", error);
                console.log("Form mounted");
            },
            onSubmit: event => {
                event.preventDefault();

                const {
                    paymentMethodId: payment_method_id,
                    issuerId: issuer_id,
                    cardholderEmail: email,
                    amount,
                    token,
                    installments,
                    identificationNumber,
                    identificationType,
                } = cardForm.getCardFormData();

                fetch("/process_payment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': document.querySelector('meta[name~="csrf-token"][content]').content
                    },
                    body: JSON.stringify({
                        token,
                        issuer_id,
                        payment_method_id,
                        transaction_amount: Number(amount),
                        installments: Number(installments),
                        description: "Descrição do produto",
                        payer: {
                            email,
                            identification: {
                                type: identificationType,
                                number: identificationNumber,
                            },
                        },
                        payment_method: 'creditcard',
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status == 'approved') {
                            alert('Pagamento aprovado com sucesso!', 'success');
                            sleep(800).then(() => {
                                window.location = '/thankyou';
                            });
                        } else if (data.status == 'in_process') {
                            alert('Pagamento em processamento!', 'light');
                            sleep(800).then(() => {
                                window.location = '/thankyou?status=in_process';
                            });
                        } else {
                            liveAlertPlaceholder.innerHTML = "";
                            const alertErrors = new bootstrap.Alert('#alert-errors');
                            alertErrors._element.classList.toggle('d-none');
                        }
                    });
            },
            onFetching: (resource) => {
                console.log("Fetching resource: ", resource);
            },
            onError: (errors) => {
                liveAlertPlaceholder.innerHTML = "";
                errors.forEach((error) => alert(error.message, 'warning'));
            },
        },
    });
</script>

