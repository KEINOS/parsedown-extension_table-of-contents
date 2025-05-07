<?php

/**
 * This script downloads the latest version from the "master" branch of Parsedown
 * from GitHub and checks its license.
 *
 * It is intended to be run from the command line to update the "Parsedown.php" to
 * keep it up-to-date.
 */

const URL_DOWNLOAD_MASTER  = 'https://raw.githubusercontent.com/erusev/parsedown-extra/refs/heads/master/ParsedownExtra.php';
const URL_DOWNLOAD_LICENSE = 'https://raw.githubusercontent.com/erusev/parsedown-extra/refs/heads/master/LICENSE.txt';
const NAME_FILE_SCRIPT  = 'ParsedownExtra.php';
const NAME_FILE_LICENSE = 'LICENSE.txt';
const DIR_SEP = DIRECTORY_SEPARATOR;
const SUCCESS = 0;
const FAILURE = 1;

// Download Parsedown.php
if (!copy(URL_DOWNLOAD_MASTER, __DIR__ . DIR_SEP . NAME_FILE_SCRIPT)) {
    fwrite(STDERR, 'Error: failed to download Parsedown.php' . PHP_EOL);
    exit(FAILURE);
}

// Download LICENSE.txt
if (!copy(URL_DOWNLOAD_LICENSE, __DIR__ . DIR_SEP . NAME_FILE_LICENSE)) {
    fwrite(STDERR, 'Error: failed to download LICENSE.txt' . PHP_EOL);
    exit(FAILURE);
}

// Ensure if LICENSE.txt exists
$licensePath = __DIR__ . DIR_SEP . NAME_FILE_LICENSE;
if (!file_exists($licensePath)) {
    fwrite(STDERR, 'Error: can not find LICENSE.txt' . PHP_EOL);
    exit(FAILURE);
}

// Verify the license file contains 'MIT License'
$licenseContent = file_get_contents($licensePath);
if (strpos($licenseContent, 'MIT License') === false) {
    fwrite(STDERR, 'Error: not MIT license. The license of Parsedown has been changed! Please check it.' . PHP_EOL);
    exit(FAILURE);
}

// Calculate SHA256 checksum for Parsedown.php and create a BSD-style checksum file
$parsedownPath   = __DIR__ . DIR_SEP . NAME_FILE_SCRIPT;
$checksum        = hash_file('sha256', $parsedownPath);
$checksumFile    = __DIR__ . DIR_SEP . NAME_FILE_SCRIPT . '.sha256';
$checksumContent = "SHA256 (Parsedown.php) = " . $checksum . PHP_EOL;

if (file_put_contents($checksumFile, $checksumContent) === false) {
    fwrite(STDERR, 'Error: failed to create Parsedown.php.sha256' . PHP_EOL);
    exit(FAILURE);
}

echo "Parsedown updated successfully." . PHP_EOL;
exit(SUCCESS);
