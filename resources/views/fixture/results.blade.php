@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <a href="{{url("league/$id")}}" ><strong>Return to League</strong></a>
        <br>
        <div class="panel panel-primary">
            <div class="panel-heading">All Match Results</div>
            <div class="panel-body">
                @foreach($fixture as $key=>$item)
                <h5 style="text-align: center">{{$key}} th week match results</h5>
                <table class="table">
                    @foreach($item as $match)
                    <tr>
                        <td><strong>{{$match->homeTeam->name}}</strong></td>
                        <td>{{$match->goals_team_home}} - {{$match->goals_team_away}}</td>
                        <td><strong>{{$match->awayTeam->name}}</strong></td>
                        <td>
                            <a href="{{url("/fixture/$match->id/results/edit")}}" type="button" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection