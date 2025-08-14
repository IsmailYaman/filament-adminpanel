<?php

namespace App\Enums;

enum Region: string
{
    case US = 'us';
    case Canada = 'canada';
    case Europe = 'europe';
    case Asia = 'asia';
    case SouthAmerica = 'south america';
    case Africa = 'africa';
    case Oceania = 'oceania';
    case Online = 'online';
}