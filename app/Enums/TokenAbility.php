<?php

namespace App\Enums;

enum TokenAbility: string
{
    case REFRESH_TOKEN = 'refresh_token';
    case ACCESS_TOKEN = 'access_token';
}