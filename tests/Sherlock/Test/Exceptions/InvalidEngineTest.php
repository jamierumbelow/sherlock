<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Test\Exceptions;
use Sherlock\Exceptions\InvalidEngine;

class InvalidEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        Sherlock\Exceptions\InvalidEngine
     * @expectedExceptionMessage Specified engine 'Sherlock\Engines\WeirdEngine' was invalid
     */
	public function testMessageIsFormattedWithFileName()
	{
		throw new InvalidEngine('Sherlock\Engines\WeirdEngine');
	}
}