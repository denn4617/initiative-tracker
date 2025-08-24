<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('initiatives', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('impact_score')->comment('1–10 scale');
            $table->string('category', 100);
            $table->timestamps();
        });

        try {
            DB::statement(
                'ALTER TABLE initiatives
                 ADD CONSTRAINT chk_initiatives_impact
                 CHECK (impact_score BETWEEN 1 AND 10)'
            );
        } catch (\Throwable $e) {
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initiatives');
    }
};
