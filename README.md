[![](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents.svg?branch=master)](https://travis-ci.org/KEINOS/parsedown-extension_table-of-contents "Travis CI Build Status")
[![](https://img.shields.io/packagist/php-v/keinos/parsedown-toc)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/.travis.yml "Supported PHP Version")
[![](https://img.shields.io/badge/Parsedown-%3E%3D1.7-blue)](https://github.com/erusev/parsedown/releases "Supported Parsedown Version")
[![](https://img.shields.io/packagist/v/keinos/parsedown-toc)](https://packagist.org/packages/keinos/parsedown-toc "View in Packagist")

# Parsedown ToC Extension

Listing Table of Contents Extension for [Parsedown](http://parsedown.org/).

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown Vanilla](https://github.com/erusev/parsedown) / [Parsedown Extra](https://github.com/erusev/parsedown-extra) to generate a list of header index (a.k.a. Table of Contents or ToC), from a markdown text given.

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
    - `text(string $text)`:
      - Returns the parsed content and `[toc]` tag(s) parsed as well.
      - Required argument `$text`: Markdown string to be parsed.
    - `body(string $text)`:
      - Returns the parsed content WITHOUT parsing `[toc]` tag.
      - Required argument `$text`: Markdown string to be parsed.
    - `toc([string $type_return='string'])`:
      - Returns the ToC, the table of contents, in HTML or JSON.
      - Option argument:
        - `$type_return`:
          - `string` or `json` can be specified. `string`=HTML, `json`=JSON.
          - Default `string`
      - Alias method: `contentsList(string $type_return)`
    - `setTagToc(string $tag='[tag]')`:
      - Sets user defined ToC markdown tag. Use this method before `text()` or `body()` method if you want to use the ToC tag rather than the "`[toc]`".
      - Empty value sets the default ToC tag.
      - Available since v1.1.2
  - Other Methods:
    - All the public methods of `Parsedown` and/or `Parsedown Extend` are available to use.
  - Note: As of v1.1.0 the old alias class: `Extension()` is deprecated.

## Online Demo

- [https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us](https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us) @ paiza.IO

## Install

### Via Composer

If you are familiar to [composer](https://en.wikipedia.org/wiki/Composer_(software)), the package manager for PHP, then install it as below:

```bash
# Current stable
composer require keinos/parsedown-toc

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

## Sample Usage

- See: [./samples/](./samples/)

## Advanced Usage (Using Parsedown Extra)

As of Parsedown ToC Extension v1.1.1, you can use the [anchor identifiers](https://michelf.ca/projects/php-markdown/extra/#header-id) for [Parsedown Extra](https://github.com/erusev/parsedown-extra).

With this feature, you can specify the anchor name you like. Useful if the headings are in UTF-8 (not in ASCII) and to make it readable. Such as placing the "go back" links in a page.

```markdown
# SampleHead1 {#self-defined-head1}
Sample text of head 1

---

[Link back to header 1](#self-defined-head1)
```

With the above markdown the generated ToC will be as below. Note that the anchor is changed to the specified one.

```html
<ul>
<li><a href="#self-defined-head1">SampleHead1</a></li>
</ul>
```

- Note that you need to require/include the Parsedown Extra as well.

## References

- Repo:
  - Source Code: https://github.com/KEINOS/parsedown-extension_table-of-contents @ GitHub
  - Archived Package: https://packagist.org/packages/keinos/parsedown-toc @ Packagist
- Support:
  - [Parsedown's Wiki](https://github.com/erusev/parsedown/wiki) @ GitHub
  - [Issues of this extension](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues) @ GitHub
  - [Issues of Parsedown](https://github.com/erusev/parsedown/issues) @ GitHub
  - [Issues of Parsedown Extra](https://github.com/erusev/parsedown-extra/issues) @ GitHub
- Authors:
  - [KEINOS and the contributors](https://github.com/KEINOS/parsedown-extension_table-of-contents/graphs/contributors) @ GitHub
- Licence:
  - [MIT](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/LICENSE)