<?php

require_once('../../Parsedown.php');
require_once('../../Extension.php');

// Markdown data sample with [toc] tag
$textMarkdown = <<<EOL
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
$Parsedown = new ParsedownToc();

// Parse the Markdown
$html = $Parsedown->body($textMarkdown);

// Get the Table of Contents in HTML and JSON format
$tocHTML = $Parsedown->contentsList('string');
$tocJSON = $Parsedown->contentsList('json');

echo '* HTML:' . PHP_EOL;
echo $tocHTML . PHP_EOL;

echo PHP_EOL;

echo '* JSON:' . PHP_EOL;
echo $tocJSON . PHP_EOL;
