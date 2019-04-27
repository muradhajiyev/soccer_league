<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{

    protected $appends = ['has_next_fixture', 'current_week', 'last_week_results'];

    public function teams(){
        return $this->belongsToMany(Team::class);
    }

    public function fixtures(){
        return $this->hasMany(Fixture::class);
    }


    public function getHasNextFixtureAttribute()
    {
        return Fixture::notPlayed()->where('league_id', $this->id)->exists();
    }

    public function getCurrentWeekAttribute(){
        $fixture = Fixture::played()->where('league_id', $this->id)->max('week');
        $countNonPlayedMatches = Fixture::notPlayed()->where('league_id', $this->id)->count();
        return $fixture ?? ++$fixture;
    }

    public function getLastWeekResultsAttribute(){
        $lastWeek = Fixture::played()->where('league_id', $this->id)->max('week');
        $results = Fixture::played()->where('league_id', $this->id)->where('week', $lastWeek)->get();
        return $results;
    }

}
