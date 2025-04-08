# Examples

This directory includes the below 2 examples to use this parsedown ToC extension.

> [!IMPORTANT]
> These examples supports PHP 5.3 to 8.3. They do NOT work on PHP 8.4 or later.

```text
/examples
├── README.md
├── Dockerfile ...... Dockerfile to run the examples in PHP 8.3 container
├── composer/  ...... Examples using composer. (The easy and reliable way)
└── download/  ...... Examples including Parsedown.php. (The ordinary way)
```

> [!NOTE]
> These examples are not included in the [Packagist](https://packagist.org/packages/keinos/parsedown-toc) archive. See [Issue #9](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/9) for the reason.

## For Docker users

If your PHP version is 8.4 or later (macOS for example), you can use the Dockerfile in this directory to run the examples.

```shellsession
$ # cd to this directory
$ ls
Dockerfile  README.md   composer    download

$ # Build the image
$ docker build -t test:local .
**snip**
```

```shellsession
$ # Run the container with the current directory mounted to /app
$ docker run --rm -it -v "$(pwd)":/app test:local /bin/sh
/app # composer --version
Composer version 2.8.6 2025-02-25 13:03:50
PHP version 8.3.19 (/usr/local/bin/php)
Run the "diagnose" command to get more detailed diagnostics output.

/app # ls
Dockerfile  README.md   composer    download

/app # cd download

/app/download # php ./main.php

<div id='toc'>
<h2>Table of Contents</h2>
<ul>
<li><a href="#Head1">Head1</a>
<ul>
<li><a href="#Head1-1">Head1-1</a></li>
</ul></li>
<li><a href="#Head2">Head2</a>
<ul>
<li><a href="#%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</a></li>
</ul></li>
</ul>
</div>
<div id='contents'>
<h2>Contents</h2>
<h1 id="Head1" name="Head1">Head1</h1>
<p>Sample text of head 1.</p>
<h2 id="Head1-1" name="Head1-1">Head1-1</h2>
<p>Sample text of head 1-1.</p>
<h1 id="Head2" name="Head2">Head2</h1>
<p>Sample text of head 2.</p>
<h2 id="%E8%A6%8B%E5%87%BA%E3%81%972-1" name="%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</h2>
<p>Sample text of head2-1.</p>
</div>

```
