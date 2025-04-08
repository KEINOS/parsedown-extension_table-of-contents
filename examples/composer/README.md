# Example Project of Parsedown ToC Extension Using Composer

```shellsession
$ # cd to this directory
$ cd examples/composer

$ ls
README.md      composer.json  main.php

$ # Install the dependencies via composer
$ composer install
No composer.lock file present. Updating dependencies to latest instead of installing from lock file. See https://getcomposer.org/install for more information.
Loading composer repositories with package information
Updating dependencies
Lock file operations: 2 installs, 0 updates, 0 removals
  - Locking erusev/parsedown (1.7.4)
  - Locking keinos/parsedown-toc (dev-master 1574c24)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
  - Downloading erusev/parsedown (1.7.4)
  - Downloading keinos/parsedown-toc (dev-master 1574c24)
  - Installing erusev/parsedown (1.7.4): Extracting archive
  - Installing keinos/parsedown-toc (dev-master 1574c24): Extracting archive
Generating autoload files

$ php ./main.php
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

- If your PHP version is 8.4 or later (macOS for example), you can use the Dockerfile in the parent directory to run the examples.
