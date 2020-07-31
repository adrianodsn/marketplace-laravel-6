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
        const sessionId = '{{session()->get('pagseguro_session_id')}}';
        const urlProccess = '{{route('checkout.proccess')}}';
        const urlThanks = '{{route('checkout.thanks')}}';
        const amountTransaction = '{{$total}}';
        const csrf = '{{csrf_token()}}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>
    <script src="{{asset('js/pagseguro_functions.js')}}"></script>
    <script src="{{asset('js/pagseguro_events.js')}}"></script>
@endsection
