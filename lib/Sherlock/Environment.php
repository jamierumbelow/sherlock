<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

class Environment
{
	/**
	 * The Sherlock virtual load path; a list of
	 * directories in which to find assets
	 *
	 * @var array
	 */
	public $directories = array();

	/**
	 * Constructor.
	 *
	 * @var string $root_dir Root directory
	 **/
	public function __construct($root_dir = FALSE)
	{
		if (!$root_dir)
		{
			$root_dir = getcwd();
		}

		$this->directories[] = $root_dir;
	}
}