<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // doctor/nurse
            $table->text('notes')->nullable();
            $table->json('vitals')->nullable(); // Example: {"bp":"120/80","pulse":"90","temp":"98.6"}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('daily_notes');   // or admissions/charges/etc.
        Schema::enableForeignKeyConstraints();
    }
};
