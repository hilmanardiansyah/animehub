<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id','number','title','synopsis','aired_at','duration_sec','external_official_url',
    ];

    protected $casts = [
        'aired_at' => 'date',
        'duration_sec' => 'integer',
    ];

    // ----- Relationships
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
