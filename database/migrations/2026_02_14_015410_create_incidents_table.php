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
        // Schema::create('incidents', function (Blueprint $table) {
        //     $table->id();
        //     $table->text('description');
        //     $table->string('evidence_path')->nullable();
        //     $table->text('location');
        //     $table->decimal('latitude', 10, 7);
        //     $table->decimal('longitude', 10, 7);
        //     $table->string('additional_notes')->nullable();
        //     $table->timestamps();
        //     $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        //     $table->string('status')->default('pending');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
