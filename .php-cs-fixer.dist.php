<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use Worksome\CodingStyle\PhpCsFixerConfig;

require __DIR__.'/vendor/autoload.php';

$finder = Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->in(__DIR__.'/config');

return PhpCsFixerConfig::make()
    ->setFinder($finder)
    ->setRules([
        '@worksome' => true,
        '@worksome:risky' => true,
    ])
    ->setRiskyAllowed(true);
