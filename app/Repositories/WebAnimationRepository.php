<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 15.11.2018
 * Time: 17:28
 */

namespace App\Repositories;


use App\WebAnimation;

class WebAnimationRepository extends Repository
{
    public function __construct(WebAnimation $model)
    {
        $this->model = $model;
    }
}