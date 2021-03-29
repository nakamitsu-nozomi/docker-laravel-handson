<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    // get...Attribute アクセサ
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany('App\Location')->withTimestamps();
    }
}
