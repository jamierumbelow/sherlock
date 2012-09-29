<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock\Test;
use Sherlock\Engine;

class TestEngine implements Engine
{
	public function render($asset)
	{
		return '---TEST---' . $asset->content . '---TEST---';
	}
}