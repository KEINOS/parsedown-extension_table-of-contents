<?php

/**
 * Simple script that uses Parsedown/ParsedownExtra and the ToC (Table of Contents) extension.
 *
 * This script receives Markdown text from STDIN and prints out the ToC result.
 */

//error_reporting(E_ALL);

require_once(__DIR__ . '/../../Parsedown.php');
require_once(__DIR__ . '/../../ParsedownExtra.php');
require_once(__DIR__ . '/../../Extension.php');
require_once(__DIR__ . '/parser-common.php');
