<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        "name",
    ];
    // get...Attribute アクセサ
    public function getHashtagAttribute(): string
    {
        return "#" . $this->name;
    }
}
