<?php

require_once(__DIR__ . '/assertion.php');
require_once(__DIR__ . '/../../Parsedown.php');
require_once(__DIR__ . '/../../Extension.php');

$description = 'feature #22: allow omit the ToC tag in the body of the document';

$input = <<<'HEREDOC'
# FooBar

`FooBar` is a library to ...

[toc]

## Installation

Do some weird stuff right now.
HEREDOC;

// Golden case
$expect = <<<'HEREDOC'
<h1 id="FooBar" name="FooBar">FooBar</h1>
<p><code>FooBar</code> is a library to ...</p>
<h2 id="Installation" name="Installation">Installation</h2>
<p>Do some weird stuff right now.</p>
HEREDOC;

// Run the test
$Parsedown = new ParsedownToc();

$omitToC = true;
$actual = $Parsedown->body($input, $omitToC);

assertEqual($description, $actual, $expect) ? exit(0) : exit(1);
