Sherlock
========

Sherlock provides PHP asset pipelining so simple, it's elementary. It's inspired by Sprockets, django-pipeline and Assetic, and aims to create a simpler and more approachable asset pipeline for PHP developers.

## Philosophy / Design Decisions

* **Simplicity.** Simply create an instance of `Sherlock\Environment` and go. Sherlock should work with any framework in a matter of moments.
* **Usefulness.** Assets should be compilable, concatanatable and renderable very easily. No messing around with obscure internal classes, and certainly _no_ directive processors / manifest files. 
* **Speed.** Assets should be served up, compiled and concatenated blazingly quickly
* **Extensibility.** Plug in templating engines provide support for any preprocessor, such as Sass, CoffeeScript or Lex.
* **Great Documentation.** Sherlock should be easy to understand and work with. The codebase should be fully tested and clean.