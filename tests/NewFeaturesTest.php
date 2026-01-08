<?php

use Paychangu\Laravel\Paychangu;
use Paychangu\Laravel\Resources\Banks\Card;
use Paychangu\Laravel\Resources\Banks\DirectCharge;
use Paychangu\Laravel\Resources\BillPayments\Airtime;
use Paychangu\Laravel\Resources\BillPayments\Bill;
use Paychangu\Laravel\Resources\Payouts\BankPayout;
use Paychangu\Laravel\Resources\Payouts\MobileMoneyPayout;

it('can access direct charge resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->direct_charge();
    expect($resource)->toBeInstanceOf(DirectCharge::class);
});

it('can access card resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->card();
    expect($resource)->toBeInstanceOf(Card::class);
});

it('can access mobile money payout resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->mobile_money_payout();
    expect($resource)->toBeInstanceOf(MobileMoneyPayout::class);
});

it('can access bank payout resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->bank_payout();
    expect($resource)->toBeInstanceOf(BankPayout::class);
});

it('can access bill resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->bill();
    expect($resource)->toBeInstanceOf(Bill::class);
});

it('can access airtime resource', function () {
    $paychangu = new Paychangu();
    $resource = $paychangu->airtime();
    expect($resource)->toBeInstanceOf(Airtime::class);
});

it('can access direct charge helper methods', function () {
    $paychangu = new Paychangu();
    expect(method_exists($paychangu, 'create_direct_charge_payment'))->toBeTrue();
    expect(method_exists($paychangu, 'get_direct_charge_details'))->toBeTrue();
});

it('can access card helper methods', function () {
    $paychangu = new Paychangu();
    expect(method_exists($paychangu, 'create_card_payment'))->toBeTrue();
    expect(method_exists($paychangu, 'verify_card_payment'))->toBeTrue();
    expect(method_exists($paychangu, 'refund_card_payment'))->toBeTrue();
});

it('can access payout helper methods', function () {
    $paychangu = new Paychangu();
    expect(method_exists($paychangu, 'mobile_money_payout_operators'))->toBeTrue();
    expect(method_exists($paychangu, 'create_mobile_money_payout'))->toBeTrue();
    expect(method_exists($paychangu, 'get_supported_banks_for_payout'))->toBeTrue();
    expect(method_exists($paychangu, 'create_bank_payout'))->toBeTrue();
});

it('can access bill helper methods', function () {
    $paychangu = new Paychangu();
    expect(method_exists($paychangu, 'get_billers'))->toBeTrue();
    expect(method_exists($paychangu, 'pay_bill'))->toBeTrue();
    expect(method_exists($paychangu, 'buy_airtime'))->toBeTrue();
});
