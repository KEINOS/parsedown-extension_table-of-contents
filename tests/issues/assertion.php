<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

class Assertion
{
    /**
     * Properties
     */

    /** @var string It holds the indentation string. */
    protected $indent = "";

    /**
     * Constructor
     *
     * @param string $indent  Indentation string.
     */
    public function __construct($indent)
    {
        $this->indent = $indent;
    }

    private function msgDetails($actual, $expect)
    {
        $indentDouble = str_repeat($this->indent, 2);
        $indentTriple = str_repeat($this->indent, 3);

        return $indentDouble . "- Expected:\n" . preg_replace('/^/m', $indentTriple, $expect) . PHP_EOL .
               $indentDouble . "- Actual:\n"   . preg_replace('/^/m', $indentTriple, $actual) . PHP_EOL;
    }

    /**
     * Returns true if $actual and $expect strings are equal.
     * It will print out the result of the test as well.
     *
     * @param  string $description  Description of the test.
     * @param  string $actual       Actual result.
     * @param  string $expect       Expected result.
     * @return bool                 True if $actual and $expect are equal.
     */
    public function equal($description, $actual, $expect)
    {
        echo $this->indent;

        if ($actual !== $expect) {
            echo $description . " ... NG (inputs should be equal)" . PHP_EOL;
            echo $this->msgDetails($actual, $expect);

            return false;
        }

        echo $description . " ... OK" . PHP_EOL;

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
    public function notEqual($description, $actual, $expect)
    {
        echo $this->indent;

        if ($actual == $expect) {
            echo $description . " ... NG (input should not be equal)" . PHP_EOL;
            echo $this->msgDetails($actual, $expect);

            return false;
        }

        echo $description . " ... OK" . PHP_EOL;

        return true;
    }
}
