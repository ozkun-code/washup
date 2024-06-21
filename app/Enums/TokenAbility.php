<?php

namespace App\Enums;

enum TokenAbility: string
{
    case REFRESH_TOKEN = 'refresh-token';
    case ACCESS_API = 'access-api';
}