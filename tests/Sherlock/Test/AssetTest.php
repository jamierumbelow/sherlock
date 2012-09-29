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
	}

	public function testExists()
	{
		$asset = new Asset('test.css', new Environment('tests/support/assets'));
		$this->assertEquals(TRUE, $asset->exists());
	}
}