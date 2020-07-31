<?php

namespace App\Payment\PagSeguro;

class CreditCard
{
    private $cart;
    private $user;
    private $cardInfo;
    private $reference;

    public function __construct($cart, $user, $cardInfo, $reference)
    {
        $this->cart = $cart;
        $this->user = $user;
        $this->cardInfo = $cardInfo;
        $this->reference = $reference;
    }

    public function doPayment()
    {
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL'));
        $creditCard->setReference($this->reference);
        $creditCard->setCurrency("BRL");

        foreach ($this->cart as $key => $c) {
            $creditCard->addItems()->withParameters(
                ++$key,
                $c['name'],
                $c['amount'],
                $c['price']
            );
        }

        $email = env('PAGSEGURO_ENV') == 'sandbox' ? 'test@sandbox.pagseguro.com.br' : $this->user->email;

        $creditCard->setSender()->setName($this->user->name);
        $creditCard->setSender()->setEmail($email);

        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        // $creditCard->setSender()->setDocument()->withParameters(
        //     'CNPJ',
        //     '34948617000155'
        // );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '67513199086'
        );

        $creditCard->setSender()->setHash($this->cardInfo['hash']);

        $creditCard->setSender()->setIp('127.0.0.0');

        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        //$creditCard->setShipping()->setCost()->withParameters(15.00);
        //$creditCard->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::SEDEX);

        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        $creditCard->setToken($this->cardInfo['card_token']);
        list($quantity, $installmentAmount) = explode('|', $this->cardInfo['installment']);
        $installmentAmount = number_format($installmentAmount, 2, '.', '');
        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount, 3);
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName($this->cardInfo['card_name']); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '67513199086'
        );

        $creditCard->setMode('DEFAULT');

        //$creditCard->setRedirectUrl("http://www.lojamodelo.com.br");
        //$creditCard->setNotificationUrl("http://www.lojamodelo.com.br/nofitication");


        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        return $result;
    }
}
