<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 15.11.2018
 * Time: 17:26
 */

namespace App\Repositories;


use App\Service;

class ServiceRepository extends Repository
{
    public function __construct(Service $model)
    {
        $this->model = $model;
    }
}