<?php

namespace App\Enums\Fee;

enum FeeTypeEnum: int
{
    case Step = 1;
    case KilometersFee = 2;
    case NightHotel = 3;
    case RestaurantMeal = 4;
}
