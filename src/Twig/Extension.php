<?php
// src/Twig/Extension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Extension extends AbstractExtension
{
    public function getFilters() : array
    {
        return [
            new TwigFilter('genHeight', [$this, 'formatHeight']),
        ];
    }

    public function formatHeight(int $number): string
    {
        
        $number = $number * 6;

        return strval($number);
    }
}

?>
