<?php

use Illuminate\Support\Facades\App;
use Stichoza\GoogleTranslate\GoogleTranslate;

/**
 * Function to translate HTML content while preserving tags.
 *
 * @param string $html The HTML content to translate.
 * @param string $targetLang The target language code.
 * @return string The translated HTML content.
 */
function translateWithHTMLTags($html, $targetLang = null)
{

    $targetLang = $targetLang ?? App::getLocale();

    $translate = new GoogleTranslate($targetLang);

    if (strip_tags($html) !== $html) {
        $translatedHtml = preg_replace_callback(
            '/>([^<]+)</',
            function ($matches) use ($translate) {
                $text = $matches[1];
                $translatedText = $translate->translate(trim($text));
                return '>' . $translatedText . '<';
            },
            $html
        );
    } else {
        $translatedHtml = $translate->translate($html);
    }

    return $translatedHtml;
}
