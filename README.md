# DWS WordPress Framework - Foundations

**Contributors:** Antonius Hegyes, Deep Web Solutions GmbH  
**Requires at least:** 5.5  
**Tested up to:** 5.7  
**Requires PHP:** 7.4  
**Stable tag:** 1.2.0  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  


## Description 

[![Build Status](https://travis-ci.com/deep-web-solutions/wordpress-framework-foundations.svg?branch=master)](https://travis-ci.com/deep-web-solutions/wordpress-framework-foundations)
[![Maintainability](https://api.codeclimate.com/v1/badges/75fcacbb8919d442a664/maintainability)](https://codeclimate.com/github/deep-web-solutions/wordpress-framework-foundations/maintainability)

A set of related foundational classes to kick-start WordPress plugin development. Documentation can be found at https://docs.deep-web-solutions.com/


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