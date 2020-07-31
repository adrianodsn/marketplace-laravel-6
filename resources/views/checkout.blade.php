@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <h2 class="mb-5">Pagamento</h2>

            <div class="form-group">
                <label for="card_number">Número do cartão <span class="brand"></span></label>
                <input class="form-control" id="card_number" maxlength="16" name="card_number" type="text">
                <input id="card_brand" name="card_brand" required type="hidden">
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label for="card_expiration_month">Data de validade</label>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <input class="form-control" id="card_expiration_month" max="12" min="1"
                                    name="card_expiration_month" placeholder="mês" required type="number">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input class="form-control" id="card_expiration_year" min="{{ date('Y') }}"
                                    name="card_expiration_year" placeholder="ano" required type="number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="card_cvv">Código de segurança</label>
                        <input class="form-control" id="card_cvv" name="card_cvv" required type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="card_name">Nome do dono do cartão <small>(nome que consta no cartão)</small></label>
                <input class="form-control" id="card_name" name="card_name" required type="text">
            </div>

            <div class="form-group installments"></div>

            <button class="btn btn-success btn-lg btn-block process-checkout" type="submit">Efetuar pagamento</button>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script>
        const sessionId = '{{ session()->get('pagseguro_session_id') }}';
        PagSeguroDirectPayment.setSessionId(sessionId);

    </script>
    <script>
        let amountTransaction = '{{ $total }}';
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand = document.querySelector('span.brand')

        cardNumber.addEventListener('keyup', function() {
            if (cardNumber.value.length >= 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function(res) {
                        console.log('getBrand:', 'success');
                        let imgFlag = `https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png`;
                        spanBrand.innerHTML = `<img src="${imgFlag}" alt="${res.brand.name}">`;
                        let cardBrand = document.getElementById('card_brand');
                        cardBrand.value = res.brand.name;
                        getInstallments(amountTransaction, res.brand.name);
                    },
                    error: function(err) {
                        console.log('getBrand:', 'error');
                    },
                    complete: function(res) {
                        console.log('getBrand:', 'complete');
                    },
                });
            }
        });

        let submitButton = document.querySelector('button.process-checkout');

        submitButton.addEventListener('click', function(event) {

            event.preventDefault();

            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.getElementById('card_number').value,
                brand: document.getElementById('card_brand').value,
                cvv: document.getElementById('card_cvv').value,
                expirationMonth: document.getElementById('card_expiration_month').value,
                expirationYear: document.getElementById('card_expiration_year').value,
                success: function(res) {
                    console.log('createCardToken:', 'success');
                    //console.log(res);
                    proccessPayment(res.card.token)
                },
                error: function(err) {
                    console.log('createCardToken:', err);
                },
                complete: function(res) {
                    console.log('createCardToken:', 'complete');
                },
            });
        });

        function proccessPayment(token) {
            let data = {
                card_token: token,
                hash: PagSeguroDirectPayment.getSenderHash(),
                card_name: document.getElementById('card_name').value,
                installment: document.getElementById('installment').value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('checkout.proccess') }}',
                data: data,
                dataType: 'json',
                success: function(res) {
                    console.log('proccessPayment:', 'success');
                    console.log(res);
                    toastr.success(res.data.message, 'Sucesso');
                    window.location.href = '{{ route('checkout.thanks') }}?orderReference=' + res.data.orderReference;
                },
                error: function(err) {
                    console.log('proccessPayment:', err);
                },
                complete: function(res) {
                    console.log('proccessPayment:', 'complete');
                },
            });
        }

        function getInstallments(amount, brand) {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 3,
                success: function(res) {
                    console.log('getInstallments:', 'success');
                    let selectInstallments = drawSelectInstallments(res.installments[brand]);
                    let divInstallments = document.querySelector('div.installments');
                    divInstallments.innerHTML = selectInstallments;
                },
                error: function(err) {
                    console.log('getInstallments:', 'error');
                },
                complete: function(res) {
                    console.log('getInstallments:', 'complete');
                },
            });
        }

        function drawSelectInstallments(installments) {
            let select = '<label for="installment">Opções de parcelamento:</label>';
            select += '<select id="installment" name="installment" class="form-control">';

            for (let l of installments) {
                select +=
                    `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de R$ ${l.installmentAmount} ${l.interestFree ? '(sem juros)' : `(total: R$ ${l.totalAmount})`}</option>`;
            }

            select += '</select>';
            return select;
        }

    </script>
@endsection
