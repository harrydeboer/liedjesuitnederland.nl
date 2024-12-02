<?php

declare(strict_types=1);

use webtailor\Controller\HomepageController;
global $wp;

$url = home_url(add_query_arg(array($_GET), $wp->request));

$controller = new HomepageController();

$matchSearch = [];
$matchPeriod = [];
$matchTheme = [];
$matchOffset = [];
preg_match('/_sf_s=([\s\S]+?)&/', $url, $matchSearch);
preg_match('/_sft_periode=([\s\S]+?)&/', $url, $matchPeriod);
if (str_contains($url, 'scroll-videos-ajax=')) {
    preg_match('/_sft_thema=([\s\S]+?)&/', $url, $matchTheme);
} else {
    preg_match('/_sft_thema=([\s\S]+)/', $url, $matchTheme);
}
preg_match('/scroll-videos-ajax=([\s\S]+)/', $url, $matchOffset);
if ($matchOffset !== []) {
    $controller->scroll($matchSearch, $matchPeriod, $matchTheme, $matchOffset);
} elseif (str_contains($url, '_sf_s') || str_contains($url, '_sft_thema') || str_contains($url, '_sft_periode')) {
    $controller->filter($matchSearch, $matchPeriod, $matchTheme);
} else {
    $controller->home();
}
