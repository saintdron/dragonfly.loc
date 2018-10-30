<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 28.10.2018
 * Time: 11:57
 */

namespace App\Http\Repositories;


use App\Branding;

class BrandingRepository extends Repository
{
    public function __construct(Branding $model)
    {
        $this->model = $model;
    }
}