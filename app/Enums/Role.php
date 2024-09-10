<?php

namespace App\Enums;

enum Role: string
{
    case Administrator = 'admin';
    case HeadAdmin = 'head admin';
    case Moderator = 'moderator';
}
