<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 15.11.2018
 * Time: 17:19
 */

namespace App\Repositories;


use App\Site;

class SiteRepository extends Repository
{
    public function __construct(Site $model)
    {
        $this->model = $model;
    }
}