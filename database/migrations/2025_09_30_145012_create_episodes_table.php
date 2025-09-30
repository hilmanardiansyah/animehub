<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('number'); // Episode 1, 2, ...
            $table->string('title')->nullable();
            $table->text('synopsis')->nullable();
            $table->date('aired_at')->nullable()->index();
            $table->unsignedInteger('duration_sec')->nullable(); // opsional
            $table->string('external_official_url')->nullable(); // link platform legal
            $table->timestamps();

            $table->unique(['season_id','number']);
            $table->index(['season_id','aired_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
