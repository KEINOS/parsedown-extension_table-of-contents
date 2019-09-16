<?php

require_once('Parsedown.php');
require_once('../Extension.php');

function getMarkdownFromStdIn()
{
    $array = array_map('trim', file('php://stdin'));
    return implode(PHP_EOL, $array);
}

$textMarkdown = getMarkdownFromStdIn();
$Parsedown    = new ParsedownToc();

$body = $Parsedown->text($textMarkdown);
$ToC  = $Parsedown->contentsList();

echo $ToC;
