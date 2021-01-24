<?php

class ContextViewExtension extends Minz_Extension
{
    public function init()
    {
        //initializing the extension 
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

        $textPreview = '';

        foreach ($doc->getElementsByTagName('p') as $element)
        {

            $textPreview .= $element->textContent;
            $textPreview .= "&nbsp;";

        }

        // We remove the spaces and see if the text actually has text in <p> otherwise we show nromal text
        $textPreviewCheck = str_replace('&nbsp;', ' ', $textPreview);
        if (strlen($realbriefCheck) <= (count($doc->getElementsByTagName('p')) * 7))
        {
            $textPreview = $doc->textContent;
        }

  
        return $textPreview;
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
		
		$imgHTML = '';
		
        // if it has images
        if (count($imgs))
        {
            $imgSrc = $imgs[0]->getAttribute('src');

			
            if (count($imgs) > 1)
            {
                $imgSrc = $imgs[count($imgs) - 1]->getAttribute('src');
            }

            $imgHTML = "<img src=\"$imgSrc\" alt=\"error\">";

        }
        else
        {
            // this image show up if the entry has no images.
            $imgSrc = Minz_Url::display('/themes/icons/article-no-picture.png');
            $imgHTML = "<img src=\"$imgSrc\" alt=\"error\">";

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

