<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rets_property_photos_test', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('photo_id');
            $table->char('property_id', 255);
            $table->char('photo_thumb', 255);
            $table->char('photo_full', 255);
            $table->char('photo_description', 255);
            $table->timestamps();
            
            $table->index(['property_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rets_property_photos_test');
    }
}
