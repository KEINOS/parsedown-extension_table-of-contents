<?php

// phpcs:disable PSR1.Files.SideEffects -- ignore declaration for new symbols
/**
 *  Common script.
 * ============================================================================
 * This script receives Markdown text from STDIN and prints out the ToC result.
 */

$text_markdown = getMarkdownFromStdIn();
$list_methods  = getMethodsToExecute();
$type_return   = getReturnTypeFromArg();

$Parsedown = new ParsedownToC();
$Parsedown = execMethods($Parsedown, $list_methods);

$body = $Parsedown->text($text_markdown);
$toc  = $Parsedown->contentsList();

if ($type_return === 'body') {
    echo $body;
} else {
    echo $toc;
}

exit;

/**
 * ----------------------------------------------------------------------------
 *  Functions
 * ----------------------------------------------------------------------------
 */

/**
 * Executes the methods given
 *
 * @param  ParsedownToC $obj
 * @param  array        $list_methods
 * @return ParsedownToC
 */
function execMethods($obj, $list_methods)
{
    if (empty($list_methods)) {
        return $obj;
    }

    foreach ($list_methods as $option) {
        // Get method name to execute
        $method_name  = $option['method'];
        // Get arg values of the method and execute.
        // To make it compatible with PHP ^5.1, we don't use variable-length
        // argument lists such as "$function(...$args)" but a simpler way.
        $num_args = count($option['arg']);
        switch ($num_args) {
            case '1':
                $obj->$method_name($option['arg'][0]);
                break;
            case '2':
                $obj->$method_name($option['arg'][0], $option['arg'][1]);
                break;
            case '3':
                $obj->$method_name($option['arg'][0], $option['arg'][1], $option['arg'][2]);
                break;
        }
    }

    return $obj;
}

/**
 * @return string
 */
function getMarkdownFromStdIn()
{
    $array = array_map('trim', file('php://stdin'));

    return implode(PHP_EOL, $array);
}

/**
 * Get list of the methods and it's values to be executed. The lists should be
 * in JSON and assigned to "USE_METHODS" variable in each "test_*.sh" script.
 *
 * - For the sample settings see: ../test_vanilla_user_defined_toc_tag_style1.sh
 *
 * @return array
 */
function getMethodsToExecute()
{
    $return_as_assoc_array = true;

    // Get JSON string of methods and it's arg values from the command arg
    // to be executed as an array.
    $json  = getStringFromArg();
    $array = json_decode($json, $return_as_assoc_array);

    if (empty($array)) {
        return array();
    }

    return $array;
}

/**
 * Get arg value of '-r' option from command line.
 * This value should be either 'toc' or 'body'.
 *
 * @return string
 */
function getReturnTypeFromArg()
{
    global $argc;

    $type_return_default = 'toc';

    if ($argc == 1) {
        return $type_return_default;
    }

    // Get '-r' arg value
    $options = getopt('r:');
    if (! isset($options['r'])) {
        return $type_return_default;
    }

    return ($options['r'] == 'body') ? 'body' : $type_return_default;
}

/**
 * Get arg value of '-j' option from command line.
 *
 * @return string
 */
function getStringFromArg()
{
    global $argc;

    if ($argc == 1) {
        return '';
    }

    // Get '-j' arg value
    $options = getopt('j:');
    if (! isset($options['j'])) {
        return '';
    }

    return stripslashes($options['j']);
}
