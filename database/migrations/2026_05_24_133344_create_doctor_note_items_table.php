<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_note_items', function (Blueprint $table) {
            $table->id();

        $table->foreignId('doctor_note_id')
            ->constrained('doctor_notes')
            ->cascadeOnDelete();

        $table->foreignId('product_id')
            ->nullable()
            ->constrained('products')
            ->nullOnDelete();

        $table->foreignId('dosage_id')
            ->nullable()
            ->constrained('dosages')
            ->nullOnDelete();

        $table->string('duration')->nullable();
        $table->text('remarks')->nullable();

        $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_note_items');
    }
}
