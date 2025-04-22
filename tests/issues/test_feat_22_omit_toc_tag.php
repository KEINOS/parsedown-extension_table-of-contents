<?php

require_once(__DIR__ . '/assertion.php');
require_once(__DIR__ . '/../../Parsedown.php');
require_once(__DIR__ . '/../../Extension.php');

// Common test data
$input = <<<'HEREDOC'
# FooBar

`FooBar` is a library to ...

[toc]

## Installation

Do some weird stuff right now.
HEREDOC;

// Expected output
$expect_omit = <<<'HEREDOC'
<h1 id="FooBar" name="FooBar">FooBar</h1>
<p><code>FooBar</code> is a library to ...</p>
<h2 id="Installation" name="Installation">Installation</h2>
<p>Do some weird stuff right now.</p>
HEREDOC;

$expect_not_omit = <<<'HEREDOC'
<h1 id="FooBar" name="FooBar">FooBar</h1>
<p><code>FooBar</code> is a library to ...</p>
<p>[toc]</p>
<h2 id="Installation" name="Installation">Installation</h2>
<p>Do some weird stuff right now.</p>
HEREDOC;

// Test cases
$tests = [
    [
        'description' =>  'enable to omit the ToC tag in the body of the document',
        'input' => $input,
        'expect' => $expect_omit,
        'omitToC' => true,
    ],
    [
        'description' =>  'disable to omit the ToC tag in the body of the document (default)',
        'input' => $input,
        'expect' => $expect_not_omit,
        'omitToC' => false,
    ]
];

// Begin test
$Parsedown = new ParsedownToc();
$assert = new Assertion(str_repeat(' ', 2));
$failed = 0;

echo "feature #22: option arg to exclude ToC tag in `body`" . PHP_EOL;
foreach ($tests as $index => $test) {
    $title = "- test #" . ($index + 1) . ": " . $test['description'];

    $expect = $test['expect'];
    $actual = $Parsedown->body($test['input'], $test['omitToC']);

    if (!$assert->equal($title, $actual, $expect)) {
        $failed += 1;
    }
}

exit($failed);
