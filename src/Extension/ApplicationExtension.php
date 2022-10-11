<?php
namespace App\Extension;

use DOMDocument;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ApplicationExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('getMiniIcon', [$this, 'getMiniIcon']),
            new TwigFilter('getFavicon', [$this, 'getFavicon']),
        ];
    }

    public function getMiniIcon(string $action): string
    {
        $fa = '';
        
        switch ($action) {
            case 'window':
                $fa = 'fa-window-maximize';
                break;
            case 'link':
                $fa = 'fa-share';
                break;
            case 'copy':
                $fa = 'fa-paste';
                break;
            case 'mailto':
                $fa = 'fa-envelope';
                break;
            case 'file':
                $fa = 'fa-file';
                break;
        }

        return $fa;
    }

    public function getFavicon($url)
    {
        $favicon = '<img width="37px" height="37px" src="https://www.google.com/s2/favicons?sz=64&domain='. $url .'">';
        $headers = get_headers($url);

        if (preg_match("|200|", $headers[0]))
            return $favicon;

        return $favicon;
    }

}