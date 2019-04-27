<?php

namespace App\Jobs;

use App\Fixture;
use App\League;
use App\LeagueStanding;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessMatchResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leagueId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($leagueId)
    {
        $this->leagueId = $leagueId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = $this->processMatchResult($this->leagueId);

        foreach ($result as $teamId => $stats){
            $standing = LeagueStanding::where('team_id', $teamId)->where('league_id', $this->leagueId)->first();

            if (is_null($standing)){
                $standing = new LeagueStanding();
                $standing->team_id = $teamId;
                $standing->league_id = $this->leagueId;

            }

            $standing->assignStats($stats);
            $standing->save();
        }
    }

    private function processMatchResult($leagueId){
        $res = [];
        $results = Fixture::played()->where('league_id', $leagueId)->get();
        $teams = League::find($leagueId)->teams;

        foreach ($teams as $team){
            $res[$team->id]['gf'] = 0;
            $res[$team->id]['ga'] = 0;
            $res[$team->id]['gd'] = 0;
            $res[$team->id]['won'] = 0;
            $res[$team->id]['lost'] = 0;
            $res[$team->id]['drawn'] = 0;
            $res[$team->id]['points'] = 0;
            $res[$team->id]['played'] = 0;
        }

        foreach ($results as $key => $result){

            $res[$result->team_home_id]['gf'] += $result->goals_team_home;
            $res[$result->team_away_id]['gf'] += $result->goals_team_away;

            $res[$result->team_home_id]['ga'] += $result->goals_team_away;
            $res[$result->team_away_id]['ga'] += $result->goals_team_home;

            $res[$result->team_home_id]['gd'] = $res[$result->team_home_id]['gf'] - $res[$result->team_home_id]['ga'];
            $res[$result->team_away_id]['gd'] = $res[$result->team_away_id]['gf'] - $res[$result->team_away_id]['ga'];
            if ($result->goals_team_home > $result->goals_team_away){
                $res[$result->team_home_id]['won']++;
                $res[$result->team_away_id]['lost']++;
                $res[$result->team_home_id]['points'] += 3;

            }else if ($result->goals_team_home < $result->goals_team_away){
                $res[$result->team_away_id]['won']++;
                $res[$result->team_home_id]['lost']++;
                $res[$result->team_away_id]['points'] += 3;
            }else{
                $res[$result->team_home_id]['drawn']++;
                $res[$result->team_away_id]['drawn']++;
                $res[$result->team_home_id]['points'] += 1;
                $res[$result->team_away_id]['points'] += 1;
            }

            $res[$result->team_home_id]['played']++;
            $res[$result->team_away_id]['played']++;
        }
        return $res;
    }
}
