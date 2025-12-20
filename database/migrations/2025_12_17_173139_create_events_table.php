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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('categories');
            $table->string('place');
            $table->string('url_image');
            $table->enum('status', ['pending', 'denied', 'validate'])->default('pending');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
            // 1. Formater les dates pour MySQL (Y-m-d)
        if (isset($data['start'])) {
            $data['start'] = Carbon::parse($data['start'])->format('Y-m-d');
        }
        if (isset($data['end'])) {
            $data['end'] = Carbon::parse($data['end'])->format('Y-m-d');
        }
