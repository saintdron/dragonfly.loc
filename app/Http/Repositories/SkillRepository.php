<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 07.11.2018
 * Time: 16:21
 */

namespace App\Http\Repositories;


use App\Skill;

class SkillRepository extends Repository
{
    public function __construct(Skill $model)
    {
        $this->model = $model;
    }
}