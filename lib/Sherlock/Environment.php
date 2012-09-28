<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

use Sherlock\Asset;
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
	 * Search for a file on the filesystem and create a new
	 * wrapper instance to represent it
	 *
	 * @var string $filename The path + name of the file
	 * @return Sherlock\Asset The asset object
	 **/
	public function find($filename)
	{
		$asset = new Asset($filename, $this);

		if (!$asset->exists())
		{
			throw new MissingFile($filename);
		}
		else
		{
			return $asset;
		}
	}

	/**
	 * Given the name of a file, resolve the filename and return
	 * the resolved path if it exists and FALSE if it doesn't
	 *
	 * @return FALSE or string
	 */
	public function resolve($filename)
	{
		foreach ($this->directories as $directory)
		{
			$path = (substr($directory, strlen($directory)-1) == '/') ? 
					$directory :
					$directory . '/';
			$path .= (substr($filename, 0, 1) == '/') ? 
					substr($filename, 1) :
					$filename;

			if (file_exists($path))
			{
				return $path;
			}
		}

		return FALSE;
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