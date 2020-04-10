<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHyperlink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hyperlink', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('icon')->nullable();
            $table->string('icon_hover')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hyperlink');
    }
}
