# Get Only The Table of Contents (ToC) in HTML and JSON

Once parsed by `text()` or `body()` method, you can retrieve only the table of contents (ToC) in various format using `contentsList()` method.

This is useful if you want to display the ToC separately or use it in a different context.

The method `contentsList()` accepts a parameter that defines the format of the output. The available formats are:

- `"string"`: Returns the ToC in HTML format.
- `"json"`: Returns the ToC in JSON format.
- `"flatArray"`: Returns the ToC in one dimensional array format.
- `"nestedArray"`: Returns the ToC in array format with nested structure.

## Retrieving the ToC in HTML

```php
// Get the Table of Contents in HTML
$tocHTML = $Parsedown->contentsList('string');
```

## Retrieving the ToC in JSON

```php
// Get the Table of Contents in JSON
$tocJSON = $Parsedown->contentsList('json');
```

## Retrieving the ToC in Flat Array

```php
// Get the Table of Contents in Flat Array
$tocFlatArray = $Parsedown->contentsList('flatArray');
```

## Retrieving the ToC in Nested Array

```php
// Get the Table of Contents in Nested Array
$tocNestedArray = $Parsedown->contentsList('nestedArray');
```
