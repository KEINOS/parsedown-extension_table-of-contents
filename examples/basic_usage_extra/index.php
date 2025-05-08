<?php

// Include the Parsedown. Use the patched version for PHP 8.4+
if (version_compare(PHP_VERSION, '8.4.0', '>=')) {
    require_once('../../_bundle/Parsedown_1.7.4-patched/Parsedown.php');
} else {
    require_once('../../_bundle/Parsedown_1.7.4/Parsedown.php');
}

// Include the ParsedownExtra. Use the patched version for PHP 8.2+
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    require_once('../../_bundle/ParsedownExtra_0.8.1-patched/ParsedownExtra.php');
} else {
    require_once('../../_bundle/ParsedownExtra_0.8.1/ParsedownExtra.php');
}

// Include the ParsedownToc extension
require_once('../../Extension.php');

// Markdown data sample
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
