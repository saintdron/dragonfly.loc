<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 30.10.2018
 * Time: 18:55
 */

namespace App\Traits;


trait DronTrait
{
    public function formatCreatedAtDate($template, $sec)
    {
        $currentLocal = setlocale(LC_TIME, 0);
        setlocale(LC_TIME, 'rus', 'ru', 'ru_RU', 'rus', 'Russian_ru', 'ru_RU.UTF-8', 'ru_RU.utf8', 'ru_RU.1251', 'ru_RU.cp1251', 'ru_Russian', 'ru_RU.utf-8', 'Russian_Russia.utf-8');

        $result = strftime($template, $sec);

//        for byethost:
//        $result = iconv("ISO-8859-5", "utf-8", $result);
        $result = iconv("Windows-1251", "utf-8", $result);

        setlocale(LC_TIME, $currentLocal);
        return $result;
    }
}