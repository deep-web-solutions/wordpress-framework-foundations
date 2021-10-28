# DWS WordPress Framework - Foundations

**Contributors:** Antonius Hegyes, Deep Web Solutions GmbH  
**Requires at least:** 5.5  
**Tested up to:** 5.7  
**Requires PHP:** 7.4  
**Stable tag:** 1.5.0  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  


## Description 

[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
[![PHP Syntax Errors](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/php-syntax-errors.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/php-syntax-errors.yml)
[![WordPress Coding Standards](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/wordpress-coding-standards.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/wordpress-coding-standards.yml)
[![Codeception Tests](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/codeception-tests.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-foundations/actions/workflows/codeception-tests.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/75fcacbb8919d442a664/maintainability)](https://codeclimate.com/github/deep-web-solutions/wordpress-framework-foundations/maintainability)

A set of related foundational classes to kick-start WordPress plugin development. This package contains many abstractions useful
for building a WordPress plugin.


## Documentation

Documentation for this module and the rest of the DWS WP Framework can be found [here](https://framework.deep-web-solutions.com/foundations-module/motivation-and-how-to-use).


## Installation

The package is designed to be installed via Composer. It may work as a stand-alone but that is not officially supported.
The package's name is `deep-web-solutions/wp-framework-foundations`.

If the package will be used outside a composer-based installation, e.g. inside a regular WP plugin, you should install
using the `--ignore-platform-reqs` option. If you don't do that, the bundled `DWS WordPress Framework - Bootstrapper` package
will only be able to perform checks for the WordPress version because composer will throw an error in case of an incompatible PHP version.


## Contributing 

Contributions both in the form of bug-reports and pull requests are more than welcome!


## Frequently Asked Questions 

- Will you support earlier versions of WordPress and PHP?

Unfortunately not. PHP 7.3 is close to EOL (March 2021), and we consider 7.4 to provide a few features that are absolutely amazing.
Moreover, WP 5.5 introduced a few new features that we really want to use as well, and we consider it to be one of the first versions
of WordPress to have packed a more-or-less mature version of Gutenberg.

If you're using older versions of either one, you should really consider upgrading at least for security reasons.

- Is this bug-free?

Hopefully yes, probably not. If you found any problems, please raise an issue on Github!


## Changelog 

### 1.5.0 (October 28th, 2021)
* Plugin component abstractions are now at the namespace root.
* Utilities sub-namespace was removed.
* More use of helpers from the Helpers module.
* More use of PHP7.4 features.

### 1.4.4 (September 29th, 2021)
* ChildTrait is now consistent with ParentTrait when checking for relations.

### 1.4.3 (August 19th, 2021)
* Changed the joining separator for hooks tags.

### 1.4.2 (April 23rd, 2021)
* Consolidated changelog.
* Documentation updates.
* Migrated from Travis CI to Github Actions.

### 1.4.1 (April 11th, 2021)
* Compatibility with Helpers 1.2.

### 1.3.1, 1.3.2, 1.4.0 (April 10th, 2021)
* Fixed a bug that caused only a maximum of 1 status extension trait to be executed.
* Updated composer.json to support any version of the PSR packages.
* Some action extension traits are now integration traits.

### 1.3.0 (April 9th, 2021)
* Updated development tools.
* Renamed the StoreableInterface to StorableInterface.
* Renamed all instances of 'storeable' with 'storable'.

### 1.2.1 (April 3rd, 2021)
* Added a conditional children setup trait.

### 1.2.0 (April 3rd, 2021)
* Enhanced the Actions traits with the piping functionality from the Core module.

### 1.1.1 (April 2nd, 2021)
* Updated version constant.

### 1.1.0 (April 2nd, 2021)
* Renamed some traits for consistency with the rest of the modules.
* Updated Helpers module.
* Added a new initialization extension trait for hierarchical objects that use a DI container.

### 1.0.0 (April 1st, 2021) 
* First official release.