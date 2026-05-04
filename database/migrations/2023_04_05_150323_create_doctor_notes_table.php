<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_notes', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('fk_patient_id');
            $table->unsignedBigInteger('fk_token_id')->nullable();
            $table->string('prescription', 255)->nullable();
            $table->string('mode')->default('upload'); // 'upload' or 'manual'
            $table->text('complaints')->nullable();
            $table->text('history')->nullable();
            $table->text('investigations')->nullable();
            $table->text('prescription_text')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('fk_patient_id')->on('patients')->references('id')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            
            $table->foreign('fk_token_id')->on('tokens')->references('id')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_notes');
    }
}
