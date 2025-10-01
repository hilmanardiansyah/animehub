<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;


class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance',
            'Sci-Fi', 'Slice of Life', 'Sports', 'Thriller', 'Action', 'Supernatural',
            'Mecha', 'Psychological', 'Ecchi', 'Harem', 'Historical'
        ];

        foreach($defaults as $name) {
            Genre::firstOrCreate(['name' => $name], ['slug' => \Str::slug($name.'-'.\Str::random(4))]);
        }

        \App\Models\Genre::factory(10)->create();
    }
}
