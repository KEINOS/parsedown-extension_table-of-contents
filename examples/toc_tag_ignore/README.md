# Example of Ignoring the ToC tag in markdown files

`text()` method will parse the markdown file to HTML and the ToC tag as well. This is useful for generating a table of contents automatically.

 In the other hand, `body()` method will do the same but it will ignore parsing the ToC tag and leaves the ToC tag as it is.

```php
// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Parse the markdown file to HTML leaving the ToC tag as it is
$html = $parser->body($textMarkdown);
```

In that case, you may want to exclude the ToC tag from the output. This can be done by setting the second parameter of the `body()` method to `true`.

```php
// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Get the parsed HTML and the ToC
$excludeToC = true;
$html = $parser->body($textMarkdown, $excludeToC);
```
