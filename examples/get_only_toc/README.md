# Get Only The Table of Contents (ToC) in HTML and JSON

Once parsed by `text()` or `body()` method, you can retrieve only the table of contents (ToC) in HTML and JSON using `contentsList()` method.

This is useful if you want to display the ToC separately or use it in a different context.

## Retrieving the ToC in HTML

```php
// Instanciate the Parsedown with ToC extension
$Parsedown = new ParsedownToc();

// Parse the Markdown
$html = $Parsedown->text($textMarkdown);

// Get the Table of Contents in HTML
$tocHTML = $Parsedown->contentsList('string');
```

## Retrieving the ToC in JSON

```php
// Instanciate the Parsedown with ToC extension
$Parsedown = new ParsedownToc();

// Parse the Markdown
$html = $Parsedown->text($textMarkdown);

// Get the Table of Contents in JSON
$tocJSON = $Parsedown->contentsList('json');
```
