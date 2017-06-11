<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('realm');
            $table->string('guild')->nullable();
			$table->string('battlegroup');
			$table->unsignedInteger('class');
			$table->unsignedInteger('race');
			$table->unsignedInteger('gender');
			$table->unsignedInteger('level');
			$table->unsignedInteger('achievementPoints');
			$table->string('thumbnail');
			$table->unsignedInteger('lastModified');
            $table->boolean('main')->nullable();
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
        Schema::dropIfExists('characters');
    }
}
