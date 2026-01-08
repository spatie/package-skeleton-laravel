<?php

use Mzati\Paychangu\Facades\Paychangu;
use Mzati\Paychangu\Resources\Payment;
use Mzati\Paychangu\Resources\Transaction;

it('can resolve paychangu facade', function () {
    expect(Paychangu::getFacadeRoot())->toBeInstanceOf(\Mzati\Paychangu\Paychangu::class);
});

it('can access payments resource', function () {
    $paychangu = app('paychangu');
    expect($paychangu->payments())->toBeInstanceOf(Payment::class);
});

it('can access transactions resource', function () {
    $paychangu = app('paychangu');
    expect($paychangu->transactions())->toBeInstanceOf(Transaction::class);
});
