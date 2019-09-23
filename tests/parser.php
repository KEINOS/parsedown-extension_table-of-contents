<?php
//error_reporting(E_ALL);

require_once('Parsedown.php');
require_once('../Extension.php');

function getMarkdownFromStdIn()
{
    $Array = array_map('trim', file('php://stdin'));
    return implode(PHP_EOL, $Array);
}

$text_md   = getMarkdownFromStdIn();
$Parsedown = new ParsedownToC();

$body = $Parsedown->text($text_md);
$toc  = $Parsedown->contentsList();

echo $toc;

/*
echo 'ToC:', PHP_EOL;
echo $toc, PHP_EOL;
echo 'Body:', PHP_EOL;
echo $body;
*/