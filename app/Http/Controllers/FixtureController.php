<?php

namespace App\Http\Controllers;

use App\Fixture;
use App\Jobs\ProcessMatchResults;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    protected $leagueRepo;

    public function __construct(LeagueRepository $leagueRepo)
    {
        $this->leagueRepo = $leagueRepo;
    }

    public function results($id){
        $fixture = Fixture::where('league_id', $id)->orderBy('id', 'asc')->get();

        $result = [];
        foreach ($fixture as $item){
            $result[$item['week']][] = $item;
        }

        return view('fixture.results', ['id'=> $id, 'fixture'=>$result]);
    }

    public function playNextFixture($id){
        $this->leagueRepo->playNextFixture($id);
        ProcessMatchResults::dispatch($id);
        return redirect("/league/$id");
    }

    public function playAllFixture($id){
        $this->leagueRepo->playAllMatches($id);
        ProcessMatchResults::dispatch($id);
        return redirect("/league/$id");
    }



    public function editResult($id){
        $fixture = Fixture::find($id);

        return view('fixture.edit', [
            'fixture'=> $fixture,
             'id'=> $id
        ]);
    }

    public function updateResult(Request $request, $id){
        $this->validate($request, [
            'score1' => 'required|digits_between:0,5',
            'score2' => 'required|digits_between:0,5',
        ]);

        $fixture = Fixture::find($id);
        $fixture->goals_team_home = $request->score1;
        $fixture->goals_team_away = $request->score2;
        $fixture->save();

        ProcessMatchResults::dispatch($fixture->league_id);

        return redirect("/league/$fixture->league_id/results");
    }
}
