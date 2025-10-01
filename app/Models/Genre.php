<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug',
    ];

    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'anime_genre')->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function (Genre $g) {
            if (empty($g->slug) && !empty($g->name)) {
                $g->slug = Str::slug($g->name.'-'.Str::random(4));
            }
        });
    }
}
