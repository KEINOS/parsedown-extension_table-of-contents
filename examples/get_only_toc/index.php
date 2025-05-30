<?php

// Include the Parsedown. Use the patched version for PHP 8.4+
if (version_compare(PHP_VERSION, '8.4.0', '>=')) {
    require_once('../../_bundle/Parsedown_1.7.4-patched/Parsedown.php');
} else {
    require_once('../../_bundle/Parsedown_1.7.4/Parsedown.php');
}

// Include the ParsedownToc extension
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
$parser = new \ParsedownToc();

// Parse the Markdown
$html = $parser->body($textMarkdown);

// Get the Table of Contents in HTML format
$tocHTML = $parser->contentsList('html');
echo '* HTML:' . PHP_EOL;
echo $tocHTML . PHP_EOL;
echo PHP_EOL;

// Get the Table of Contents in Markdown format
$tocMd = $parser->contentsList('markdown');
echo '* Markdown:' . PHP_EOL;
echo $tocMd . PHP_EOL;
echo PHP_EOL;

// Get the Table of Contents in JSON format
$tocJSON = $parser->contentsList('json');
echo '* JSON:' . PHP_EOL;
echo $tocJSON . PHP_EOL;
echo PHP_EOL;

// Get the Table of Contents in flat array format
$flatToC  = $parser->contentsList("flatArray");
echo '* Flat array:' . PHP_EOL;
print_r($flatToC);
echo PHP_EOL;

// Get the Table of Contents in nested array format
$nestedToC = $parser->contentsList("nestedArray");
echo '* Nested array:' . PHP_EOL;
print_r($nestedToC);
