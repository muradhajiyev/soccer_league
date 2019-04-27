<?php
/**
 * Created by PhpStorm.
 * User: muradhajiyev
 * Date: 2019-04-27
 * Time: 12:41
 */

namespace App\Repositories;


use App\Fixture;
use App\League;
use App\LeagueStanding;
use App\Result;
use App\Team;
use Illuminate\Http\Request;

class LeagueRepository
{

    public function getStandings($leagueId){
        $standings = LeagueStanding::where('league_id', $leagueId)
            ->orderBy('points','desc')
            ->orderBy('gd','desc')
            ->get();
        return $standings;
    }

    public function playNextFixture($leagueId){
        $fixtures = Fixture::where('league_id', $leagueId)
            ->where('week', function ($query) use($leagueId) {
                $query->from('fixtures')
                    ->selectRaw('min(week)')
                    ->whereNull('goals_team_home')
                    ->whereNull('goals_team_away')
                    ->where('league_id', $leagueId);
            })->get();

        foreach ($fixtures as $fixture){
            $fixture->goals_team_home = rand(0, 5);
            $fixture->goals_team_away = rand(0, 5);

            $fixture->save();
        }
    }

    public function playAllMatches($leagueId){
        $fixtures = Fixture::notPlayed()
            ->where('league_id', $leagueId)
            ->get();

        foreach ($fixtures as $fixture){
            $fixture->goals_team_home = rand(0, 5);
            $fixture->goals_team_away = rand(0, 5);

            $fixture->save();
        }
    }


    public function storeToDb($leagueName, $team1, $team2, $team3, $team4){
        $league = new League();
        $league->name = $leagueName;
        $league->save();

        $teams = array($team1, $team2, $team3, $team4);
        $teams_ids = [];
        foreach($teams as $key => $t){
            $team = new Team();
            $team->name = $t;
            $team->save();

            $teams_ids[] = $team->id;

            $league->teams()->attach($team->id);
        }

       $rounds =  $this->roundRobin($teams_ids);

        //the first half round
        foreach ($rounds as $round => $games){
            $round++;
            foreach ($games as $game){
                $fixture = new Fixture();
                $fixture->team_home_id = $game['Home'];
                $fixture->team_away_id = $game['Away'];
                $fixture->league_id = $league->id;
                $fixture->week = $round;
                $fixture->save();
            }
        }

        //the second half round
        $count = count($rounds);
        foreach ($rounds as $round => $games){
            $count++;
            foreach ($games as $game){
                $fixture = new Fixture();
                $fixture->team_home_id = $game['Away'];
                $fixture->team_away_id = $game['Home'];
                $fixture->league_id = $league->id;
                $fixture->week = $count;
                $fixture->save();
            }
        }
        return $league->id;
    }

    private function roundRobin(array $teams)
    {
        if (count($teams) % 2 != 0) {
            array_push($teams, "bye");
        }
        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]["Home"] = $home[$j];
                $round[$i][$j]["Away"] = $away[$j];
            }
            if (count($home) + count($away) - 1 > 2) {
                $s = array_splice($home, 1, 1);
                $slice = array_shift($s);
                array_unshift($away, $slice);
                array_push($home, array_pop($away));
            }
        }
        return $round;
    }
}