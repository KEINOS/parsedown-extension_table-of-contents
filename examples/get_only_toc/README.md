# Get Only The Table of Contents (ToC) in various formats

Once parsed by `text()` or `body()` method, you can retrieve only the table of contents (ToC) in various format using `contentsList()` method.

This is useful if you want to display the ToC separately or use it in a different context.

The method `contentsList()` accepts a parameter that defines the format of the output. The available formats are:

- `"html"`: Returns the ToC in HTML format (alias: `string`).
- `"markdown"`: Returns the ToC in Markdown format (alias: `md`).
- `"json"`: Returns the ToC in JSON format.
- `"flatArray"`: Returns the ToC in one dimensional array format.
- `"nestedArray"`: Returns the ToC in array format with nested structure.

> [!NOTE]
>
> If you **want the ToC in pure text format**, then you can use the `"nestedArray"` option and then convert it to text format using your own logic.

## Retrieving the ToC in HTML

```php
$parser = new \ParsedownToc();

// Get the Table of Contents in HTML
$tocHTML = $parser->contentsList('html');
```

## Retrieving the ToC in Markdown

```php
// Get the Table of Contents in Markdown
$tocMd = $parser->contentsList('markdown');
```

## Retrieving the ToC in JSON

```php
// Get the Table of Contents in JSON
$tocJSON = $parser->contentsList('json');
```

## Retrieving the ToC in Flat Array

```php
// Get the Table of Contents in Flat Array
$tocFlatArray = $parser->contentsList('flatArray');
```

## Retrieving the ToC in Nested Array

```php
// Get the Table of Contents in Nested Array
$tocNestedArray = $parser->contentsList('nestedArray');
```
