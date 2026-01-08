<?php

use Mzati\Paychangu\Facades\Paychangu;
use Mzati\Paychangu\Resources\Checkout;
use Mzati\Paychangu\Resources\MobileMoney\MobileMoney;
use Mzati\Paychangu\Resources\Verification;

it('can resolve paychangu facade', function () {
    expect(Paychangu::getFacadeRoot())->toBeInstanceOf(\Mzati\Paychangu\Paychangu::class);
});

it('can access checkout resource', function () {
    $paychangu = app('paychangu');
    expect($paychangu->checkout())->toBeInstanceOf(Checkout::class);
});

it('can access mobile money resource', function () {
    $paychangu = app('paychangu');
    expect($paychangu->mobile_money())->toBeInstanceOf(MobileMoney::class);
});

it('can access verification resource', function () {
    $paychangu = app('paychangu');
    expect($paychangu->verification())->toBeInstanceOf(Verification::class);
});

// Checkout Tests
it('can access create_checkout_link proxy method', function () {
    $paychangu = app('paychangu');
    try {
        $paychangu->create_checkout_link([]);
    } catch (InvalidArgumentException $e) {
        expect($e->getMessage())->toContain('Missing required field');
    }
});

it('can access verify_checkout proxy method', function () {
    $paychangu = app('paychangu');
    try {
        $paychangu->verify_checkout('');
    } catch (InvalidArgumentException $e) {
        expect($e->getMessage())->toBe('Transaction reference cannot be empty.');
    }
});

// Mobile Money Tests
it('can access create_mobile_money_payment proxy method', function () {
    $paychangu = app('paychangu');
    try {
        $paychangu->create_mobile_money_payment([]);
    } catch (InvalidArgumentException $e) {
        expect($e->getMessage())->toContain('Missing required field');
    }
});

it('can access verify_mobile_money_payment proxy method', function () {
    $paychangu = app('paychangu');
    try {
        $paychangu->verify_mobile_money_payment('');
    } catch (InvalidArgumentException $e) {
        expect($e->getMessage())->toBe('Charge ID cannot be empty.');
    }
});

it('can access get_mobile_money_payment_details proxy method', function () {
    $paychangu = app('paychangu');
    try {
        $paychangu->get_mobile_money_payment_details('');
    } catch (InvalidArgumentException $e) {
        expect($e->getMessage())->toBe('Charge ID cannot be empty.');
    }
});
