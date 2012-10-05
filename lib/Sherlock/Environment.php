<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

use Sherlock\Asset;

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
	 * Where do we compile assets to?
	 *
	 * @var string
	 */
	public $compileDirectory = '';

	/**
	 * We map file extensions to engines... here's
	 * where we store the mappings
	 *
	 * @var array
	 */
	public $extensions = array();

	/**
	 * Constructor.
	 *
	 * @var string $rootDir Root directory
	 * @var string $compileDir Compile directory
	 **/
	public function __construct($rootDir = FALSE, $compileDir = FALSE)
	{
		$this->directories[] = ($rootDir) ?: getcwd();
		$this->compileDirectory = ($compileDir) ?: getcwd();
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
			throw new Exceptions\MissingFile($filename);
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
	 * Register a new extension to an engine
	 *
	 * @var string $ext The extension (without the period, ie. 'css')
	 * @var string/object $engine The engine instance / class name
	 **/
	public function register($ext, $engine)
	{
		if (!isset($this->extensions[$ext]))
		{
			$this->extensions[$ext] = array();
		}

		if (is_string($engine) && 
			class_exists($engine) && 
			in_array('Sherlock\Engine', class_implements($engine)))
		{
			$this->extensions[$ext][] = $engine;
		}
		elseif (is_object($engine) &&
				in_array('Sherlock\Engine', class_implements($engine)))
		{
			$this->extensions[$ext][] = get_class($engine);
		}
		else
		{
			throw new Exceptions\InvalidEngine($engine);
		}
	}

	/**
	 * Empty the extension/engine registry
	 **/
	public function emptyRegistry()
	{
		$this->extensions = array();
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