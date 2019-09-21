<?php
/**
 * ToC Extension/Plugin for Parsedown.
 * ============================================================================
 * It creates a list of contents table from headings.
 *
 * @author    KEINOS (https://github.com/KEINOS/)
 * @package   Parsedown ^1.7 (https://github.com/erusev/parsedown)
 * @php       ^5.6.40
 * @see       Howto: https://github.com/KEINOS/parsedown-extension_table-of-contents/
 * @license   https://github.com/KEINOS/parsedown-extension_table-of-contents/LICENSE
*/

// Old version compatibility
class Extension extends ParsedownToC{}

class ParsedownToC extends \Parsedown
{
    const TAG_TOC = '[toc]';

    /* ========================================================================
      Methods/Functions (in ABC order)
    ======================================================================== */

    // Overriding parent method: \Parsedown::blockHeader()
    protected function blockHeader($Line)
    {
        if (isset($Line['text'][1])) {
            $Block = \Parsedown::blockHeader($Line);

            // Compatibility with old Parsedown Version
            if (isset($Block['element']['handler']['argument'])) {
                $text = $Block['element']['handler']['argument'];
            }

            if (isset($Block['element']['text'])) {
                $text = $Block['element']['text'];
            }

            $level = $Block['element']['name'];    //levels are h1, h2, ..., h6
            $id    = $this->createAnchorID($text);

            //Set attributes to head tags
            $Block['element']['attributes'] = array(
                'id'   => $id,
                'name' => $id,
            );

            $this->setContentsList(array(
                'text'  => $text,
                'id'    => $id,
                'level' => $level
            ));

            return $Block;
        }
    }

    // Alias of parent method: \Parsedown::text()
    public function body($text)
    {
        return \Parsedown::text($text);
    }

    public function contentsList($type_return = 'string')
    {
        if ('string' === strtolower($type_return)) {
            $result = '';
            if (! empty($this->contentsListString)) {
                $result = $this->body($this->contentsListString);
            }
            return $result;
        }
        if ('json' === strtolower($type_return)) {
            return json_encode($this->contentsListArray);
        }

        error_log(
            'Unknown return type given while parsing ToC.'
            . ' At: ' . __FUNCTION__ . '() '
            . ' in Line:' . __LINE__ . ' (Using default type)'
        );
        return $this->contentsList('string');
    }

    protected function createAnchorID($text)
    {
        return  urlencode($this->fetchText($text));
    }

    protected function fetchText($text)
    {
        return trim(strip_tags($this->line($text)));
    }

    protected function replaceTagToC($html){
        $toc     = $this->contentsList();
        $needle  = '<p>' . self::TAG_TOC . '</p>';
        $replace = '<div id="toc">' . $toc . '</div>';

        return str_replace($needle, $replace, $html);
    }

    protected function setContentsList(array $Content)
    {
        $this->setContentsListAsArray($Content);
        $this->setContentsListAsString($Content);
    }

    protected function setContentsListAsArray(array $Content)
    {
        $this->contentsListArray[] = $Content;
    }
    protected $contentsListArray = array();

    protected function setContentsListAsString(array $Content)
    {
        $text  = $this->fetchText($Content['text']);
        $id    = $Content['id'];
        $level = (integer) trim($Content['level'], 'h');
        $link  = "[${text}](#${id})";

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

        $this->contentsListString .= "${indent}- ${link}\n";
    }
    protected $contentsListString = '';
    protected $firstHeadLevel = 0;

    // Overriding parent method: \Parsedown::text()
    public function text($text)
    {
        $body = $this->body($text);

        if( strpos($text, self::TAG_TOC) === false ){
            return $body;
        }

        return $this->replaceTagToC($body);
    }

}
