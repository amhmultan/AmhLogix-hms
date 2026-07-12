<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add phone_number only if it doesn't already exist
        if (!Schema::hasColumn('appointments', 'phone_number')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('phone_number')->nullable()->after('patient_name');
            });
        }

        // Change appointment_time from TIME to VARCHAR(50)
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_time VARCHAR(50) NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_time TIME NOT NULL");

        if (Schema::hasColumn('appointments', 'phone_number')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('phone_number');
            });
        }
    }
};