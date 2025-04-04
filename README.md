[![Unit Tests](https://github.com/KEINOS/parsedown-extension_table-of-contents/actions/workflows/unit-tests.yml/badge.svg)](https://github.com/KEINOS/parsedown-extension_table-of-contents/actions/workflows/unit-tests.yml)
[![](https://img.shields.io/packagist/php-v/keinos/parsedown-toc)](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/composer.json#L19 "Supported PHP Version")
[![](https://img.shields.io/packagist/v/keinos/parsedown-toc)](https://packagist.org/packages/keinos/parsedown-toc "View in Packagist")

# Parsedown ToC Extension

Listing Table of Contents Extension for [Parsedown](http://parsedown.org/).

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown Vanilla](https://github.com/erusev/parsedown) / [Parsedown Extra](https://github.com/erusev/parsedown-extra) to generate a list of header index (a.k.a. Table of Contents or ToC), from a markdown text given.

| Supported Version | SHA256 Hash |
| :-- | :-- |
| [![](https://img.shields.io/badge/Parsedown-%3D1.7.4-blue)](https://github.com/erusev/parsedown/releases "Supported Parsedown Version") | `af4a4b29f38b5a00b003a3b7a752282274c969e42dee88e55a427b2b61a2f38f` |
| [![](https://img.shields.io/badge/ParsedownExtra-%3D0.8.1-blue)](https://github.com/erusev/parsedown-extra/releases "Supported Parsedown Extra Version") | `b0c6bd5280fc7dc1caab4f4409efcae9fb493823826f7999c27b859152494be7` |

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

## Testing

Eventhough we are migraing the tests to PHPUnit, currently we use hand-made test scripts to run the unit tests via bash.

### Testing using docker (docker compose)

```shell
# PHP 5.6.40 is not officially supported but used to check for backwards
# compatibility (still works tho!.)
docker compose run --rm oldest

# PHP 7.x is the minimum supported version.
docker compose run --rm min

# PHP 8.3 is the maximum supported version.
docker compose run --rm max

# PHP 8.4+ (latest) is the experimental version. Currently errors out.
docker compose run --rm latest
```

### Testing locally

To run the tests:

```bash
./tests/run-tests.sh
```

> [!IMPORTANT]
> This test will download/install dependencies such as: `Parsedown.php`, `ParsedownExtra.php`, `git`, `jq`, `curl` and `bash` if not installed. So please run this test in a safe environment (docker for example).

```shellsession
$ # Test result example
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
  apk installed: apk-tools 2.10.1, compiled for x86_64.
- Checking: jq ...
* WARNING: jq command missing
- INSTALL: Installing jq ... OK
  jq installed: jq-master-v3.7.0-4757-gc31a4d0fd5
- Checking: curl ...
  curl installed: curl 7.61.1 (x86_64-alpine-linux-musl) libcurl/7.61.1 LibreSSL/2.0.0 zlib/1.2.11 libssh2/1.8.0 nghttp2/1.32.0
- Checking: bash ...
* WARNING: bash shell missing
- INSTALL: Installing bash ... OK
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
- TESTING: test_extra_anchor_id.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_basic_usage.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_empty_user_defined_toc_tag_style.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_operation_check.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style1.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style2.sh  ... OK (Parser: ./parser/parser-extra.php)
- TESTING: test_vanilla_user_defined_toc_tag_style3.sh  ... OK (Parser: ./parser/parser-extra.php)

Test done. All tests passed.
```

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