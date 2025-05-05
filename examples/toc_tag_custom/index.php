<?php

require_once('../../_bundle/Parsedown_1.7.4/Parsedown.php');
require_once('../../Extension.php');

// Markdown Data Sample
$textMarkdown = <<<EOL
[[table of contents]]

---

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

// Set user-defined ToC tag
$parser->setTagToc('[[table of contents]]');

// Get the parsed HTML and the ToC
$html = $parser->text($textMarkdown);

echo $html . PHP_EOL;
