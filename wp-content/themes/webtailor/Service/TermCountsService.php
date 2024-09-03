<?php

declare(strict_types=1);

namespace webtailor\Service;

use webtailor\Entity\Video;
use WP_Term;

class TermCountsService
{
    /**
     * @return WP_Term[]
     */
    public function count(array $terms, array $filter = []): array
    {
        global $wpdb;

        $rows = $wpdb->get_results("select * from $wpdb->term_relationships as r " .
            "join $wpdb->posts as p on r.object_id = p.ID " .
            "join $wpdb->terms as t on r.term_taxonomy_id = t.term_id " .
            "join $wpdb->term_taxonomy as q on r.term_taxonomy_id = q.term_taxonomy_id " .
            "where p.post_status = 'publish' and p.post_type = 'video'");
        $videos = [];
        foreach ($rows as $row) {
            if ($row->taxonomy == 'category'
                || $row->taxonomy == 'nav_menu'
                || $row->taxonomy == 'categorie'
                || $row->taxonomy == 'monsterinsights_note_category') {
                continue;
            }
            if ($row->slug == 'uncategorized'
                || $row->slug == 'header-menu'
                || $row->slug == 'blog-bericht'
                || $row->slug == 'site-updates') {
                continue;
            }
            if (isset($videos[$row->ID])) {
                if ($row->taxonomy == 'thema') {
                    $videos[$row->ID]->addTheme($row->slug);
                } elseif ($row->taxonomy == 'periode') {
                    $videos[$row->ID]->setPeriod($row->slug);
                }
            } else {
                $video = new Video($row);
                $videos[$row->ID] = $video;
            }
        }
        foreach ($terms as $key => $term) {
            $term->count = 0;
            foreach ($videos as $video) {
                if (isset($filter['search']) && str_contains(strtolower($video->getName()), strtolower($filter['search']))) {
                    $this->increment($term, $video, $filter);
                } elseif (!isset($filter['search'])) {
                    $this->increment($term, $video, $filter);
                }
            }
            if ($term->count === 0) {
                unset($terms[$key]);
            }
        }
        ksort($terms);

        return $terms;
    }

    private function increment(WP_Term $term, Video $video, array $filter): void
    {
        if (in_array($term->slug, $video->getThemes())) {
            if (isset($filter['period']) && $filter['period'] === $video->getPeriod()) {
                $term->count += 1;
            } elseif (!isset($filter['period'])) {
                $term->count += 1;
            }
        }
        if ($term->slug === $video->getPeriod()) {
            if (isset($filter['theme']) && in_array($filter['theme'], $video->getThemes())) {
                $term->count += 1;
            } elseif (!isset($filter['theme'])) {
                $term->count += 1;
            }
        }
    }
}
