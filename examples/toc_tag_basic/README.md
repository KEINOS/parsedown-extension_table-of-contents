# ToC Tag Basic Usage Example

By default, `text()` method will replace the `[toc]` tag found in the markdown file with the table of contents. This is useful for generating a table of contents automatically.

```php
<?php

require_once('../../Parsedown.php');
require_once('../../Extension.php');

// Markdown data sample with [toc] tag
$textMarkdown = <<<EOL
[toc]

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

// Get the parsed HTML and the ToC
$html = $Parsedown->text($textMarkdown);

echo $html . PHP_EOL;
```

## Related Examples

- [toc_tag_custom](../toc_tag_custom/README.md): Custom/user-defined ToC tag usage example.
