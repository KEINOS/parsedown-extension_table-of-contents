# Sample Project of Parsedown ToC Extension Using Composer

1. Create and Move to you project directory.
2. Install dependencies of your project by: `composer require keinos/parsedown-toc`
3. Create and Edit the main script. (Copy and paste the sample script below)
4. Create and Edit a Markdown file. (`SAMPLE.md`)
5. Run the program: `php main.php`

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$textMarkdown = file_get_contents('SAMPLE.md');

$Parsedown = new ParsedownToc();
$body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC . PHP_EOL;
echo $body . PHP_EOL;
```

## Detailed usage

Here's the full log sample of how to use it for a brand new project.

```shellsession
$ # Be sure you have composer installed
$ composer --version
Composer version 1.9.0 2019-08-02 20:55:32

$ # Create a directory of your project and move
$ mkdir my_project && cd $_

$ # Require packages to be uses in your project.
$ # (In this case "keinos/parsedown-toc". This will install other related dependencies also.)
$ composer require keinos/parsedown-toc
Using version ^1.0 for keinos/parsedown-toc
./composer.json has been created
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
  - Installing erusev/parsedown (1.7.3): Downloading (100%)
  - Installing keinos/parsedown-toc (1.0.1): Downloading (100%)
Writing lock file
Generating autoload files

$ # Current directory state
$ tree
.
├── composer.json
├── composer.lock
└── vendor
    ├── autoload.php
    ├── composer
    │   ├── ClassLoader.php
    │   ├── LICENSE
    │   ├── autoload_classmap.php
    │   ├── autoload_files.php
    │   ├── autoload_namespaces.php
    │   ├── autoload_psr4.php
    │   ├── autoload_real.php
    │   ├── autoload_static.php
    │   └── installed.json
    ├── erusev
    │   └── parsedown
    │       ├── LICENSE.txt
    │       ├── Parsedown.php
    │       ├── README.md
    │       └── composer.json
    └── keinos
        └── parsedown-toc
            ├── Extension.php
            ├── LICENSE
            ├── README.md
            └── composer.json

6 directories, 20 files

$ # Create main program
$ vi main.php
...(edit/copy/paste your code here)...

$ # View main program
$ cat main.php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$textMarkdown =<<<EOL
# Head1
Sample text of head 1.
## Head1-1
Sample text of head 1-1.
# Head2
Sample text of head 2.
## 見出し2-1
Sample text of head2-1.
EOL;

$Parsedown = new ParsedownToc();
$body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC . PHP_EOL;
echo '<hr>' . PHP_EOL;
echo $body . PHP_EOL;

$ # Run the main program
$ php main.php
<ul>
<li><a href="#Head1">Head1</a><ul>
<li><a href="#Head1-1">Head1-1</a></li>
</ul>
</li>
<li><a href="#Head2">Head2</a><ul>
<li><a href="#%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</a></li>
</ul>
</li>
</ul>
<hr>
<h1 id="Head1" name="Head1">Head1</h1>
<p>Sample text of head 1.</p>
<h2 id="Head1-1" name="Head1-1">Head1-1</h2>
<p>Sample text of head 1-1.</p>
<h1 id="Head2" name="Head2">Head2</h1>
<p>Sample text of head 2.</p>
<h2 id="%E8%A6%8B%E5%87%BA%E3%81%972-1" name="%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</h2>
<p>Sample text of head2-1.</p>

```
