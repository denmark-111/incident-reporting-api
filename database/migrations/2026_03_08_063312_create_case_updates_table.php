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
        // Schema::create('case_updates', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('reference');
        //     $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        //     $table->string('event_type');// Type of update (e.g. note, status change, appointment update)
        //     $table->string('old_status')->nullable();
        //     $table->string('new_status')->nullable();
        //     $table->text('message')->nullable();// Message / admin note
        //     $table->string('attachment_path')->nullable();// Optional attachment (e.g. document, image)
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_updates');
    }
};
