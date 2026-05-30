<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('discharge_summaries', function (Blueprint $table) {
            $table->string('dm')->nullable()->after('admission_id');
            $table->string('htn')->nullable()->after('dm');
            $table->string('ihd')->nullable()->after('htn');
            $table->string('asthma')->nullable()->after('ihd');
        });
    }

    public function down(): void
    {
        Schema::table('discharge_summaries', function (Blueprint $table) {
            $table->dropColumn(['dm', 'htn', 'ihd', 'asthma']);
        });
    }
};