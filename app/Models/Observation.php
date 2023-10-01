<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Observation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function capybara(): BelongsTo
    {
        return $this->belongsTo(Capybara::class);
    }
}
