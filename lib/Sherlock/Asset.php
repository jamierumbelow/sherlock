<?php
/**
 * Sherlock - Asset pipelining so simple, it's elementary
 *
 * @link https://github.com/jamierumbelow/sherlock
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

namespace Sherlock;

/**
 * Represents an asset, both pointing to its location on the
 * filesystem (if it has one) and storing its contents (if it has any)
 **/
class Asset
{
	/**
	 * The name of the file, either automatically
	 * generated or representing a real file
	 *
	 * @var string
	 **/
	public $filename = '';

	/**
	 * The file extension
	 *
	 * @var string
	 **/
	public $extension = '';

	/**
	 * The asset's content
	 *
	 * @var string
	 */
	public $content = '';

	/**
	 * The asset's `Environment` instance
	 *
	 * @var Sherlock\Environment
	 */
	public $environment;

	/**
	 * Constructor.
	 *
	 * @var string $filename Asset file name
	 * @var Sherlock\Environment $environment Environment instance in which this asset resides
	 **/
	public function __construct($filename = FALSE, &$environment = FALSE)
	{
		$this->filename = $filename;
		$this->environment = $environment;
		$this->extension = pathinfo($filename, PATHINFO_EXTENSION);
	}

	/**
	 * Does the asset exist on the filesystem?
	 *
	 * @return boolean
	 */
	public function exists()
	{
		return (bool)$this->environment->resolve($this->filename);
	}

	/**
	 * Refresh the content from the filesystem
	 **/
	public function refresh()
	{
		$path = $this->environment->resolve($this->filename);
		$this->content = file_get_contents($path);
	}

	/**
	 * Process this asset through the engine pipeline
	 */
	public function process()
	{
		if (isset($this->environment->extensions[$this->extension]))
		{
			foreach ($this->environment->extensions[$this->extension] as $engine)
			{
				$engobj = new $engine();
				$this->content = $engobj->render($this);
				unset($engobj);
			}
		}
	}

	/**
	 * We're requesting the asset as a string. This means we're
	 * trying to echo it out or store it somewhere. Fetch it if we
	 * need to, process it and return it
	 *
	 * @return string
	 **/
	public function __toString()
	{
		if (empty($this->content))
		{
			$this->refresh();
			$this->process();
		}

		return $this->content;
	}
}