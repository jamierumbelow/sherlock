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
	public $filename;

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
}