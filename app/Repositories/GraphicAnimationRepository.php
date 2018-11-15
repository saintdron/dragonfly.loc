<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 31.10.2018
 * Time: 11:26
 */

namespace App\Repositories;


use App\GraphicAnimation;

class GraphicAnimationRepository extends Repository
{
    public function __construct(GraphicAnimation $model)
    {
        $this->model = $model;
    }
}