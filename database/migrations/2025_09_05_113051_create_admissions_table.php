<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('bed_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->string('diagnosis')->nullable();
             $table->decimal('admission_fees', 10, 2)->default(0);
            $table->timestamp('admission_date')->default(DB::raw('CURRENT_TIMESTAMP')); // no change()
            $table->timestamp('discharge_date')->nullable();
            $table->enum('status', ['admitted','discharged'])->default('admitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('admissions');
        Schema::enableForeignKeyConstraints();
    }
};
