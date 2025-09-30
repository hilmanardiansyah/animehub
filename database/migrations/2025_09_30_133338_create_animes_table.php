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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->enum('status', ['ongoing','completed','hiatus'])->default('ongoing')->index();
            $table->enum('type', ['tv','movie','ova','ona','special'])->default('tv')->index();
            $table->date('aired_at')->nullable()->index();
            $table->decimal('rating_avg', 3, 2)->nullable(); // 0.00 - 10.00
            $table->unsignedBigInteger('popularity')->default(0)->index(); // opsional buat sorting
            $table->timestamps();

            $table->index(['status', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
