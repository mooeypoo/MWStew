[![Build Status](https://travis-ci.org/mooeypoo/MWStew.svg?branch=master)](https://travis-ci.org/mooeypoo/MWStew)
[![Code Climate](https://codeclimate.com/github/mooeypoo/MWStew/badges/gpa.svg)](https://codeclimate.com/github/mooeypoo/MWStew)

[![GitHub license](https://img.shields.io/badge/license-GPLv2-blue.svg?style=plastic)](https://raw.githubusercontent.com/mooeypoo/MWStew/master/LICENSE)

# MWStew: MediaWiki Extension Boilerplate Maker.

A web interface to create boilerplate extension for MediaWiki development.

## Live site
This tool is running on Wikimedia's Tool Labs at http://tools.wmflabs.org/mwstew/

## Development
This tool is fairly stable, but is currently going through QA and testing, and is continously developed. Please report any bugs you encounter!

**Feel free to contribute!**

## Install
If you want to use this tool, make sure to:

1. Clone the repo
2. Run `composer install`
3. Run `npm install`
4. Run `grunt build`
5. Make sure `/temp` and `/cache` are both writable by the web server.

* See [MWStew-CLI](https://github.com/mooeypoo/MWStew-CLI) for a command-line tool to create MediaWiki extension files.
* See [MWStew-builder](https://github.com/mooeypoo/MWStew-builder) for the base package that builds the extension files.

## Contribute
This is fully open source tool. It will be hosted so anyone that wants to use it can do so without running the script.

Contributions are extremely appreciated. Here are ways you can help:

* Test the form and add bug reports and/or feature requests to the [issues](https://github.com/mooeypoo/MWStew/issues).
* Add hooks to the form (there are many to add!) Read about [adding hooks to MWStew!](https://github.com/mooeypoo/MWStew/wiki/Adding-Hooks).
* Fix bugs or issues and submit pull requests.

Pull requests are welcome! Please participate and help make this a great tool!

## Authors
Moriel Schottlender (mooeypoo)
