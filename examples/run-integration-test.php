<?php

/**
 * ParsedownToc Integration Test
 *
 * Run this script to test all examples in this examples directory.
 * This script runs each example (index.php) in the examples directory and
 * compares the output to the "expected_out.txt" file.
 */

namespace ParsedownTocExamples;

/**
 * ----------------------------------------------------------------------------
 *  Main
 * ----------------------------------------------------------------------------
 */

const NAME_FILE_SCRIPT = 'index.php';
const NAME_FILE_EXPECTED = 'expected_out.txt';

$paths = getExampleDirectories(__DIR__);
if (empty($paths)) {
    echo "❗️ No example directories found." . PHP_EOL;
    exit(1);
}

$test_failure = 0;
$test_suceeds = 0;

foreach ($paths as $path_dir_example) {
    $path_file_example = $path_dir_example . DIRECTORY_SEPARATOR . NAME_FILE_SCRIPT;
    $path_file_expected = $path_dir_example . DIRECTORY_SEPARATOR . NAME_FILE_EXPECTED;

    $originalDir = getcwd();

    // Run the script and compare the output
    chdir($path_dir_example);
    $is_match = runScript($path_file_example, $path_file_expected);
    chdir($originalDir);

    !$is_match ? $test_failure++ : $test_suceeds++;
}

echo PHP_EOL;

$test_count = $test_failure + $test_suceeds;

exitIfFalse(
    $test_failure === 0,
    "❗️ Test(s) failed: ${test_failure}, success: ${test_suceeds} out of ${test_count} examples."
);

echo "🎉 Test passed for all ${test_count} examples." . PHP_EOL;

/**
 * ----------------------------------------------------------------------------
 *  Helper Functions
 * ----------------------------------------------------------------------------
 */

/**
 * Exit the script with status 1 if the condition is false and print a message.
 *
 * @param bool $condition The condition to check
 * @param string $message The message to display if the condition is false
 */
function exitIfFalse($condition, $message)
{
    if (!$condition) {
        echo $message . PHP_EOL;
        exit(1);
    }
}

/**
 * Get example directories that contain both "index.php" and "expected_out.txt" files.
 *
 * @param string $baseDir The base directory to search for examples
 * @return array An array of directories containing examples
 */
function getExampleDirectories($baseDir)
{
    $directories = array();
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($baseDir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isDir()) {
            $dir = $fileInfo->getPathname();
            if (
                file_exists($dir . DIRECTORY_SEPARATOR . NAME_FILE_SCRIPT) &&
                file_exists($dir . DIRECTORY_SEPARATOR . NAME_FILE_EXPECTED)
            ) {
                $directories[] = $dir;
            }
        }
    }

    return $directories;
}

/**
 * Run the script in an isolated process and compare the output.
 *
 * @param string $path_file_script The path to the script to run
 * @param string $path_file_expected The path to expected output to compare against
 * @return bool True if the output matches, false otherwise
 */
function runScript($path_file_script, $path_file_expected)
{
    // Retrieve the expected output from the file
    $expected_output = file_get_contents($path_file_expected);
    if (!$expected_output) {
        echo "❗️ Failed to read expected output file: ${path_file_expected}" . PHP_EOL;
        return false;
    }

    // Build command to run the script in a separate PHP process
    $command = 'php ' . escapeshellarg($path_file_script);
    // Execute the command and capture the output
    $output = shell_exec($command);

    // Normalize line breaks to PHP_EOL
    $expected_normalized = str_replace("\n", PHP_EOL, str_replace(array("\r\n", "\r"), "\n", $expected_output));
    $output_normalized   = str_replace("\n", PHP_EOL, str_replace(array("\r\n", "\r"), "\n", $output));

    // Compare the output with the expected output
    if ($output_normalized === $expected_normalized) {
        echo "✅ Test passed for script: ${path_file_script}" . PHP_EOL;

        return true;
    }

    // Show the error message
    echo "❗️ Test failed for script: ${path_file_script}" . PHP_EOL;
    echo "* Expected:" . PHP_EOL . $expected_normalized . PHP_EOL;
    echo "* Got:" . PHP_EOL . $output_normalized . PHP_EOL;

    // Show the diff
    echo "* Diff:" . PHP_EOL;
    $expectedLines = explode(PHP_EOL, $expected_normalized);
    $outputLines   = explode(PHP_EOL, $output_normalized);
    $maxLines = max(count($expectedLines), count($outputLines));
    for ($i = 0; $i < $maxLines; $i++) {
        $eLine = isset($expectedLines[$i]) ? $expectedLines[$i] : '';
        $oLine = isset($outputLines[$i]) ? $outputLines[$i] : '';
        if ($eLine !== $oLine) {
            echo "  Line " . ($i + 1) . ":\n";
            echo "    * Expected: $eLine\n";
            echo "    * Got     : $oLine\n";
        }
    }

    return false;
}
