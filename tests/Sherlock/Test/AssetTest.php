<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Test;

use Sherlock\Environment;
use Sherlock\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructorStoresNameAndEnv()
	{
		$env = new Environment();
		$asset = new Asset('test.css', $env);

		$this->assertEquals('test.css', $asset->filename);
		$this->assertEquals($env, $asset->environment);
		$this->assertEquals('css', $asset->extension);
	}

	public function testExists()
	{
		$asset = new Asset('test.css', new Environment('tests/support/assets'));
		$this->assertEquals(TRUE, $asset->exists());
	}

	public function testToString()
	{
		$asset = new Asset('', new Environment());
		$content = 'Test Here';
		$asset->content = $content;

		$this->assertEquals($content, $asset->__toString());

		$asset = new Asset('test.css', new Environment('tests/support/assets'));
		$this->assertEquals(file_get_contents('tests/support/assets/test.css'), $asset->__toString());
	}

	public function testRefresh()
	{
		$asset = new Asset('test.css', new Environment('tests/support/assets'));
		$asset->content = '';

		$asset->refresh();

		$this->assertEquals(file_get_contents('tests/support/assets/test.css'), $asset->content);
	}

	public function testProcess()
	{
		$env = new Environment('tests/support/assets');
		$env->register('test', 'Sherlock\Test\TestEngine');

		$asset = new Asset('', $env);
		$asset->extension = 'test';
		$asset->content = 'Hello World';

		$asset->process();
		
		$this->assertEquals('---TEST---Hello World---TEST---', $asset->content);
	}
}