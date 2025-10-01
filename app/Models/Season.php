<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['anime_id', 'number', 'title'];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('number');
    }

}
