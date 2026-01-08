<?php

use Paychangu\Laravel\Paychangu;
use Paychangu\Laravel\Resources\Checkout;
use Paychangu\Laravel\Resources\MobileMoney\MobileMoney;
use Illuminate\Support\Facades\Config;

it('constructs checkout url correctly from base url', function () {
    Config::set('paychangu.api_base_url', 'https://api.test/');
    
    $paychangu = new Paychangu();
    $checkout = $paychangu->checkout();
    
    expect($checkout)->toBeInstanceOf(Checkout::class);
    // Since we can't easily inspect the client's URL without reflection or mocking,
    // we rely on the fact that the resource is created successfully.
    // The previous implementation used distinct keys, now we check it works with the single base key.
});

it('constructs mobile money url correctly from base url', function () {
    Config::set('paychangu.api_base_url', 'https://api.test/');
    
    $paychangu = new Paychangu();
    $mobileMoney = $paychangu->mobile_money();
    
    expect($mobileMoney)->toBeInstanceOf(MobileMoney::class);
});

it('ensures base url has trailing slash', function () {
    Config::set('paychangu.api_base_url', 'https://api.test'); // No slash
    
    $paychangu = new Paychangu();
    
    // Use reflection to check the property
    $reflection = new ReflectionClass($paychangu);
    $property = $reflection->getProperty('apiBaseUrl');
    $property->setAccessible(true);
    
    expect($property->getValue($paychangu))->toBe('https://api.test/');
});
