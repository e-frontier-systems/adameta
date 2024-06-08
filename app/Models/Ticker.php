<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticker extends Model
{
    use HasFactory;


    protected $table = 'tickers';


    protected $fillable = [
        'name',
        'description'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function metadatas(): HasMany
    {
        return $this->hasMany(Metadata::class);
    }

    public function latestMetadata(): HasOne
    {
        return $this->hasOne(Metadata::class)->latestOfMany();
    }
}
