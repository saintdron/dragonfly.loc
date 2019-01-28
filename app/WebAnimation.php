<?php

namespace App;

use App\Traits\DronTrait;
use Illuminate\Database\Eloquent\Model;

class WebAnimation extends Model
{
    use DronTrait;

    protected $fillable = [
        'img', 'script', 'title', 'alias', 'text', 'customer', 'techs', 'created_at', 'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return $this->formatCreatedAtDate($value / 1000);
    }

    public function getImgAttribute($value)
    {
        return json_decode($value);
    }
}
