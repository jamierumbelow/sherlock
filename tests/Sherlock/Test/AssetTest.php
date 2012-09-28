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
	public function testConstructorStoresName()
	{
		$asset = new Asset('test.css', new Environment());

		$this->assertEquals('test.css', $asset->filename);
	}

	public function testExists()
	{
		$asset = new Asset('test.css', new Environment('tests/support/assets'));
		$this->assertEquals(TRUE, $asset->exists());
	}
}