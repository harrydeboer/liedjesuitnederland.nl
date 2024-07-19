<?php

declare(strict_types=1);

namespace webtailor\Controller;

use JetBrains\PhpStorm\NoReturn;
use webtailor\Repository\VideoRepository;
use webtailor\Service\TermCountsService;

class HomepageController
{
    private VideoRepository $videoRepository;
    private TermCountsService $termCountsService;

    public function __construct(
    ) {
        $this->videoRepository = new VideoRepository();
        $this->termCountsService = new TermCountsService();
    }

    public function home(): void
    {
        $videos = $this->videoRepository->find();

        $terms = get_terms();
        $periods = $this->getPeriods($terms);
        $themes = $this->getThemes($terms);

        require_once(dirname(__DIR__) . '/templates/content-home.php');
    }

    #[NoReturn] public function filter(array $matchSearch, array $matchPeriod, array $matchTheme): void
    {
        $terms = get_terms();
        $periods = $this->getPeriods($terms);
        $themes = $this->getThemes($terms);

        $filter = $this->validate($periods, $themes, $matchSearch, $matchPeriod, $matchTheme);

        $terms = $this->termCountsService->count($terms, $filter);
        $periods = $this->getPeriods($terms);
        $themes = $this->getThemes($terms);

        $videos = $this->videoRepository->find($filter);

        require_once(dirname(__DIR__) . '/templates/filter.php');

        exit();
    }

    #[NoReturn] public function scroll(array $matchSearch, array $matchPeriod, array $matchTheme, array $matchOffset): void
    {
        $terms = get_terms();
        $periods = $this->getPeriods($terms);
        $themes = $this->getThemes($terms);

        $filter = $this->validate($periods, $themes, $matchSearch, $matchPeriod, $matchTheme, $matchOffset);

        $videos = $this->videoRepository->find($filter);

        require_once(dirname(__DIR__) . '/templates/videos.php');

        exit();
    }

    private function validate($periods, $themes, $matchSearch, $matchPeriod, $matchTheme, $matchOffset = []): array
    {
        $filter = [];
        $periodsArray = [];
        $themesArray = [];
        foreach ($periods as $period) {
            $periodsArray[] = $period->slug;
        }
        foreach ($themes as $theme) {
            $themesArray[] = $theme->slug;
        }
        if ($matchSearch !== []) {
            $filter['search'] = $matchSearch[1];
        }
        if ($matchPeriod !== [] && in_array($matchPeriod[1], $periodsArray)) {
            $filter['period'] = $matchPeriod[1];
        }
        if ($matchTheme !== [] && in_array($matchTheme[1], $themesArray)) {
            $filter['theme'] = $matchTheme[1];
        }
        if ($matchOffset !== [] && ctype_digit($matchOffset[1])) {
            $filter['offset'] = $matchOffset[1];
        }

        return $filter;
    }

    private function getPeriods(array $terms): array
    {
        $periods = [];
        foreach ($terms as $term) {
            if ($term->taxonomy === 'periode') {
                $periods[] = $term;
            }
        }

        return $periods;
    }

    private function getThemes(array $terms): array
    {
        $themes = [];
        foreach ($terms as $term) {
            if ($term->taxonomy === 'thema') {
                $themes[] = $term;
            }
        }

        return $themes;
    }
}
