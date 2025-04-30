<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace, PSR1.Classes.ClassDeclaration

/**
 * ToC Extension/Plugin for Parsedown.
 *
 * It creates a list of contents table from the headings in Markdown text.
 *
 * @package     keinos/ParsedownToC
 * @author      KEINOS (https://github.com/KEINOS/)
 * @author      Contributors (https://github.com/KEINOS/parsedown-extension_table-of-contents/graphs/contributors)
 * @php         >=5.3.0 <8.4 (Currently fails on PHP 8.4)
 * @see         https://github.com/KEINOS/parsedown-extension_table-of-contents/ ReadMe & Usage
 * @see         https://keinos.github.io/parsedown-extension_table-of-contents/  PHPDoc
 * @example     https://github.com/KEINOS/parsedown-extension_table-of-contents/tree/master/examples
 * @license     https://github.com/KEINOS/parsedown-extension_table-of-contents/LICENSE MIT License
 * @copyright   2018-2025 KEINOS and the contributors
*/

// Make it compatible with ParsedownExtra
//   - Feature Implementation from Issue #13 by @qwertygc
//     https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/13
if (class_exists('ParsedownExtra')) {
    class DynamicParent extends \ParsedownExtra
    {
        public function __construct()
        {
            parent::__construct();
        }
    }
} else {
    // Extended class for Parsedown
    class DynamicParent extends \Parsedown
    {
        public function __construct()
        {
            //
        }
    }
}

class ParsedownToC extends DynamicParent
{
    /**
     * ========================================================================
     *  Constants / Properties
     * ========================================================================
     */

    // phpcs:disable PSR12.Properties.ConstantVisibility -- for backward compatibility
    /** Version of this extension */
    const VERSION = '1.3.1';
    /** Version of Parsedown required */
    const VERSION_PARSEDOWN_REQUIRED = '1.7.4';
    /** Default ToC tag */
    const TAG_TOC_DEFAULT = '[toc]';
    /** Default ID attribute for ToC (only for ParsedownExtra) */
    const ID_ATTRIBUTE_DEFAULT = 'toc';
    // phpcs:enable

    /** @var array It holds the heading blocks of the content in array form. */
    protected $contentsListArray = array();
    /** @var string It holds the headings in markdown format string. */
    protected $contentsListString = '';
    /** @var int It holds the initial heading level of the content. */
    protected $firstHeadLevel = 0;
    /** @var string It holds the user defined ToC tag. */
    protected $tag_toc = '';

    /**
     * ========================================================================
     *  Constructor
     * ========================================================================
     */

    /**
     * Version requirement check and parent constructor call.
     *
     * @throws Exception
     * @return void
     */
    public function __construct()
    {
        if (version_compare(\Parsedown::version, self::VERSION_PARSEDOWN_REQUIRED) < 0) {
            $msg_error  = 'Version Error.' . PHP_EOL;
            $msg_error .= '  Parsedown ToC Extension requires a later version of Parsedown.' . PHP_EOL;
            $msg_error .= '  - Current version : ' . \Parsedown::version . PHP_EOL;
            $msg_error .= '  - Required version: ' . self::VERSION_PARSEDOWN_REQUIRED . PHP_EOL;

            throw new Exception($msg_error);
        }

        parent::__construct();
    }


    /**
     * ========================================================================
     *  Methods (in ABC order)
     * ========================================================================
     */

    /**
     * Build hierarchical ToC from a flat toc array.
     *
     * @param array $flatToc Flat list of toc entries.
     * @return array Hierarchical toc as nested array.
     */
    protected function buildNestedToc(array $flatToc)
    {
        $hierarchy = [];
        $stack = [];

        foreach ($flatToc as $item) {
            $level = (int) substr($item['level'], 1); // 'h1' -> 1, etc.
            $entry = [
                'text'     => $item['text'],
                'id'       => $item['id'],
                'level'    => $item['level'], // keep the original level as reference
                'children' => []
            ];

            // If no parent exists, add as top-level entry
            if (empty($stack)) {
                $hierarchy[] = $entry;
                $stack[] = ['level' => $level, 'ref' => &$hierarchy[count($hierarchy) - 1]];

                continue;
            }

            // If deeper than last, add as child
            if ($level > $stack[count($stack) - 1]['level']) {
                $parent = &$stack[count($stack) - 1]['ref'];
                $parent['children'][] = $entry;
                $stack[] = ['level' => $level, 'ref' => &$parent['children'][count($parent['children']) - 1]];

                continue;
            }

            // Pop until we find a shallower level
            while (!empty($stack) && $stack[count($stack) - 1]['level'] >= $level) {
                array_pop($stack);
            }

            // If stack empty, add as top-level entry
            if (empty($stack)) {
                $hierarchy[] = $entry;
                $stack[] = ['level' => $level, 'ref' => &$hierarchy[count($hierarchy) - 1]];

                continue;
            }

            // Else, add as sibling child
            $parent = &$stack[count($stack) - 1]['ref'];
            $parent['children'][] = $entry;
            $stack[] = ['level' => $level, 'ref' => &$parent['children'][count($parent['children']) - 1]];
        }

        return $hierarchy;
    }

    /**
     * Heading process. It retruns the heading block element if the given $Line
     * is a heading element.
     *
     * It extends the parent method: \Parsedown::blockHeader() and creates a
     * ToC list from the heading blocks and stores them. Use "contentsList()"
     * to retrieve the ToC list.
     *
     * @param  array      $Line  Array that Parsedown detected as a block type element.
     * @return void|array        Array of Heading Block.
     * @see                      contentsList()
     */
    #[\Override]
    protected function blockHeader($Line)
    {
        // Use parent blockHeader method to process the $Line to $Block

        /**
         * @var void|array{
         *     element: array{
         *         id: string,
         *         name: string,
         *         text: string,
         *         handler: array{
         *             function: string,
         *             argument: string,
         *             destination: string
         *         },
         *         attributes: array{
         *             id: string,
         *            name: string
         *        }
         *     }
         * } $Block
         */
        $Block = (array) DynamicParent::blockHeader($Line);

        if (empty($Block)) {
            return;
        }

        // Get the text of the heading
        $text = '';
        if (isset($Block['element']['handler']['argument'])) {
            // Compatibility with old Parsedown version
            $text = "{$Block['element']['handler']['argument']}";
        }
        if (isset($Block['element']['text'])) {
            // Current Parsedown
            $text = "{$Block['element']['text']}";
        }

        // Get the heading level. Levels are h1, h2, ..., h6
        $level = "{$Block['element']['name']}";

        // Get the anchor of the heading to link from the ToC list
        $id = isset($Block['element']['attributes']['id']) ?
            $Block['element']['attributes']['id'] : $this->createAnchorID($text);

        // Set/re-set attributes to head tags
        $Block['element']['attributes']['id'] = $id;
        $Block['element']['attributes']['name'] = $id;

        // Add/store the heading element info to the ToC list
        $this->setContentsList(array(
            'text'  => $text,
            'id'    => $id,
            'level' => $level
        ));

        return $Block;
    }

    /**
     * Parses the given markdown string to an HTML string but it leaves the ToC
     * tag as is. It's an alias of the parent method "\DynamicParent::text()".
     *
     * @param  string $text          Markdown string to be parsed.
     * @param  bool   $omit_toc_tag  (Optional) If true, the ToC tag will be excluded from the result. Default is false.
     * @return string                Parsed HTML string.
     */
    public function body($text, $omit_toc_tag = false)
    {
        // Exclude the ToC tag from parsing
        if ($omit_toc_tag) {
            $tag_origin  = $this->getTagToC();

            // replace the ToC tag to empty string
            $text = str_replace($tag_origin, '', $text);

            // Parses the markdown text
            return (string) DynamicParent::text($text);
        }

        $text = $this->encodeTagToHash($text);       // Escapes ToC tag temporary
        $html = (string) DynamicParent::text($text); // Parses the markdown text
        $html = $this->decodeTagFromHash("{$html}"); // Unescape the ToC tag

        return $html;
    }

    /**
     * Returns the parsed ToC.
     * If the arg is "string" then it returns the ToC in HTML string.
     *
     * @param string $type_return  Type of the return format. "string", "json", "flatarray" and "nestedarray".
     *
     * @return false|string|array HTML/JSON string of ToC.
     */
    public function contentsList($type_return = 'string')
    {
        if ('string' === strtolower($type_return)) {
            $result = '';
            if (! empty($this->contentsListString)) {
                // Parses the ToC list in markdown to HTML
                $result = $this->body($this->contentsListString);
            }

            return $result;
        }

        if ('json' === strtolower($type_return)) {
            return json_encode($this->contentsListArray);
        }

        if ('flatarray' === strtolower($type_return)) {
            return $this->contentsListArray;
        }

        if ('nestedarray' === strtolower($type_return)) {
            return $this->buildNestedToc($this->contentsListArray);
        }

        // Log the error and forces to return ToC as "string"
        error_log(
            'Unknown return type given while parsing ToC.'
            . ' At: ' . __FUNCTION__ . '() '
            . ' in Line:' . __LINE__ . ' (Using default type)'
        );

        return $this->contentsList('string');
    }

    /**
     * Generates an anchor text that are link-able even the heading is not in
     * ASCII.
     *
     * @param  string $text
     * @return string
     */
    protected function createAnchorID($text)
    {
        return  urlencode($this->getTextOnly($text));
    }

    /**
     * Decodes the hashed ToC tag to an original tag and replaces.
     *
     * This is used to avoid parsing user defined ToC tag which includes "_" in
     * their tag such as "[[_toc_]]". Unless it will be parsed as:
     *   "<p>[[<em>TOC</em>]]</p>"
     *
     * @param  string $text
     * @return string
     */
    protected function decodeTagFromHash($text)
    {
        $salt = $this->getSalt();
        $tag_origin = $this->getTagToC();
        $tag_hashed = hash('sha256', $salt . $tag_origin);

        if (strpos($text, "$tag_hashed") === false) {
            return $text;
        }

        return str_replace("$tag_hashed", $tag_origin, $text);
    }

    /**
     * Encodes the ToC tag to a hashed tag and replace.
     *
     * This is used to avoid parsing user defined ToC tag which includes "_" in
     * their tag such as "[[_toc_]]". Unless it will be parsed as:
     *   "<p>[[<em>TOC</em>]]</p>"
     *
     * @param  string $text
     * @return string
     */
    protected function encodeTagToHash($text)
    {
        $salt = $this->getSalt();
        $tag_origin = $this->getTagToC();

        if (strpos($text, $tag_origin) === false) {
            return $text;
        }

        $tag_hashed = hash('sha256', $salt . $tag_origin);

        return str_replace($tag_origin, "$tag_hashed", $text);
    }

    /**
     * [Deprecated] Superseded by "getTextOnly()".
     *
     * Get only the text from a markdown string. It parses to HTML once then
     * trims the tags to get the text. It's been replaced by "getTextOnly()".
     *
     * @deprecated It will be removed in the near future. Currently it is
     *             an alias of "getTextOnly()".
     * @see    getTextOnly()
     * @param  string $text  Markdown text.
     * @return string
     */
    protected function fetchText($text)
    {
        return $this->getTextOnly($text);
    }

    /**
     * ------------------------------------------------------------------------
     *  Getters
     * ------------------------------------------------------------------------
     */

     /**
     * Gets the ID attribute of the ToC for HTML tags.
     *
     * @return string
     */
    protected function getIdAttributeToC()
    {
        if (! empty($this->id_toc)) {
            return (string) $this->id_toc;
        }

        return self::ID_ATTRIBUTE_DEFAULT;
    }

    /**
     * Unique string to use as a salt value.
     *
     * @return string
     */
    protected function getSalt()
    {
        static $salt;
        if (isset($salt) && ! empty($salt)) {
            return "$salt";
        }

        $salt = hash('md5', date('dmYHis', time()));

        return "$salt";
    }

    /**
     * Gets the markdown tag for ToC.
     *
     * @return string
     */
    protected function getTagToC()
    {
        if (! empty($this->tag_toc)) {
            return $this->tag_toc;
        }

        return self::TAG_TOC_DEFAULT;
    }

    /**
     * Get only the text from a markdown string.
     *
     * It parses to HTML once then trims the tags to get the text.
     *
     * @param  string $text  Markdown text.
     * @return string
     */
    protected function getTextOnly($text)
    {
        return trim(strip_tags("{$this->line($text)}"));
    }

    /**
     * ------------------------------------------------------------------------
     *  Setters
     * ------------------------------------------------------------------------
     */

    /**
     * Set/stores the heading block to ToC list in a string and array format.
     *
     * @param  array $Content   Heading info such as "level","id" and "text".
     * @return void
     */
    protected function setContentsList(array $Content)
    {
        // Stores as an array
        $this->setContentsListAsArray($Content);
        // Stores as string in markdown list format.
        $this->setContentsListAsString($Content);
    }

    /**
     * Sets/stores the heading block info as an array.
     *
     * @param  array $Content
     * @return void
     */
    protected function setContentsListAsArray(array $Content)
    {
        $this->contentsListArray[] = $Content;
    }

    /**
     * Sets/stores the heading block info as a list in markdown format.
     *
     * @param  array $Content  Heading info such as "level","id" and "text".
     * @return void
     */
    protected function setContentsListAsString(array $Content)
    {
        $text  = $this->getTextOnly("{$Content['text']}");
        $id    = "{$Content['id']}";
        $link  = "[{$text}](#{$id})";
        $level = (int) trim("{$Content['level']}", 'h');

        if ($this->firstHeadLevel === 0) {
            $this->firstHeadLevel = $level;
        }

        $cutIndent = $this->firstHeadLevel - 1;
        if ($cutIndent > $level) {
            $level = 1;
        } else {
            $level = $level - $cutIndent;
        }

        $indent = str_repeat('  ', $level);

        // Stores in markdown list format as below:
        // - [Header1](#Header1)
        //   - [Header2-1](#Header2-1)
        //     - [Header3](#Header3)
        //   - [Header2-2](#Header2-2)
        // ...
        $this->contentsListString .= "{$indent}- {$link}" . PHP_EOL;
    }

    /**
     * Sets the user defined ToC markdown tag.
     *
     * @param  string $tag
     * @return void
     */
    public function setTagToc($tag)
    {
        $tag = trim($tag);
        if (self::escape($tag) === $tag) {
            // Set ToC tag if it's safe
            $this->tag_toc = $tag;
        } else {
            // Do nothing but log
            error_log(
                'Malformed ToC user tag given.'
                . ' At: ' . __FUNCTION__ . '() '
                . ' in Line:' . __LINE__ . ' (Using default ToC tag)'
            );
        }
    }

    /**
     * Parses markdown string to HTML and also the "[toc]" tag as well.
     * It overrides the parent method: \Parsedown::text().
     *
     * @param  string $text
     *
     * @return string
     */
    #[\Override]
    public function text($text)
    {
        // Parses the markdown text except the ToC tag. This also searches
        // the list of contents and available to get from "contentsList()"
        // method.
        $html = $this->body($text);

        $tag_origin  = $this->getTagToC();

        if (strpos($text, $tag_origin) === false) {
            return $html;
        }

        $toc_data = $this->contentsList();
        $toc_id   = $this->getIdAttributeToC();
        $needle  = '<p>' . $tag_origin . '</p>';
        $replace = "<div id=\"{$toc_id}\">{$toc_data}</div>";

        return str_replace($needle, $replace, $html);
    }
}
