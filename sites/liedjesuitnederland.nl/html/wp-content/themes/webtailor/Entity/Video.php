<?php

declare(strict_types=1);

namespace webtailor\Entity;

class Video
{
    private int $ID;
    private string $name;
    private ?string $period = null;
    private array $themes = [];
    private string $youtubeLink;

    public function __construct(object $row)
    {
        $this->setID((int) $row->ID);
        $this->setName($row->post_title);
        if (isset($row->taxonomy)) {
            if ($row->taxonomy === 'periode') {
                $this->setPeriod($row->slug);
            } elseif ($row->taxonomy === 'thema') {
                $this->addTheme($row->slug);
            }
        }
        if (isset($row->meta_value)) {
            $this->setYoutubeLink($row->meta_value);
        }
    }

    public function getID(): int
    {
        return $this->ID;
    }

    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): void
    {
        $this->period = $period;
    }

    public function getThemes(): array
    {
        return $this->themes;
    }

    public function setThemes(array $themes): void
    {
        $this->themes = $themes;
    }

    public function addTheme(string $theme): void
    {
        $this->themes[] = $theme;
    }

    public function getYoutubeLink(): string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(string $link): void
    {
        $this->youtubeLink = $link;
    }
}
