<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUtility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section_background')->nullable();
            $table->string('section_background_mobile')->nullable();
            $table->string('section_title')->nullable();
            $table->longText('section_description')->nullable();
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
        Schema::dropIfExists('utility');
    }
}
