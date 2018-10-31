<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 31.10.2018
 * Time: 11:25
 */

namespace App\Http\Repositories;


use App\Printing;

class PrintingRepository extends Repository
{
    public function __construct(Printing $model)
    {
        $this->model = $model;
    }
}