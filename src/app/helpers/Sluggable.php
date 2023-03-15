<?php

namespace app\helpers;

use yii\base\Component;

class Sluggable extends Component
{

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @return string
     */
    function format($title, $separator = '-')
    {

        $flip = $separator === '-' ? '_' : '-';

        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

        $title = str_replace('@', $separator.'at'.$separator, $title);

        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower($title));

        $title = str_replace('á', 'a', $title);
        $title = str_replace('é', 'e', $title);
        $title = str_replace('í', 'i', $title);
        $title = str_replace('ó', 'o', $title);
        $title = str_replace('ú', 'u', $title);
        $title = str_replace('ñ', 'n', $title);

        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

        return trim($title, $separator);
    }
}
