# Custiom ID attribute of DIV tag for ToC

```diff
- <div id="toc"><ul>
+ <div id="my-custom-id"><ul>
**snip**
</ul></div>
```

```php
// Instanciate the Parsedown with ToC extension
$parser = new \ParsedownToc();

// Set the ToC ID attribute to a custom value
$parser->setIdAttributeToC("my-custom-id");

// Get the parsed HTML and the ToC
$html = $parser->text($textMarkdown);
```

By default, the `text()` method parses the Markdown text and generates the HTML output, including a Table of Contents (ToC) if a ToC tag is specified.

In that case, the HTML for the ToC is wrapped in a `<div>` element with the ID attribute as `toc`, such as "`<div id="toc">...(your ToC here)...</div>`".

This is useful for styling or linking to the ToC in your HTML document.

However, you can **use the `setIdAttributeToC()` method to set a custom ID attribute** for the ToC `<div>` element. Especially, when the IDs are conflicting with existing IDs in your HTML or if you want to use a different ID for styling or linking purposes.

---

- Ref: [Flexible "id" arribute value rather than fixed "toc" #15](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/15)
