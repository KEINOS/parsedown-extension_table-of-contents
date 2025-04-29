# Custom ToC Tag Example

While using the ToC tag replacement feature, you might want to use a custom tag instead of the default `[toc]`. This can be done by using the `setTagToc()` method.

```php
// Instanciate the Parsedown with ToC extension
$Parsedown = new ParsedownToc();

// Set user-defined ToC tag
$Parsedown->setTagToc('[[table of contents]]');
```
