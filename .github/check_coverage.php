#!/usr/bin/env php
<?php

if (false === isset($argv[1])) {
    printf('Missing argument #1 which must be a valid path to PHPUnit XML file with coverage data.' . PHP_EOL);
    exit(1);
}

$path = '/' === substr($argv[1], 0, 1) ? $argv[1] : getcwd() . DIRECTORY_SEPARATOR . $argv[1];

if (false === file_exists($path)) {
    printf('File "%s" not found.' . PHP_EOL, $path);
    exit(1);
}

if (false === is_readable($path)) {
    printf('Unable to read file "%s".' . PHP_EOL, $path);
    exit(1);
}

$xml = new SimpleXMLElement(file_get_contents($path));

$values = [
    'coveredconditionals' => 0,
    'coveredstatements' => 0,
    'coveredmethods' => 0,
    'conditionals' => 0,
    'statements' => 0,
    'methods' => 0,
];

foreach (array_keys($values) as $name) {
    if (false === $attr = current($xml->xpath('//project/metrics/@' . $name))) {
        printf('Invalid Xpath "//project/metrics/@%s".' . PHP_EOL, $name);
        exit(1);
    }

    $values[$name] = (int) current($attr)[$name];
}

// TPC = (coveredconditionals + coveredstatements + coveredmethods) / (conditionals + statements + methods)
$divisor = $values['coveredconditionals'] + $values['coveredstatements'] + $values['coveredmethods'];
$dividend = $values['conditionals'] + $values['statements'] + $values['methods'];
$coverage = 0 < $dividend ? round(($divisor / $dividend) * 100, 2) : 100;

$expected = (int) ($argv[2] ?? 90);

if ($coverage < $expected) {
    printf(
        'Code coverage of %s%% is less then the expected value of %s%%.' . PHP_EOL,
        number_format($coverage, 2),
        number_format($expected, 2)
    );
    exit(1);
}

printf(
    'Code coverage of %s%% is greater then or equal the expected value of %s%%.' . PHP_EOL,
    number_format($coverage, 2),
    number_format($expected, 2)
);
exit(0);
