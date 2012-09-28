<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

$loader = include(__DIR__ . '/../vendor/autoload.php');
$loader->add('Sherlock\Test', __DIR__);