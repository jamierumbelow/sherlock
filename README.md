Sherlock [![Build Status](https://secure.travis-ci.org/jamierumbelow/sherlock.png?branch=master)](http://travis-ci.org/jamierumbelow/sherlock)
========

Sherlock provides PHP asset pipelining so simple, it's elementary. It's inspired by Sprockets, django-pipeline and Assetic, and aims to create a simpler and more approachable asset pipeline for PHP developers.

## Synopsis

```php
$assets = new Sherlock\Environment('app/assets');
echo $assets['some_file.css'];
echo $assets['application.js'];

$bundle = new Sherlock\Bundle(array( 'stylesheets/some_file.css', 'stylesheets/another.css' ));
$bundle->compile('application.js');

$server = new Sherlock\Server($assets);
```

## Philosophy / Design Decisions

* **Simplicity.** Simply create an instance of `Sherlock\Environment` and go. Sherlock should work with any framework in a matter of moments.
* **Usefulness.** Assets should be compilable, concatanatable and renderable very easily. No messing around with obscure internal classes, and certainly _no_ directive processors / manifest files. 
* **Speed.** Assets should be served up, compiled and concatenated blazingly quickly. Extensive caching should happen behind the scenes to make it happen.
* **Extensibility.** Plug in templating engines provide support for any preprocessor, such as Sass, CoffeeScript or Lex.
* **Great Documentation.** Sherlock should be easy to understand and work with. The codebase should be fully tested and clean.

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