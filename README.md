# Listing Table of Contents Extension/Plugin for [Parsedown](http://parsedown.org/)

This [simple PHP file](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php) extends [Parsedown (vanilla)](https://github.com/erusev/parsedown) to generate a list of table of contents, aka ToC, from a markdown text given.

## Online Demo

https://paiza.io/projects/0TghplxParLqyrP1tjAg6g?locale=en-us

## Install

1. Download the '[Extension.php](https://github.com/KEINOS/parsedown-extension_table-of-contents/blob/master/Extension.php)' script and place it anywere you like.

    Via `curl -O`
    ```shell
    curl -O https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php
    ```
    or via `php -r`
    ```shell
    php -r "copy('https://KEINOS.github.io/parsedown-extension_table-of-contents/Extension.php', './Extension.php');"
    ```
2. Then include it after including the 'Parsedown.php' vanilla.

- Tested with Parsedown 1.7.1

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

$Parsedown = new Extension();
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

