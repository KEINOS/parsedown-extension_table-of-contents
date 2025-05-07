# Basic Usage of ParsedownToC feat. ParsedownExtra

Using [`ParsedownExtra`](https://github.com/erusev/parsedown-extra) extension of `Parsedown`, you can extend the Markdown syntax to include some additional features of [Markdown Extra](https://michelf.ca/projects/php-markdown/extra/) like tables, footnotes, and more.

```markdown
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
```

```html
<h1 id="self-defined-head1" name="self-defined-head1">Head1</h1>
<p>You can include inline HTML tags<br>in the markdown text.</p>
<div>
<p>And use the markdown syntax inside HTML Blocks.</p>
</div>
<table>
<thead>
<tr>
<th>Header1</th>
<th>Header2</th>
</tr>
</thead>
<tbody>
<tr>
<td>Table syntax</td>
<td>as well</td>
</tr>
</tbody>
</table>
<h2 id="self-defined-head2-1" name="self-defined-head2-1">見出し2</h2>
<p>You can customize the anchor IDs of non-ASCII characters, such as Japanese characters, to more readable ones.</p>
```

`ParsedownToC` is also compatible with `ParsedownExtra`, allowing you to generate the table of contents (ToC) with customized anchor IDs.

```html
<ul>
<li><a href="#self-defined-head1">Head1</a>
<ul>
<li><a href="#self-defined-head2-1">見出し2</a></li>
</ul></li>
</ul>
```
