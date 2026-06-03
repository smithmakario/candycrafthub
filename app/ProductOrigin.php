<?php

namespace App;

enum ProductOrigin: string
{
    case LocalNostalgia = 'local_nostalgia';
    case InternationalImports = 'international_imports';

    public function label(): string
    {
        return match ($this) {
            self::LocalNostalgia => 'Local Nostalgia',
            self::InternationalImports => 'International Imports',
        };
    }
}
