<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

use Sherlock\Exceptions\MissingFile;

class Environment implements \ArrayAccess
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

	/**
	 * Fetch a file from the filesystem, compiling
	 * or whathaveyou if needs be
	 *
	 * @var string $filename The path + name of the file
	 * @return Sherlock\Asset The asset object
	 **/
	public function find($filename)
	{
		throw new MissingFile($filename);
	}

	/**
	 * ArrayAccess implementation
	 */
	public function offsetGet($offset)
	{
		return $this->find($offset);
	}

	public function offsetExists($offset) { }
	public function offsetSet($offset, $value) { }
	public function offsetUnset($offset) { }
}