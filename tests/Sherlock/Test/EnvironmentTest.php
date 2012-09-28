<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Test;
use Sherlock\Environment;

class TestEnvironment extends \PHPUnit_Framework_TestCase
{
	public function testDefaultDirIsWorkingDir()
	{
		$env = new Environment();
		$this->assertEquals(getcwd(), $env->directories[0]);
	}
}