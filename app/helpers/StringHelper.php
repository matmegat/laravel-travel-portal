<?php

class StringHelper
{
    public static function clearText($text)
    {
        $text = html_entity_decode($text);

        $text = preg_replace('/<(head|style|script)[^>]*>.*?<\\/\\1>/is', '', $text);
        $text = preg_replace('/(<[^>]*?)class\\s*=\\s*(\'|").*?\\2(.*?>)/i', '$1$3', $text);
        $text = preg_replace('/(<[^>]*?)style\\s*=\\s*(\'|")(.*?)\\2(.*?>)/i', '$1$4', $text);

        return $text;
    }

    /**
     * Helper for rewrite unsafe (non-ssl) image url to https request by own domain.
     *
     * @param string $url
     * @param string $image OPTIONAL type of image
     *
     * @return string
     */
    public static function secureImageUrl($url, $image = 'images')
    {
        $uploadPath = Config::get('site.https-'.$image.'-path');

        $fileName = hash('md5', $url);

        switch ($image) {
            case 'airlines' :
                $pathInfo = pathinfo($url);
                $fileName = $pathInfo['filename'];
                break;
        }

        $file = $uploadPath.'/'.$fileName.'.png';

        if (file_exists($file)) {
            return Config::get('site.https-'.$image.'-url').'/'.$fileName.'.png';
        }

        return '/secure-'.$image.'-image.png?url='.urlencode($url);
    }
}
