# Custom ToC Tag Example

While using the ToC tag replacement feature, you might want to use a custom tag instead of the default `[toc]`. This can be done by using the `setTagToc()` method.

```php
// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Set user-defined ToC tag
$parser->setTagToc('[[table of contents]]');
```
