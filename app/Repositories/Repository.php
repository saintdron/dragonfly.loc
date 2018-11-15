<?php
/**
 * Created by PhpStorm.
 * User: Dron
 * Date: 25.10.2018
 * Time: 14:10
 */

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;

abstract class Repository
{
    protected $model = null;

    public function get($select = '*', $where = false)
    {
        $builder = $this->model->select($select)->orderBy('created_at', 'desc');

        if ($where) {
            $builder->where([$where]);
        }

        if (Schema::hasColumn($this->model->getTable(), 'active')) {
            $builder->where('active', 1);
        }

        return $builder->get();
    }

    public function one($alias, $select = '*')
    {
        $result = $this->model->select($select)->where('alias', $alias)->first();

        return $result;
    }
}