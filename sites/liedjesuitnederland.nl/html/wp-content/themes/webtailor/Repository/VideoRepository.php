<?php

declare(strict_types=1);

namespace webtailor\Repository;

use webtailor\Entity\Video;
use WP_Term;

class VideoRepository
{
    /**
     * @return Video[]
     */
    public function find(array $filter = []): array
    {
        global $wpdb;

        $param = null;
        $queryString = "SELECT * FROM $wpdb->posts as p JOIN $wpdb->postmeta as m on p.ID = m.post_id " .
         "WHERE m.meta_key = 'youtube_link' AND p.post_status = 'publish' AND p.post_type = 'video'";
        if (isset($filter['search'])) {
            $queryString .= " AND p.post_title LIKE %s";
            $param = '%' . $wpdb->esc_like($filter['search']) . '%';
        }
        if (isset($filter['period'])) {
            $term = get_term_by('slug', $filter['period'], 'periode');
            $queryString = $this->termIds($wpdb, $queryString, $term);
        }
        if (isset($filter['theme'])) {
            $term = get_term_by('slug', $filter['theme'], 'thema');
            $queryString = $this->termIds($wpdb, $queryString, $term);
        }
        $queryString .=  " ORDER BY p.post_title ASC LIMIT 30";
        if (isset($filter['offset'])) {
            $queryString .= " OFFSET " . $filter['offset'];
        }

        $videos = [];
        if (is_null($param)) {
            $rows = $wpdb->get_results($queryString);
        } else {
            $rows = $wpdb->get_results($wpdb->prepare($queryString, $param));
        }
        foreach($rows as $row) {
            $videos[$row->ID] = new Video($row);
        }

        return $videos;
    }

    private function termIds(object $wpdb, string $queryString, WP_Term $term): string
    {
        $ids = $wpdb->get_results(
            $wpdb->prepare( "SELECT * FROM $wpdb->term_relationships " .
                "WHERE term_taxonomy_id = %s" , $term->term_id)
        );
        $queryString .= " AND ID in (";
        foreach ($ids as $id) {
            $queryString .= $id->object_id . ',';
        }
        $queryString = rtrim($queryString, ',');
        $queryString .= ")";

        return $queryString;
    }
}
