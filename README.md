Sherlock [![Build Status](https://secure.travis-ci.org/jamierumbelow/sherlock.png?branch=master)](http://travis-ci.org/jamierumbelow/sherlock)
========

Sherlock provides PHP asset pipelining so simple, it's elementary. It's inspired by Sprockets, django-pipeline and Assetic, and aims to create a simpler and more approachable asset pipeline for PHP developers.

## Synopsis

```php
$assets = new Sherlock\Environment('app/assets', 'public/assets');
echo $assets['some_file.css'];
echo $assets['application.js'];

$bundle = new Sherlock\Bundle(array( 'stylesheets/some_file.css', 'stylesheets/another.css' ));
$bundle->compile('application.css');

$server = new Sherlock\Server($assets);
```

## Installation

Use Composer, obviously! Get it (if you haven't already):

	$ curl -s https://getcomposer.org/installer | php

Create/edit **composer.json**:

	{
		"require": {
			"jamierumbelow/sherlock": "*"
		}
	}

Install:

	$ php composer.phar install

...and autoload!

	require_once 'path/to/vendor/autoload.php';

## Getting Started

We start a new pipeline by creating an instance of `Sherlock\Environment`. Its constructor takes two arguments, a root directory and a compile directory:

	$assets = new Sherlock\Environment('app/assets', 'public/assets');

Both will default to the working directory. We can then set up a new bundle:

	$bundle = $assets->bundle('stylesheets/*');

Concatenate and compile the bundle...

	$bundle->compile('application.css');

..and load our asset in our template:

	<link rel="stylesheet" href="<?= $assets->path('application.css') ?>" />

This will render a cache-busted, timestamped hashed path to the file, relative to the compile directory you set up in the environment:

	<link rel="stylesheet" href="/public/application-2469ee51d4bae4f90b8d1770ef642633.css" />

## Extensions and Paths

Sherlock will make a few assumptions about where your files reside and what you'd like to do with them. Most engines, such as CoffeeScript and SCSS - as well as regular JS, CSS and images - will attach to file extensions and have a default search path.

Everything is based off the root path you pass when instantiating `Sherlock\Environment`:

```php
$assets = new Sherlock\Environment('app/assets');
```

Any requests will then be routed using `app/assets` as its base. If we request a regular CSS file:

```php
echo $assets['some_file.css'];
```

Sherlock will try to find it in the `stylesheets` or `css` directories, as well as in the root:

	app/assets/stylesheets/some_file.css
	app/assets/css/some_file.css
	app/assets/some_file.css

Every file is routed through its appropriate engine. For `.css` and `.js` files, this does nothing. If we request a file with a different extension, such as `.coffee`, assuming our custom engine is set up--in the case of CoffeeScript, it's always available--Sherlock will parse the file and return its processed form.

## Concatenation

One of the main purposes of an asset pipeline is asset concatenation. This is really important in a production environment because it reduces the load on your server hugely and speed up the page load for your users.

Sherlock supports concatenation with the `Sherlock\Bundle` class. Instantiate a new object with the `Environment` and an array of files. Then, calling `compile()` is all that's necessary:

	$bundle = new Sherlock\Bundle($assets, array( 'stylesheets/some_file.css', 'stylesheets/another.css' ));

	$bundle->compile('application.css');

You can also get an instance directly with `Environment#bundle`:

	$bundle = $assets->bundle(array( 'stylesheets/some_file.css' ));
	$bundle->compile('application.css');

These files are `Asset` objects, so they're parsed through any engines registered on the current environment.

## Philosophy / Design Decisions

* **Simplicity.** Simply create an instance of `Sherlock\Environment` and go. Sherlock should work with any framework in a matter of moments.
* **Usefulness.** Assets should be compilable, concatanatable and renderable very easily. No messing around with obscure internal classes, and certainly _no_ directive processors / manifest files. 
* **Speed.** Assets should be served up, compiled and concatenated blazingly quickly. Extensive caching should happen behind the scenes to make it happen.
* **Extensibility.** Plug in templating engines provide support for any preprocessor, such as Sass, CoffeeScript or Lex.
* **Great Documentation.** Sherlock should be easy to understand and work with. The codebase should be fully tested and clean.
