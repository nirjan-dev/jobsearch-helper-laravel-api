<?php

namespace App\Enums;

enum OauthProvider: string
{
    case GITHUB = 'github';
    case GOOGLE = 'google';

    public function driver(): string
    {
        return match ($this) {
            self::GITHUB => 'github',
            self::GOOGLE => 'google',
        };
    }
}
