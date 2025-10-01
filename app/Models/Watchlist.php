<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Watchlist extends Model
{
    use HasFactory;

    public const STATUS_PLANNING  = 'planning';
    public const STATUS_WATCHING  = 'watching';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DROPPED   = 'dropped';

    protected $fillable = [
        'user_id','anime_id','status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // ----- Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
