<?php

class ContextViewExtension extends Minz_Extension
{
    public function init()
    {
        
    }
	
    public static function addABriefInEntryHeader($entry)
    {

        $content = $entry->content();

        if (empty($content))
        {
            return $content;
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

        $doc->preserveWhiteSpace = true;
        $doc->formatOutput = true;

        $realbreif = '';

        foreach ($doc->getElementsByTagName('p') as $element)
        {

            $realbreif .= $element->textContent;
            $realbreif .= "&nbsp;";

        }

        // We remove the spaces and see if the text actually has text in <p> otherwise we show nromal text
        $realbriefCheck = str_replace('&nbsp;', ' ', $realbreif);
        if (strlen($realbriefCheck) <= (count($doc->getElementsByTagName('p')) * 7))
        {
            $realbreif = $doc->textContent;
        }

        $brief = $realbreif;
        return $brief;
    }

    public static function imageInEntryHeader($entry)
    {

        $content = $entry->content();

        if (empty($content))
        {
            return $content;
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

        $imgs = $doc->getElementsByTagName('img');

        // if it has images
        if (count($imgs))
        {
            $newSrc = $imgs[0]->getAttribute('src');
            $imgHTML = '';

            if (count($imgs) > 1)
            {

                $newSrc = $imgs[count($imgs) - 1]->getAttribute('src');

            }

            $imgHTML .= "<br>";
            $imgHTML .= "<img    src=\"$newSrc\" alt=\"error\">";

        }
        else
        {
            // this image show if the entry has no images.
            $newSrc = '../themes/icons/article-no-picture.png';
            $imgHTML .= "<br>";
            $imgHTML .= "<img width='32' src=\"$newSrc\" alt=\"error\">";

        }

        return $imgHTML;
    }

    public static function humanTiming($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'y',
            2592000 => 'mo',
            604800 => 'w',
            86400 => 'd',
            3600 => 'h',
            60 => 'm',
            1 => 's'
        );

        foreach ($tokens as $unit => $text)
        {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . '' . $text . (($numberOfUnits > 1) ? '' : '');
        }

    }

}

