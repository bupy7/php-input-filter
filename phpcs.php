<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()->in(__DIR__ . '/src');

return Config::create()
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'strict_param' => true,
    ])
    ->setFinder($finder);
