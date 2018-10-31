<?php

namespace App;

use App\Traits\DronTrait;
use Illuminate\Database\Eloquent\Model;

class Printing extends Model
{
    use DronTrait;

    protected $fillable = [
        'img', 'title', 'alias', 'text', 'customer', 'techs', 'created_at', 'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return $this->formatCreatedAtDate("%B %Y", $value / 1000);
    }

    public function getImgAttribute($value)
    {
        return json_decode($value);
    }
}
