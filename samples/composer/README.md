# Sample Project of Parsedown ToC Extension Using Composer

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

1. Copy the files in this directory to your project directory.
    - composer.json
    - main.php
2. In your project directory run: `composer install`
3. Run the program: `php main.php`

## Detailed usage

Here are the full log sample of how to use it for a brand new project.

```shellsession
$ # Be sure you have composer installed
$ composer --version
Composer version 1.9.0 2019-08-02 20:55:32
$
$ # Create a directory of your project and move
$ mkdir my_project && cd $_
$
$ # Initialize your project with composer
$ composer init --require keinos/parsedown-toc


  Welcome to the Composer config generator



This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [admin/composer]: yourname/yourapp
Description []: sample project
Author [KEINOS <github@keinos.com>, n to skip]: YourName <your@emailaddress.com>
Minimum Stability []: dev
Package Type (e.g. library, project, metapackage, composer-plugin) []: project
License []: WTFPL

Define your dependencies.

Using version dev-master for keinos/parsedown-toc
Would you like to define your dev dependencies (require-dev) interactively [yes]? no

{
    "name": "yourname/yourapp",
    "description": "sample project",
    "type": "project",
    "require": {
        "keinos/parsedown-toc": "dev-master"
    },
    "license": "WTFPL",
    "authors": [
        {
            "name": "YourName",
            "email": "your@emailaddress.com"
        }
    ],
    "minimum-stability": "dev"
}

Do you confirm generation [yes]? yes
Would you like to install dependencies now [yes]? yes
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
$
$ # Current directory state
$ tree
.
├── README.md
├── composer.json
├── main.php
└── vendor
    ├── autoload.php
    └── composer
        ├── ClassLoader.php
        ├── LICENSE
        ├── autoload_classmap.php
        ├── autoload_namespaces.php
        ├── autoload_psr4.php
        ├── autoload_real.php
        ├── autoload_static.php
        └── installed.json
$
$ # Install dependencies
$ composer install
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
  - Installing erusev/parsedown (1.8.0-beta-7): Loading from cache
  - Installing keinos/parsedown-toc (dev-master cd90c3f): Cloning cd90c3fd0a from cache
Writing lock file
Generating autoload files
$
$ # Current directory state
$ tree
.
├── README.md
├── composer.json
├── composer.lock
├── main.php
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
            ├── composer.json
            ├── sample-composer.php
            └── tests
                ├── parser.php
                ├── run-tests.sh
                ├── test_1.sh
                └── test_2.sh

7 directories, 27 files
$
$ # Create main program
$ vi main.php
...(edit your code here)...
$
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
