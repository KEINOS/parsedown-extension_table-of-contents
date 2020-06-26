<?php
/**
 * Common script.
 *
 * This script receives Markdown text from STDIN and prints out the ToC result.
 */

function getMarkdownFromStdIn()
{
    $array = array_map('trim', file('php://stdin'));
    return implode(PHP_EOL, $array);
}

$text_md   = getMarkdownFromStdIn();
$Parsedown = new ParsedownToC();

$body = $Parsedown->text($text_md);
$toc  = $Parsedown->contentsList();

echo $toc;
