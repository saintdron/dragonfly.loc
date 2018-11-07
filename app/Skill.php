<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'tech', 'level', 'order', 'created_at', 'updated_at'
    ];
}
