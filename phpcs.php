<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()->in(__DIR__ . '/src');

$config = new Config();
$config->setRules([
    '@PSR12' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
]);
$config->setFinder($finder);

return $config;
