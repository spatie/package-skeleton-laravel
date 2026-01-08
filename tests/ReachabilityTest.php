<?php

use Illuminate\Support\Facades\Config;
use Paychangu\Laravel\Paychangu;

beforeEach(function () {
    Config::set('paychangu.api_base_url', 'https://api.paychangu.com/');
    Config::set('paychangu.private_key', 'test_secret_key');
});

it('can reach mobile money operators endpoint', function () {
    $paychangu = new Paychangu;
    try {
        $paychangu->mobile_money_operators();
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        checkReachability($e);
    }
});

it('can reach mobile money charge endpoint', function () {
    $paychangu = new Paychangu;
    try {
        $paychangu->create_mobile_money_payment([
            'mobile_money_operator_ref_id' => '1',
            'mobile' => '0999999999',
            'amount' => 100,
            'charge_id' => '123',
        ]);
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        checkReachability($e);
    }
});

it('can reach mobile money verify endpoint', function () {
    $paychangu = new Paychangu;
    try {
        $paychangu->verify_mobile_money_payment('test_id');
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        checkReachability($e);
    }
});

it('can reach checkout create endpoint', function () {
    $paychangu = new Paychangu;
    try {
        $paychangu->create_checkout_link([
            'amount' => 1000,
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        checkReachability($e);
    }
});

it('can reach checkout verify endpoint', function () {
    $paychangu = new Paychangu;
    try {
        $paychangu->verify_checkout('test_ref');
        expect(true)->toBeTrue();
    } catch (\Exception $e) {
        checkReachability($e);
    }
});

function checkReachability(\Exception $e)
{
    if (str_contains($e->getMessage(), 'Could not resolve host') || str_contains($e->getMessage(), 'Connection refused')) {
        test()->fail('Could not reach API host: '.$e->getMessage());
    } else {
        // 401, 404, 422, 500 etc means we reached the server
        expect(true)->toBeTrue();
    }
}
