<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDischargeSummaryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('discharge_summary_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('discharge_summary_id')->constrained('discharge_summaries')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('dosage_id')->nullable()->constrained('dosages')->nullOnDelete();
            $table->string('duration')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discharge_summary_items');
    }
}