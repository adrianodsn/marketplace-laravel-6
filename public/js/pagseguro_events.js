let cardNumber = document.querySelector('input[name=card_number]');
let spanBrand = document.querySelector('span.brand');

cardNumber.addEventListener('keyup', function () {
    if (cardNumber.value.length >= 6) {
        PagSeguroDirectPayment.getBrand({
            cardBin: cardNumber.value.substr(0, 6),
            success: function (res) {
                console.log('getBrand:', 'success');
                let imgFlag = `https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png`;
                spanBrand.innerHTML = `<img src="${imgFlag}" alt="${res.brand.name}">`;
                let cardBrand = document.getElementById('card_brand');
                cardBrand.value = res.brand.name;
                getInstallments(amountTransaction, res.brand.name);
            },
            error: function (err) {
                console.log('getBrand:', 'error');
            },
            complete: function (res) {
                console.log('getBrand:', 'complete');
            },
        });
    }
});

let submitButton = document.querySelector('button.process-checkout');

submitButton.addEventListener('click', function (event) {

    event.preventDefault();

    PagSeguroDirectPayment.createCardToken({
        cardNumber: document.getElementById('card_number').value,
        brand: document.getElementById('card_brand').value,
        cvv: document.getElementById('card_cvv').value,
        expirationMonth: document.getElementById('card_expiration_month').value,
        expirationYear: document.getElementById('card_expiration_year').value,
        success: function (res) {
            console.log('createCardToken:', 'success');
            //console.log(res);
            proccessPayment(res.card.token)
        },
        error: function (err) {
            console.log('createCardToken:', err);
        },
        complete: function (res) {
            console.log('createCardToken:', 'complete');
        },
    });
});
