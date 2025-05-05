<?php

// Include the Parsedown and the extension
require_once('../../_bundle/Parsedown_1.7.4/Parsedown.php');
require_once('../../Extension.php');

// Markdown data sample
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
$parser = new ParsedownToc();

// Get the parsed HTML
$html = $parser->text($textMarkdown);

// Get the Table of Contents
$ToC  = $parser->contentsList();

echo $html . PHP_EOL;
echo "---" . PHP_EOL;
echo $ToC . PHP_EOL;
