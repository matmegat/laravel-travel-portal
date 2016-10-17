<?php

namespace services;

class Page
{
    public static function getPageInfo($pageId)
    {
        $pageContent = \PageContent::where('page_id', '=', $pageId)->first();

        return [
            'page_id' => $pageContent->page_id,
            'title' => $pageContent->title,
            'content' => $pageContent->content,
            'keywords' => $pageContent->keywords,
            'description' => $pageContent->description,
            'backgroundUrl' => self::getUrl($pageContent->backgroundUrl),
        ];
    }

    public static function getPageInfoDefault()
    {
        return [
            'title' => '',
            'content' => '',
            'keywords' => 'Visits Adventures',
            'description' => 'Visits Adventures is a website.',
            'backgroundUrl' => false,
        ];
    }

    public static function setPageInfo($pageId, $pageInfo)
    {
        $pageContent = \PageContent::where('page_id', '=', $pageId)->first();

        $pageContent->title = $pageInfo['title'];
        $pageContent->content = $pageInfo['content'];
        $pageContent->keywords = $pageInfo['keywords'];
        $pageContent->description = $pageInfo['description'];

        if (isset($pageInfo['sub_title'])) {
            $pageContent->sub_title = $pageInfo['sub_title'];
        }

        if (isset($pageInfo['backgroundFile'])) {
            $background = $pageInfo['backgroundFile'];
            if (!\File::exists(self::getPath())) {
                \File::makeDirectory(self::getPath(), 664);
            }
            $background->move(self::getPath(), $background->getClientOriginalName());
            $pageContent->backgroundUrl = $background->getClientOriginalName();
        }

        return $pageContent->save();
    }

    public static function getPath($file = false)
    {
        if ($file) {
            return \Config::get('app.uploadDir').'/pageBackgrounds/'.$file;
        } else {
            return \Config::get('app.uploadDir').'/pageBackgrounds';
        }
    }

    public static function getUrl($file)
    {
        if (empty($file)) {
            return false;
        }

        return '/uploads/pageBackgrounds/'.$file;
    }

    public static function removeBackground($pageId)
    {
        $pageContent = \PageContent::where('page_id', '=', $pageId)->first();
        $sameBackground = \PageContent::where('page_id', '!=', $pageId)
            ->where('backgroundUrl', '=', $pageContent->backgroundUrl)
            ->first();

        if (!$sameBackground) {
            $path = self::getPath($pageContent->backgroundUrl);
            if (file_exists($path) && !is_dir($path)) {
                unlink($path);
            }
        }

        $pageContent->backgroundUrl = null;

        return $pageContent->save();
    }
}
