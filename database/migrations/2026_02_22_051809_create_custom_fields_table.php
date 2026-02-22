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
        // Schema::create('custom_fields', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('field_name');
        //     $table->enum('field_for', ['incident', 'complaint'])->default('incident');
        //     $table->string('field_label');
        //     $table->string('field_type');
        //     $table->text('field_description')->nullable();
        //     $table->json('field_options')->nullable();
        //     $table->string('field_rules')->nullable();
        //     $table->boolean('is_active')->default(false);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
