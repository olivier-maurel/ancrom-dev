<?php
namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ApplicationExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('getMiniIcon', [$this, 'getMiniIcon']),
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

    // public function getTechnologyIcon(string $technology): string
    // {

    // }

}