<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Studios (perusahaan)
        Schema::create('studios', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('slug')->unique();
            $t->timestamps();
        });

        // Relasi anime - studio (banyak ke banyak)
        Schema::create('anime_studio', function (Blueprint $t) {
            $t->foreignId('anime_id')->constrained()->cascadeOnDelete();
            $t->foreignId('studio_id')->constrained()->cascadeOnDelete();
            $t->primary(['anime_id','studio_id']);
        });

        // People (seiyuu, sutradara, dll.)
        Schema::create('people', function (Blueprint $t) {
            $t->id();
            $t->string('name')->index();
            $t->string('slug')->unique();
            $t->string('avatar_path')->nullable();
            $t->enum('type', ['voice_actor','director','writer','composer','staff','other'])->default('staff')->index();
            $t->timestamps();
        });

        // Casts (peran suara)
        Schema::create('casts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('anime_id')->constrained()->cascadeOnDelete();
            $t->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $t->string('character_name')->nullable();
            $t->string('role')->nullable(); // main/support/guest
            $t->timestamps();

            $t->index(['anime_id','person_id']);
            $t->unique(['anime_id','person_id','character_name']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('casts');
        Schema::dropIfExists('people');
        Schema::dropIfExists('anime_studio');
        Schema::dropIfExists('studios');
    }
};
