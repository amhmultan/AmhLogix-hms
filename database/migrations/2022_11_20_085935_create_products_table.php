<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('fk_manufacturer_id');
            $table->string('name', 255);
            $table->string('generic', 255);
            $table->string('drug_class', 255);
            $table->string('description', 255);
            $table->string('pack_size', 255);
            $table->tinyInteger('status');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('fk_manufacturer_id')->on('manufacturers')->references('id')
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
        Schema::dropIfExists('products');
    }
}
