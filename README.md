<!-- markdownlint-disable-file MD033 MD041 -->
[![Unit Tests](https://github.com/KEINOS/parsedown-extension_table-of-contents/actions/workflows/unit-tests.yml/badge.svg)](https://github.com/KEINOS/parsedown-extension_table-of-contents/actions/workflows/unit-tests.yml)
[![Supported PHP Version Badge](https://img.shields.io/packagist/php-v/keinos/parsedown-toc)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/composer.json#L19 "Supported PHP Version")
[![Parsedown Version Badge](https://img.shields.io/packagist/v/keinos/parsedown-toc)](https://packagist.org/packages/keinos/parsedown-toc "View in Packagist")
[![PHPDoc Badge](https://img.shields.io/badge/PHP_Doc-reference-blue?logo=php)](https://keinos.github.io/parsedown-extension_table-of-contents/ "View PHP Doc reference")

# Parsedown ToC Extension

Listing Table of Contents Extension for [Parsedown](http://parsedown.org/).

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown Vanilla](https://github.com/erusev/parsedown) / [ParsedownExtra](https://github.com/erusev/parsedown-extra) to generate a list of header index (a.k.a. Table of Contents or ToC), from a markdown text given.

- For PHP 8.4+ users: see [supported PHP version](#requirements) for more details.

## Basic Usage

<details><summary>Parsedown Vanilla</summary><br />

```php
<?php

// Include the Parsedown and the ToC extension
require_once('Parsedown.php');
require_once('Extension.php');

// Markdown Data Sample
$inputMarkdown = <<<EOL
# Head1
Sample text of head 1.
## Head1-1
Sample text of head 1-1.
# Head2
Sample text of head 2.
## 見出し2-1
Sample text of head2-1.
EOL;

// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Get the parsed HTML
$html = $parser->text($inputMarkdown);

// Get the Table of Contents in HTML
$tocHTML = $parser->contentsList('html');

// Print the parsed HTML and ToC
echo $html . PHP_EOL;
echo "---" . PHP_EOL;
echo $tocHTML . PHP_EOL;
```

```shellsession
$ php ./index.php
<h1 id="Head1" name="Head1">Head1</h1>
<p>Sample text of head 1.</p>
<h2 id="Head1-1" name="Head1-1">Head1-1</h2>
<p>Sample text of head 1-1.</p>
<h1 id="Head2" name="Head2">Head2</h1>
<p>Sample text of head 2.</p>
<h2 id="%E8%A6%8B%E5%87%BA%E3%81%972-1" name="%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</h2>
<p>Sample text of head2-1.</p>
---
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
```

</details>

<details><summary>Parsedown Extra</summary><br />

```php
<?php

// Include the Parsedown, ParsedownExtra and ToC extension
require_once('Parsedown.php');
require_once('ParsedownExtra.php');
require_once('Extension.php');

// Extended markdown data sample
$textMarkdown = <<<EOL
# Head1 {#self-defined-head1}

You can include inline HTML tags<br>in the markdown text.

<div markdown="1">
And use the markdown syntax inside HTML Blocks.
</div>

| Header1 | Header2 |
| ------- | ------- |
| Table syntax  | as well  |

## 見出し2 {#self-defined-head2-1}

You can customize the anchor IDs of non-ASCII characters, such as Japanese characters, to more readable ones.

EOL;

// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Get the parsed HTML
$html = $parser->text($textMarkdown);

// Get the Table of Contents
$ToC  = $parser->contentsList();

echo $html . PHP_EOL;
echo "---" . PHP_EOL;
echo $ToC . PHP_EOL;
```

```shellsession
$ php ./index.php
<h1 id="self-defined-head1" name="self-defined-head1">Head1</h1>
<p>You can include inline HTML tags<br>in the markdown text.</p>
<div>
<p>And use the markdown syntax inside HTML Blocks.</p>
</div>
<table>
<thead>
<tr>
<th>Header1</th>
<th>Header2</th>
</tr>
</thead>
<tbody>
<tr>
<td>Table syntax</td>
<td>as well</td>
</tr>
</tbody>
</table>
<h2 id="self-defined-head2-1" name="self-defined-head2-1">見出し2</h2>
<p>You can customize the anchor IDs of non-ASCII characters, such as Japanese characters, to more readable ones.</p>
---
<ul>
<li><a href="#self-defined-head1">Head1</a>
<ul>
<li><a href="#self-defined-head2-1">見出し2</a></li>
</ul></li>
</ul>
```

</details>

- For more examples see the [examples](https://github.com/KEINOS/parsedown-extension_table-of-contents/tree/master/examples) directory.

## Installation

This extension, **`ParsedownToC`, is a single PHP file.** [Download](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) and place it in the same directory as the `Parsedown.php` file (optionally place the `ParsedownExtra.php` file if you are using it).

<details><summary>Manual Install</summary>

You can download the latest '[Extension.php](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php)' file from the below URL. Place it anywhere you like to include.

```bash
https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
```

```bash
# Download via cURL
curl -O https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
```

```bash
# Download via PHP
php -r "copy('https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php', './Extension.php');"
```

> Since this is an extension of [Parsedown](https://parsedown.org/), you need to download and include `Parsedown.php` as well.

</details>

### Via Composer

**We also support [Composer](https://getcomposer.org/)** for installation and convenience.

```bash
# Current stable
composer require keinos/parsedown-toc

# Latest
composer require keinos/parsedown-toc:dev-master
```

<details><summary>Basic Usage Using Composer</summary><br />

To use the extension via Composer, include the autoloader (`vendor/autoload.php` file) instead of the `Parsedown.php` and `Extension.php` file.

```php
$ cat ./parse_sample.php
<?php
require_once __DIR__ . '/vendor/autoload.php';

// Sample Markdown with '[toc]' tag included
$text_markdown = file_get_contents('SAMPLE.md');

$parser = new \ParsedownToC();

// Parse Markdown and the '[toc]' tag to HTML
$html = $parser->text($text_markdown);

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

</details>

## Requirements

**`PardesownToC` itself supports PHP 5.5 up-to current latest PHP 8.4**.

However, the latest stable release of `Parsedown` 1.7.4 do not fully support PHP 8.4. And `ParsedownExtra` 0.8.1 do not fully support PHP 7.1 or later. Which throws deprecation warnings of PHP.

### Stable Combination

To use both the stable released versions of `Parsedown` 1.7.4 and `ParsedownExtra` 0.8.1, you need to use between PHP 5.5 and PHP 7.0.

With later PHP versions you will get several deprecation warnings.

| Script Name | Versions |
| :-- | :-- |
| PHP | [![Static Badge](https://img.shields.io/badge/%3E%3D5.5%20%3C%3D7.0-blue?logo=php&label=PHP)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/composer.json#L19 "Supported PHP Version") |
| Parsedown.php | [![Parsedown Version Badge](https://img.shields.io/badge/Parsedown-%3D1.7.4-blue)](https://github.com/erusev/parsedown/releases "Supported Parsedown Version") <br />SHA256 Hash: `af4a4b29f38b5a00b003a3b7a752282274c969e42dee88e55a427b2b61a2f38f` |
| ParsedownExtra.php | [![ParsedownExtra Version Badge](https://img.shields.io/badge/ParsedownExtra-%3D0.8.1-blue)](https://github.com/erusev/parsedown-extra/releases "Supported ParsedownExtra Version") <br />SHA256 Hash:  `b0c6bd5280fc7dc1caab4f4409efcae9fb493823826f7999c27b859152494be7` |

### Last-gasp Effort Combination

**For PHP 8.4 or higher users:** We have patched versions of `Parsedown` 1.7.4 and `ParsedownExtra` 0.8.1 to support PHP 8.4, the current latest PHP version and above.

These patched versions do not have any new features or refactoring made. Only the deprecation warnings from PHP are removed.

Use these combinations if you want to use the **exact same features as the stable version with the latest PHP version**.

| Script Name | Versions |
| :-- | :-- |
| PHP | [![Parsedown Version Badge](https://img.shields.io/badge/8.4.x-blue?logo=php&label=PHP&color=blue)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/composer.json#L19 "Supported PHP Version") |
| Parsedown.php ([patched](./_bundle/Parsedown_1.7.4-patched/)) | [![Parsedown Version Badge](https://img.shields.io/badge/Parsedown-%3D1.7.4%20patched-blue)](./_bundle/Parsedown_1.7.4-patched/ "Supported Parsedown Version") <br />SHA256 Hash: `b81a67cdd55e984bacc5fa5be84a15794de94b71841a18a9028a13ab9a41756a`<br />(no new feature and refactoring) |
| ParsedownExtra.php ([patched](./_bundle/ParsedownExtra_0.8.1-patched/)) | [![ParsedownExtra Version Badge](https://img.shields.io/badge/ParsedownExtra-%3D0.8.1%20patched-blue)](./_bundle/ParsedownExtra_0.8.1-patched/ "Supported Parsedown Version") <br />SHA256 Hash: `2873b8eac69aae9d8422dba1efc53c143ab85b570bfe8429035eeb47014cb5ca`<br />(no new feature and refactoring) |

> [!NOTE]
> We are not supporting [Parsedown v2](https://github.com/erusev/parsedown/tree/2.0.x) or above until the official beta release.

## Class Info and Methods

For more details, please refer to the [PHP Doc reference](https://keinos.github.io/parsedown-extension_table-of-contents/).

- Main Class: `ParsedownToC()`
  - Arguments: none
  - Methods:
    - `text(string $text)`:
      - Returns the parsed content and `[toc]` tag(s) parsed as well
      - Required argument:
        - `$text`: Markdown string to be parsed
    - `body(string $text [, bool $omit_toc_tag=false])`:
      - Returns the parsed content WITHOUT parsing `[toc]` tag
      - Required argument:
        - `$text`: Markdown string to be parsed
      - Optional argument:
        - `$omit_toc_tag`: If `true`, the `[toc]` tag will be excluded from the output
        - Default: `false`
        - Available since v1.3.0
    - `contentsList([string $type_return='string'])`:
      - Returns the ToC, the table of contents, in HTML or JSON.
      - Optional argument:
        - `$type_return`: Specifies the returned format
          - `"string"` or `"json`" can be specified. `string`=HTML, `json`=JSON.
          - Default `"string"`
    - `setTagToc(string $tag='[tag]')`:
      - Sets user defined ToC markdown tag. Empty value sets the default tag
      - Default: `"[toc]"`
      - Available since v1.1.2
      - Note: Use this method before `text()` or `body()` method if you want to use the ToC tag rather than the "`[toc]`"
  - Other Methods:
    - All the public methods of `Parsedown` and/or `Parsedown Extend` are available to use
  - Note: As of `ParsedownToC` v1.1.0 the old alias class `Extension()` is deprecated

## Online Demo

- [https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us](https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us) @ paiza.IO

## Advanced Usage (Using Parsedown Extra)

As of ParsedownToC [v1.1.1](https://github.com/KEINOS/parsedown-extension_table-of-contents/releases/tag/v1.1.1), you can use the [anchor identifiers](https://michelf.ca/projects/php-markdown/extra/#header-id) for [Parsedown Extra](https://github.com/erusev/parsedown-extra).

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

## Testing

Eventhough we are migraing the tests to PHPUnit, **currently we use hand-made test scripts to run the unit tests** via bash.

### Testing using docker (docker compose)

```shell
# PHP 5.6.40 is not officially supported but used to check for backwards
# compatibility (still works tho!)
docker compose run --rm oldest

# PHP 7.x is the minimum supported version.
docker compose run --rm min

# PHP 8.3 is the stable supported version.
docker compose run --rm stable

# PHP 8.4+ (latest) is the experimental version. Currently uses the patched Parsedown 1.7.4.
docker compose run --rm latest
```

### Testing locally

To run the tests:

```bash
./tests/run-tests.sh
```

> [!IMPORTANT]
> **This test will download/install dependencies** such as: `Parsedown.php`, `ParsedownExtra.php`, `git`, `jq`, `curl` and `bash` if not installed.
> So please run this test in a safe Unix-like environment (docker for example).

```shellsession
$ # Test result example (w/ oldest supported version)
$ ./tests/run-tests.sh
--------------------------------
Running tests in Alpine Linux OS
--------------------------------
================================
 Env checks before testing
================================
- Info: OS ...
  NAME="Alpine Linux"
  ID=alpine
  VERSION_ID=3.8.2
  PRETTY_NAME="Alpine Linux v3.8"
  HOME_URL="http://alpinelinux.org"
  BUG_REPORT_URL="http://bugs.alpinelinux.org"

- Checking: php ...
  php installed:   PHP 5.6.40 (cli) (built: Jan 31 2019 01:25:07)
  Copyright (c) 1997-2016 The PHP Group
  Zend Engine v2.6.0, Copyright (c) 1998-2016 Zend Technologies

- Checkging: apk ...
  apk installed: apk-tools 2.10.6, compiled for x86_64.
- Checking: jq ...
  jq installed: jq-master-v3.7.0-4757-gc31a4d0fd5
- Checking: curl ...
  curl installed: curl 7.61.1 (x86_64-alpine-linux-musl) libcurl/7.61.1 LibreSSL/2.0.0 zlib/1.2.11 libssh2/1.9.0 nghttp2/1.39.2
- Checking: bash ...
  bash installed: GNU bash, version 4.4.19(1)-release (x86_64-alpine-linux-musl)
- Lint Check: Extension.php ... OK
  No syntax errors detected in /app/Extension.php
- Searching Parsedown ... Found
- Searching Parsedown Extra ... Found
================================
 Running tests
================================
Parsedown Vanilla
- TESTING: test_vanilla_basic_usage.sh  ... OK (Parser: ./parser/parser-vanilla.php)
- TESTING: test_vanilla_empty_user_defined_toc_tag_style.sh  ... OK (Parser: ./parser/parser-vanilla.php)
- TESTING: test_vanilla_operation_check.sh  ... OK (Parser: ./parser/parser-vanilla.php)
- TESTING: test_vanilla_user_defined_toc_tag_style1.sh  ... OK (Parser: ./parser/parser-vanilla.php)
- TESTING: test_vanilla_user_defined_toc_tag_style2.sh  ... OK (Parser: ./parser/parser-vanilla.php)
- TESTING: test_vanilla_user_defined_toc_tag_style3.sh  ... OK (Parser: ./parser/parser-vanilla.php)

Parsedown Extra
- TESTING: test_vanilla_basic_usage.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_empty_user_defined_toc_tag_style.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_operation_check.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style1.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style2.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style3.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_extra_anchor_id.sh  ... OK (Parser: ./parser/parser-extra.php)

Issues/Features
- TESTING: feature #22: option arg to exclude ToC tag in `body`
  - test #1: enable to omit the ToC tag in the body of the document ... OK
  - test #2: disable to omit the ToC tag in the body of the document (default) ... OK

Test done. All tests passed.
```

## References

- Repo:
  - Source Code: [https://github.com/KEINOS/parsedown-extension_table-of-contents](https://github.com/KEINOS/parsedown-extension_table-of-contents) @ GitHub
  - Archived Package: [https://packagist.org/packages/keinos/parsedown-toc](https://packagist.org/packages/keinos/parsedown-toc) @ Packagist
- Support:
  - [Parsedown's Wiki](https://github.com/erusev/parsedown/wiki) @ GitHub
  - [Issues of this extension](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues) @ GitHub
  - [Issues of Parsedown](https://github.com/erusev/parsedown/issues) @ GitHub
  - [Issues of Parsedown Extra](https://github.com/erusev/parsedown-extra/issues) @ GitHub
- Authors:
  - [KEINOS and the contributors](https://github.com/KEINOS/parsedown-extension_table-of-contents/graphs/contributors) @ GitHub
- Licence:
  - [MIT](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/LICENSE)
