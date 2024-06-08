<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Metadata extends Model
{
    use HasFactory;

    /**
     * モデルに関連づけるテーブル
     * @var string
     */
    protected $table = 'metadatas';


    protected $fillable = [
        'json',
    ];

    public function ticker(): BelongsTo
    {
        return $this->belongsTo(Ticker::class);
    }
}
