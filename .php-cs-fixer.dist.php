<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests']);

$config = new PhpCsFixer\Config();
return $config->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'declare_strict_types' => true,
        'blank_line_after_opening_tag' => true,
        'single_quote' => true,
    ])->setFinder($finder);
