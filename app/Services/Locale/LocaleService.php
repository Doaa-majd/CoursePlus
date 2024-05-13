<?php

declare(strict_types=1);

namespace App\Services\Locale;

class LocaleService
{
    public function changeLang($data)
    {
        \Session::put('lang', $data['lang']);
    }
}
