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
            $table->text('c_o')->nullable();
            $table->text('o_e')->nullable();
            $table->string('va')->nullable();
            $table->string('at')->nullable();
            $table->string('lids')->nullable();
            $table->string('conjunctiva')->nullable();
            $table->string('cornea')->nullable();
            $table->string('ac')->nullable();
            $table->string('lens')->nullable();
            $table->string('fundus')->nullable();
            $table->text('prescription_text')->nullable();
            $table->string('dm')->nullable();
            $table->string('htn')->nullable();
            $table->string('ihd')->nullable();
            $table->string('asthma')->nullable();

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
