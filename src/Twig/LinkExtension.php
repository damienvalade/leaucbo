<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LinkExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('link', [$this, 'link']),
        ];
    }

    public function link(string $str): string
    {
        $site = "http://id.eaufrance.fr/par/";

        $url = $site . $str;

        return "<a href='" . $url . "'>" . $str . "</a>";
    }
}