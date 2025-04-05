<?php

/**
 * Returns true if $actual and $expect strings are equal.
 * It will print out the result of the test as well.
 *
 * @param  string $description  Description of the test.
 * @param  string $actual       Actual result.
 * @param  string $expect       Expected result.
 * @return bool                 True if $actual and $expect are equal.
 */
function assertEqual($description, $actual, $expect)
{
    if ($actual !== $expect) {
        echo $description . " ... NG (inputs should be equal)\n";
        echo "  - Expected:\n" . preg_replace('/^/m', '    ', $expect) . "\n";
        echo "  - Actual:\n"   . preg_replace('/^/m', '    ', $actual) . "\n";

        return false;
    }

    echo $description . " ... OK\n";

    return true;
}

/**
 * Returns true if $actual and $expect strings are NOT equal.
 * It will print out the result of the test as well.
 *
 * @param  string $description  Description of the test.
 * @param  string $actual       Actual result.
 * @param  string $expect       Expected result.
 * @return bool                 True if $actual and $expect are not equal.
 */
function assertNotEqual($description, $actual, $expect)
{
    if ($actual == $expect) {
        echo $description . " ... NG (input should not be equal)\n";
        echo "  - Expected:\n" . preg_replace('/^/m', '    ', $expect) . "\n";
        echo "  - Actual:\n"   . preg_replace('/^/m', '    ', $actual) . "\n";

        return false;
    }

    echo $description . " ... OK\n";

    return true;
}
