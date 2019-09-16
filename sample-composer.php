<?php
/*
===============================================================================
 Sample script to use Parsedown ToC Extension.
===============================================================================
 This sample uses composer. Run:
   composer require keinos/parsedown-toc
*/

const DIR_SEP=DIRECTORY_SEPARATOR;

require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';

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
