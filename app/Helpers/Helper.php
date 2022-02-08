<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Helper
{

    public static function arrayToSelectableCollection($array): Collection
    {
        return collect($array)->map(fn($item) => ['id' => $item, 'name' => $item ]);
    }

}
