<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_home_id');
            $table->unsignedBigInteger('team_away_id');
            $table->unsignedSmallInteger('goals_team_home')->nullable();
            $table->unsignedSmallInteger('goals_team_away')->nullable();
            $table->unsignedBigInteger('league_id');
            $table->unsignedSmallInteger('week');
            $table->timestamps();

            $table->foreign('team_home_id')->references('id')->on('teams');
            $table->foreign('team_away_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
}
