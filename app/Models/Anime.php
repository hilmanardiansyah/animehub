<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug','synopsis','poster_path','banner_path',
        'status','type','aired_at','rating_avg','popularity',
    ];
    protected $casts = [
        'aired_at'   => 'date',
        'rating_avg' => 'decimal:2',
        'popularity' => 'integer',
    ];
    public function seasons()
    {
        return $this->hasMany(Season::class)->orderBy('number');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'anime_genre')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
     public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    // ----- Accessors / Helpers
    public function getYearAttribute(): ?int
    {
        return $this->aired_at?->year;
    }

    protected static function booted()
    {
        // Auto-slug (tidak overwrite jika sudah ada)
        static::creating(function (Anime $anime) {
            if (empty($anime->slug) && !empty($anime->title)) {
                $anime->slug = Str::slug($anime->title.'-'.Str::random(5));
            }
        });
    }

    // ----- Query Scopes
    public function scopeType(Builder $q, ?string $type): Builder
    {
        return $type ? $q->where('type', $type) : $q;
    }

    public function scopeStatus(Builder $q, ?string $status): Builder
    {
        return $status ? $q->where('status', $status) : $q;
    }

    public function scopeYear(Builder $q, ?int $year): Builder
    {
        return $year ? $q->whereYear('aired_at', $year) : $q;
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (!$term) return $q;
        return $q->where(function($w) use ($term) {
            $w->where('title', 'like', "%$term%")
              ->orWhere('synopsis', 'like', "%$term%");
        });
    }

    public function scopeTrending(Builder $q): Builder
    {
        return $q->orderByDesc('popularity');
    }

    public function scopeTopRated(Builder $q): Builder
    {
        return $q->orderByDesc('rating_avg')->orderByDesc('popularity');
    }

}
