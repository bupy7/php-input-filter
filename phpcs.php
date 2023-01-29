<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/test');

$config = new Config();
$config->setRules([
    '@PSR12' => true,
]);
$config->setFinder($finder);

return $config;
