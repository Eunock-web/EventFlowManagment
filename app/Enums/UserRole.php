<?php

namespace App\Enums; 

enum UserRole: string
{
    case Client = 'client';
    case Entrepreneur = 'entrepreneur';
    case Admin = 'admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value'); 
    }
}