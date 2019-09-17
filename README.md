[![](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents.svg?branch=master)](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents "Travis CI Build Status")
[![](https://img.shields.io/packagist/php-v/keinos/parsedown-toc)](https://packagist.org/packages/keinos/parsedown-toc "Supported PHP Version")
[![](https://img.shields.io/badge/Parsedown-%3E%3D1.7-blue)](https://github.com/erusev/parsedown/releases "Supported Parsedown Version")

# Parsedown ToC

Listing Table of Contents Extension/Plugin for [Parsedown](http://parsedown.org/).

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown (vanilla)](https://github.com/erusev/parsedown) to generate a list of table of contents, aka ToC, from a markdown text given.

## Online Demo

https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us

## Install

### Via Composer

If you are familiar to [composer](https://en.wikipedia.org/wiki/Composer_(software)), the package manager for PHP, then install it as below:

```bash
composer require keinos/parsedown-toc
```

- Usage: [See sample project](https://github.com/KEINOS/parsedown-extension_table-of-contents/tree/master/samples/composer)

### Manual Install(Download script)

You can download the '[Extension.php](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php)' file from the below URL. Place it anywhere you like to include.

```bash
https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
```

- **NOTE:** Since this is an extension of [Parsedown](https://parsedown.org/), you need to download and include `Parsedown.php` too.
- Usage: [See sample project](https://github.com/KEINOS/parsedown-extension_table-of-contents/tree/master/samples/download)

```bash
# Download via cURL
curl -O https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
```

```bash
# Download via PHP
php -r "copy('https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php', './Extension.php');"
```

## Usage

```php
<?php
include_once('Pasedown.php');
include_once('Extension.php');

$textMarkdown =<<<EOL
# Head1
Sample text of head 1.
## Head1-1
Sample text of head 1-1.
# Head2
Sample text of head 2.
## 見出し2-1
Sample text of head2-1.
EOL;

$Parsedown = new ParsedownToc();
$body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC . PHP_EOL;
echo '<hr>' . PHP_EOL;
echo $body . PHP_EOL;
```

### Result

```html
<ul>
<li><a href="#Head1">Head1</a>
<ul>
<li><a href="#Head1-1">Head1-1</a></li>
</ul></li>
<li><a href="#Head2">Head2</a>
<ul>
<li><a href="#%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</a></li>
</ul></li>
</ul>
<hr>
<h1 id="Head1" name="Head1">Head1</h1>
<p>Sample text of head 1.</p>
<h2 id="Head1-1" name="Head1-1">Head1-1</h2>
<p>Sample text of head 1-1.</p>
<h1 id="Head2" name="Head2">Head2</h1>
<p>Sample text of head 2.</p>
<h2 id="%E8%A6%8B%E5%87%BA%E3%81%972-1" name="%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</h2>
<p>Sample text of head2-1.</p>
```

## Upcoming feature

- [ ] `[toc]` markdown tag to insert the table of contents. ([Issue #2](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/2))

## References

- [Parsedown's Wiki](https://github.com/erusev/parsedown/wiki) @ GitHub
- [Issues of this extension](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues) @ GitHub
- [Issues of Parsedown](https://github.com/erusev/parsedown/issues) @ GitHub
