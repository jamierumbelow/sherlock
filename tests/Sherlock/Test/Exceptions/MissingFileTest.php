<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Test\Exceptions;
use Sherlock\Exceptions\MissingFile;

class MissingFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        Sherlock\Exceptions\MissingFile
     * @expectedExceptionMessage Couldn't find file 'missing_file.css'
     */
	public function testMessageIsFormattedWithFileName()
	{
		throw new MissingFile('missing_file.css');
	}
}