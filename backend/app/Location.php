<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo("App\User");
    }
}
