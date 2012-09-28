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

	public function testImplementsArrayAccess()
	{
		$env = new Environment();
		$this->assertTrue(in_array('ArrayAccess', class_implements($env)), 'Sherlock\Environment does not implement ArrayAccess');
	}

	public function testOffsetGetCallsFind()
	{
		$env = $this->getMock('Sherlock\Environment', array( 'find' ));
		$env->expects($this->once())
			->method('find')
			->with($this->equalTo('stylesheet.css'))
			->will($this->returnValue(TRUE));

		$this->assertTrue($env['stylesheet.css']);
	}
}