<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebAnimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_animations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img');
            $table->boolean('script')->default(false);
            $table->string('title', 40);
            $table->string('alias', 40)->unique();
            $table->text('text');
            $table->string('customer', 80);
            $table->string('techs', 200);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('web_animations');
    }
}
