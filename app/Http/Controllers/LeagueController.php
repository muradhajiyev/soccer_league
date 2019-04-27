<?php

namespace App\Http\Controllers;

use App\Fixture;
use App\Jobs\ProcessMatchResults;
use App\League;
use App\Repositories\LeagueRepository;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    protected $leagueRepo;

    public function __construct(LeagueRepository $leagueRepo)
    {
        $this->leagueRepo = $leagueRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('league.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'team1' => 'required|max:100',
            'team2' => 'required|max:100',
            'team3' => 'required|max:100',
            'team4' => 'required|max:100',
        ]);

        $leagueId =$this->leagueRepo->storeToDb($request->name, $request->team1, $request->team2, $request->team3, $request-> team4);
        ProcessMatchResults::dispatch($leagueId);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $standings = $this->leagueRepo->getStandings($id);
        $league = League::find($id);
        return view('league.show', [
            'id'=>$id,
            'league' => $league,
            'standings' => $standings]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
