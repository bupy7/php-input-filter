<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/test');

$config = new Config();
$config->setRules([
    '@PER-CS' => true,
    'cast_spaces' => [
        'space' => 'none',
    ],
    'single_line_empty_body' => false,
    'trailing_comma_in_multiline' => [
        'after_heredoc' => true,
        'elements' => ['arrays'],
    ],
]);
$config->setFinder($finder);

return $config;
