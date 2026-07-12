<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_notes', function (Blueprint $table) {

            $table->unsignedBigInteger('fk_doctor_id')->nullable()->after('fk_token_id');

            $table->foreign('fk_doctor_id')
                  ->references('id')
                  ->on('doctors')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_notes', function (Blueprint $table) {

            $table->dropForeign(['fk_doctor_id']);
            $table->dropColumn('fk_doctor_id');

        });
    }
};