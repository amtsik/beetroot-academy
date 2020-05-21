<?php

define('RSS_URLS', [
    'https://dumskaya.net/rssnews/' => 'getDumskayaDescription',
    'https://www.obozrevatel.com/rss.xml' => 'getDescription',
]);

function loadRss($url)
{
    $rssFile = 'tmp/' . parse_url($url, PHP_URL_HOST) . '.xml';
    $rssFile = sprintf(
        'tmp/%s.%s',
        parse_url($url, PHP_URL_HOST),
        'xml'
    );
    if (!file_exists($rssFile)) {
        $page = file_get_contents($url);
        file_put_contents($rssFile, $page);
    }
    return simplexml_load_file($rssFile);
}

function loadAll()
{
    $result = [];
    $total = 0;
//    foreach (RSS_URLS as $url => $function) {
//
//    }
    $limit = INF;
    if (!empty($_GET['limit'])) {
        $limit = floor($_GET['limit'] / count(RSS_URLS));
    }
    foreach (RSS_URLS as $url => $function) {
        $xml = loadRss($url);
        $items = $xml->channel->item;
        $key = 0;
        foreach ($items as $item) {
            if (++$key > $limit) {
                break;
            }
            $item->description = $function($item);
            $item->image = empty($item->image ) ?
                'https://i.ytimg.com/vi/sDnPs_V8M-c/hqdefault.jpg' :
                $item->image;

            $result[] = $item;
        }
    }
    shuffle($result);
    return $result;
}

function getDumskayaDescription(object $item, $limit = 2000): string
{
    $url = $item->link;
    $content = file_get_contents($url);
    // конвертируем из windows-1251 to UTF-8
    $content = mb_convert_encoding($content, "UTF-8", "Windows-1251");
    // получаем позицию тега в тексте страницы
    $pos = mb_strpos($content, '<td class=newscol');
    // обрезаем полученный контент с позиции тега <td class=newscol
    $description = mb_substr($content, $pos);

    //получаем картинку
    $item->image = getLogo($content) ;


    // удаляем strip_tags
    $description = strip_tags($description);
    // remove html entities
    $description = html_entity_decode($description);
    // preg_match
    $description = preg_replace('/\s{2,}/', ' ', $description);
    //очистка дескрипшина
//    $description = preg_match('/Адрес картинки в интернете:', '',$description);
    $description = preg_match('/function[^а-яё]+/s', '',$description);

    return mb_substr($description, 0, $limit);

}

function getDescription(object $item)
{
    return $item->description;
}

function getLogo (string $content) : string
{
    preg_match('/https?:\/\/.+?\.jpg/', $content, $matches);
    return $matches[0] ?? 'https://i.ytimg.com/vi/sDnPs_V8M-c/hqdefault.jpg';
}
