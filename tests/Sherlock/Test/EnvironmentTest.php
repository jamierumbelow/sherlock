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
	public function testDefaultDirsAreWorkingDir()
	{
		$env = new Environment();
		$this->assertEquals(getcwd(), $env->directories[0]);

		$env = new Environment('blah');
		$this->assertEquals(getcwd(), $env->compileDirectory);
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

	public function testMissingPathThrowsException()
	{
		$this->setExpectedException('Sherlock\Exceptions\MissingFile');

		$env = new Environment();
		$env->find('missing_file.css');
	}

	public function testFindReturnsAssetInstance()
	{
		$env = new Environment('tests/support/assets');
		$this->assertEquals('Sherlock\Asset', get_class($env->find('test.css')));
	}

	public function testRegister()
	{
		$env = new Environment();
		$env->extensions = array();

		$env->register('css', 'Sherlock\Engines\CSS');
		$env->register('js', new \Sherlock\Engines\JS());

		$this->assertTrue(in_array('Sherlock\Engines\CSS', $env->extensions['css']));
		$this->assertTrue(in_array('Sherlock\Engines\JS', $env->extensions['js']));
	}

	public function testRegisterWithIncorrectEngine()
	{
		$this->setExpectedException('Sherlock\Exceptions\InvalidEngine');
		$env = new Environment();

		$env->register('weird', 'Sherlock\Engines\WeirdEngine');
	}

	public function testEmptyRegistry()
	{
		$env = new Environment();
		$env->extensions = array( 'test' );

		$env->emptyRegistry();

		$this->assertEmpty($env->extensions);
	}

	public function testResolveLocatesFilePathWithinDirectoriesWithWeirdSlashes()
	{
		$env = new Environment('tests/support/assets');
		$env2 = new Environment('tests/support/assets/');

		$this->assertFalse($env->resolve('missing_file.css'));
		$this->assertEquals('tests/support/assets/test.css', $env->resolve('test.css'));
		$this->assertEquals('tests/support/assets/test.css', $env2->resolve('test.css'));
		$this->assertEquals('tests/support/assets/test.css', $env->resolve('/test.css'));
		$this->assertEquals('tests/support/assets/test.css', $env2->resolve('/test.css'));
	}	
}