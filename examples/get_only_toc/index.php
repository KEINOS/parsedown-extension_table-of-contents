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

// Get the Table of Contents in HTML format
$tocHTML = $Parsedown->contentsList('string');
echo '* HTML:' . PHP_EOL;
echo $tocHTML . PHP_EOL;
echo PHP_EOL;

// Get the Table of Contents in JSON format
$tocJSON = $Parsedown->contentsList('json');
echo '* JSON:' . PHP_EOL;
echo $tocJSON . PHP_EOL;
echo PHP_EOL;

// Get the Table of Contents in flat array format
$flatToC  = $Parsedown->contentsList("flatArray");
echo '* Flat array:' . PHP_EOL;
print_r($flatToC);
echo PHP_EOL;

// Get the Table of Contents in nested array format
$nestedToC = $Parsedown->contentsList("nestedArray");
echo '* Nested array:' . PHP_EOL;
print_r($nestedToC);
