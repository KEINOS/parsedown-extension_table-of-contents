<?php
/**
 * Simple script that uses Parsedown and the ToC (Table of Contents) extension.
 *
 * This script receives Markdown text from STDIN and prints out the ToC result.
 */

//error_reporting(E_ALL);

require_once(__DIR__ . '/../../Parsedown.php');
require_once(__DIR__ . '/../../Extension.php');

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
