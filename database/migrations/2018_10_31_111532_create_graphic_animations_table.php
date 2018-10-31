<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphicAnimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graphic_animations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('video');
            $table->string('img');
            $table->string('title', 40);
            $table->string('alias', 40)->unique();
            $table->text('text');
            $table->string('customer', 80);
            $table->string('techs', 200);
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
        Schema::dropIfExists('graphic_animations');
    }
}
