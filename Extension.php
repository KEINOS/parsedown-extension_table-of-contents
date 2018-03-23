<?php
/**
 * ToC Extension/Plugin for Parsedown.
 *
 * It creates a list of contents table from headings.
 *
 * @version 20180122-1859
 * @author KEINOS (https://github.com/KEINOS/)
 * @package Parsedown (https://github.com/erusev/parsedown)
 * @see How to: https://github.com/KEINOS/parsedown-extension_table-of-contents/
 * @license https://github.com/KEINOS/parsedown-extension_table-of-contents/LICENSE
 */
class Extension extends Parsedown
{
    protected function fetchText($Text)
    {
        return trim(strip_tags($this->line($Text)));
    }

    protected function createAnchorID($Text)
    {
        return  urlencode($this->fetchText($Text));
    }

    #
    # Setters
    #
    function setContentsListAsArray(bool $outListAsArray)
    {
        $this->contentsListAsArray = $outListAsArray;

        return $this;
    }

    protected $contentsListAsArray = false;

    #
    # contents list
    #
    function contentsList()
    {
        if(! empty($this->contentsListString)){
            return $this->text( $this->contentsListString );
        }
    }

    protected function setContentsList($Content)
    {
        $id     = $Content['id'];
        $text   = $this->fetchText($Content['text']);
        $link   = "[${text}](#${id})";
        $level  = (integer) trim($Content['level'],'h');

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

    #
    # Header
    #
    protected function blockHeader($Line)
    {
        if (isset($Line['text'][1])) {

            $Block = Parsedown::blockHeader($Line);

            $text  = $Block['element']['text'];
            $level = $Block['element']['name'];    //h1,h2..h6
            $id    = $this->createAnchorID($text);

            //Set attributes to head tags
            $Block['element']['attributes'] = [
                'id'   => $id,
                'name' => $id,
            ];

            $this->setContentsList([
                'text'  => $text,
                'id'    => $id,
                'level' => $level
            ]);

            return $Block;
        }
    }

}
