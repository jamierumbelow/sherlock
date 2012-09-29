<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

interface Engine
{
	/**
	 * Render the content through the engine and return it as a string
	 *
	 * @var Sherlock\Asset $asset Asset instance
	 * @return string
	 **/
	public function render($asset);
}