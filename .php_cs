<?php


$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder);

return $config;

