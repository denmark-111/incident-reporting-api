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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('incident_date');
            $table->time('incident_time');
            $table->text('location');
            $table->string('type');
            $table->string('severity');
            $table->text('description');
            $table->string('complainant_name');
            $table->string('complainant_contact');
            $table->string('respondent_name');
            $table->string('respondent_address')->nullable();
            $table->string('witness')->nullable();
            $table->string('desired_resolution')->nullable();
            $table->string('evidence_path')->nullable();
            $table->string('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
