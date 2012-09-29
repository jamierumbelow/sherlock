<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Engines;
use Sherlock\Engine;

class JS implements Engine
{
	/**
	 * Don't do anything to JS files
	 */
	public function render($asset) { return $asset->content; }
}