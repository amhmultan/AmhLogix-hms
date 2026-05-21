<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefractionColumnsToDoctorNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_notes', function (Blueprint $table) {
            // Right Eye (OD)
            $table->string('right_sph')->nullable();
            $table->string('right_cyl')->nullable();
            $table->string('right_axis')->nullable();
            $table->string('right_va')->nullable();

            // Left Eye (OS)
            $table->string('left_sph')->nullable();
            $table->string('left_cyl')->nullable();
            $table->string('left_axis')->nullable();
            $table->string('left_va')->nullable();

            // Additional 2nd row for Add and PD
            $table->string('right_add')->nullable();
            $table->string('right_pd')->nullable();
            $table->string('left_add')->nullable();
            $table->string('left_pd')->nullable();

            // Additional third row for remarks columns
            $table->text('right_remarks')->nullable();
            $table->text('left_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_notes', function (Blueprint $table) {
            $table->dropColumn([
                'right_sph', 'right_cyl', 'right_axis', 'right_va',
                'left_sph', 'left_cyl', 'left_axis', 'left_va',
                'right_add', 'right_pd', 'left_add', 'left_pd',
                'right_remarks', 'left_remarks'
            ]);
        });
    }
}
