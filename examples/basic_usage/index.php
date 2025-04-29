<?php

// Include the Parsedown and the extension
require_once('../../Parsedown.php');
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
$Parsedown = new ParsedownToc();

// Get the parsed HTML
$html = $Parsedown->text($textMarkdown);

// Get the Table of Contents
$ToC  = $Parsedown->contentsList();

echo $html . PHP_EOL;
echo "---" . PHP_EOL;
echo $ToC . PHP_EOL;
