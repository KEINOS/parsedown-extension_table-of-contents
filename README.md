[![](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents.svg?branch=master)](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents "Travis CI Build Status")
[![](https://img.shields.io/packagist/php-v/keinos/parsedown-toc)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/.travis.yml "Supported PHP Version")
[![](https://img.shields.io/badge/Parsedown-%3E%3D1.7-blue)](https://github.com/erusev/parsedown/releases "Supported Parsedown Version")
[![](https://img.shields.io/packagist/v/keinos/parsedown-toc)](https://packagist.org/packages/keinos/parsedown-toc "View in Packagist")

# Parsedown ToC Extension

Listing Table of Contents Extension for [Parsedown](http://parsedown.org/).

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown Vanilla](https://github.com/erusev/parsedown)/[ParsedownExtra](https://github.com/erusev/parsedown-extra) to generate a list of header index (a.k.a. Table of Contents or ToC), from a markdown text given.

```bash
composer require keinos/parsedown-toc
```

```php
$ cat ./parse_sample.php
<?php
require_once __DIR__ . '/vendor/autoload.php';

// Sample Markdown with '[toc]' tag included
$text_markdown = file_get_contents('SAMPLE.md');

$Parsedown = new \ParsedownToC();

// Parses '[toc]' tag to ToC if exists
$html = $Parsedown->text($text_markdown);

echo $html . PHP_EOL;

```

```shellsession
$ cat ./SAMPLE.md
[toc]

---

# One
Something about One

## Two
Something about Two

# One2
Something about One2
```

```bash
$ php ./parse_sample.php
<div id="toc"><ul>
<li><a href="#One">One</a><ul>
<li><a href="#Two">Two</a></li>
</ul>
</li>
<li><a href="#One2">One2</a></li>
</ul></div>
<hr />
<h1 id="One" name="One">One</h1>
<p>Something about One</p>
<h2 id="Two" name="Two">Two</h2>
<p>Something about Two</p>
<h1 id="One2" name="One2">One2</h1>
<p>Something about One2</p>
```

With the `toc()` method, you can get just the "ToC".

```php
<?php
// Parse body and ToC separately

require_once __DIR__ . '/vendor/autoload.php';

$text_markdown = file_get_contents('SAMPLE.md');
$Parsedown     = new \ParsedownToC();

$body = $Parsedown->body($text_markdown);
$toc  = $Parsedown->toc();

echo $toc . PHP_EOL;  // Table of Contents in <ul> list
echo $body . PHP_EOL; // Main body
```

- Main Class: `ParsedownToC()`
  - Arguments: none
  - Methods:
    - `text(string $text)`: Returns the parsed content and `[toc]` tag(s) parsed as well.
      - Required argument `$text`: Markdown string to be parsed.
    - `body(string $text)`: Returns the parsed content without parsing `[toc]` tag.
      - Required argument `$text`: Markdown string to be parsed.
    - `toc([string $type_return='string'])`: Returns the ToC, the table of contents, in HTML or JSON.
      - Option argument `$type_return`: `string` or `json` can be specified. (`string`=HTML(default), `json`=JSON)
      - Alias method: `contentsList(string $type_return)`
  - Other Methods:
    - All the public methods of `Parsedown` and/or `Parsedown Extend` are available to use.
  - Note: As of v1.1.0 the old alias class: `Extension()` is deprecated.

## Online Demo

https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us @ paiza.IO

## Install

### Via Composer

If you are familiar to [composer](https://en.wikipedia.org/wiki/Composer_(software)), the package manager for PHP, then install it as below:

```bash
# Current stable
composer require keinos/parsedown-toc:^1.0
# Latest
composer require keinos/parsedown-toc:dev-master
```

- Usage: [See sample project](https://github.com/KEINOS/parsedown-extension_table-of-contents/tree/master/samples/composer)

### Manual Install (Download the script)

You can download the '[Extension.php](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php)' file from the below URL. Place it anywhere you like to include.

```bash
https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
```

- **NOTE:** Since this is an extension of [Parsedown](https://parsedown.org/), you need to download and include `Parsedown.php` as well.
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

### Sample scripts(`Main.php`)

<details><summary>Sample Script Without Using Composer</summary><div><br>

```php
<?php
/* Sample script of Parsedown-ToC without using composer */
require_once('Pasedown.php');
require_once('Extension.php');

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

$Body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC . PHP_EOL;
echo '<hr>' . PHP_EOL;
echo $Body . PHP_EOL;
```

</div></details>

<details><summary>Sample Script Using Composer</summary><div><br>

```php
<?php
/* Sample script of Parsedown-ToC using composer */
require_once __DIR__ . '/vendor/autoload.php';

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

$Body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC . PHP_EOL;
echo '<hr>' . PHP_EOL;
echo $Body . PHP_EOL;
```

</div></details>

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

### Run (Sample of the steps to take)

This is a log of "how-to" using composer on `bash`.

```shellsession
$ # Create and move to the project directory.
$ mkdir my_sample && cd $_

$ # Create the main script.
$ vi Main.php
...(paste the sample script here)...

$ # Current directory structure
$ tree
.
└── main.php

0 directories, 1 files

$ # Require package that depends the project.
$ # (This will install the "erusev/parsedown", which "keinos/parsedown-toc" depends, too)
$ composer require keinos/parsedown-toc
Using version ^1.0 for keinos/parsedown-toc
./composer.json has been created
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
  - Installing erusev/parsedown (1.7.3): Downloading (100%)
  - Installing keinos/parsedown-toc (1.0.1): Downloading (100%)
Writing lock file
Generating autoload files

$ # Current directory structure
$ tree
.
├── composer.json
├── composer.lock
├── Main.php
└── vendor
    ├── autoload.php
    ├── composer
    │   ├── ClassLoader.php
    │   ├── LICENSE
    │   ├── autoload_classmap.php
    │   ├── autoload_files.php
    │   ├── autoload_namespaces.php
    │   ├── autoload_psr4.php
    │   ├── autoload_real.php
    │   ├── autoload_static.php
    │   └── installed.json
    ├── erusev
    │   └── parsedown
    │       ├── LICENSE.txt
    │       ├── Parsedown.php
    │       ├── README.md
    │       └── composer.json
    └── keinos
        └── parsedown-toc
            ├── Extension.php
            ├── LICENSE
            ├── README.md
            └── composer.json

6 directories, 21 files

$ # Run
$ php ./Main.php
... See the Result section above ...

```

## References

- Repo:
  - Source Code: https://github.com/KEINOS/parsedown-extension_table-of-contents @ GitHub
  - Archived Package: https://packagist.org/packages/keinos/parsedown-toc @ Packagist
- Support:
  - [Parsedown's Wiki](https://github.com/erusev/parsedown/wiki) @ GitHub
  - [Issues of this extension](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues) @ GitHub
  - [Issues of Parsedown](https://github.com/erusev/parsedown/issues) @ GitHub

## Upcoming feature

- [x] ~~`[toc]` markdown tag/element replacing it to the table of contents~~. ([Issue #2](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/2)) Now available!
