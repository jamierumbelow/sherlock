<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Exceptions;

class MissingFile extends Exception
{
	public function __construct($filename)
	{
		parent::__construct("Couldn't find file '$filename'");
	}
}