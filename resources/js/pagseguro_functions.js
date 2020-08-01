function proccessPayment(token, buttonTarget) {
    let data = {
        card_token: token,
        hash: PagSeguroDirectPayment.getSenderHash(),
        card_name: document.getElementById('card_name').value,
        installment: document.getElementById('installment').value,
        _token: csrf
    };

    $.ajax({
        type: 'POST',
        url: urlProccess,
        data: data,
        dataType: 'json',
        success: function (res) {
            console.log('proccessPayment:', 'success');
            console.log(res);
            toastr.success(res.data.message, 'Sucesso');
            window.location.href = `${urlThanks}?orderReference=${res.data.orderReference}`;
        },
        error: function (err) {
            console.log('proccessPayment:', err);
            buttonTarget.disabled = false;
            buttonTarget.textContent = 'Efetuar pagamento';
            let message = JSON.parse(err.responseText);
            showErrorMessage(message.data.message.error.message);
        },
        complete: function (res) {
            console.log('proccessPayment:', 'complete');
        },
    });
}

function getInstallments(amount, brand) {
    PagSeguroDirectPayment.getInstallments({
        amount: amount,
        brand: brand,
        maxInstallmentNoInterest: 3,
        success: function (res) {
            console.log('getInstallments:', 'success');
            let selectInstallments = drawSelectInstallments(res.installments[brand]);
            let divInstallments = document.querySelector('div.installments');
            divInstallments.innerHTML = selectInstallments;
        },
        error: function (err) {
            console.log('getInstallments:', 'error');
        },
        complete: function (res) {
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

function showErrorMessage(message) {
    toastr.error(message, 'Erro');
}

function errorMapPagSeguroJS(code) {
    switch (code) {
        case '10000':
            return 'Bandeira do cartão inválida.';
        case '10001':
            return 'Número do cartão com tamanho inválido.';
        case '10002':
        case '30405':
        case '30400':
            return 'Data de validade inválida.';
        case '10003':
            return 'Código de segurança inválido.';
        case '10004':
            return 'Código de segurança é obrigatório!';
        case '10006':
            return 'Tamanho do código de segurança inválido!';
        default:
            return 'Houve um erro na validação do seu cartão de crédito!';
    }
}
