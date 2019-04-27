@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit Result</div>
                <div class="panel-body">
                    @include('common.errors')
                    <form action="{{url("/fixture/$id/results/update")}}" method="POST">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-sm-1 col-sm-offset-2">
                                <strong>{{ $fixture->homeTeam->name }}</strong>
                            </div>
                            <div class="col-sm-2">
                                <input type="number" name="score1" class="form-control" value="{{ $fixture->goals_team_home}}"/>
                            </div>
                            <div class="col-sm-1">
                                -
                            </div>
                            <div class="col-sm-2">
                                <input type="number" name="score2" class="form-control" value="{{ $fixture->goals_team_away}}"/>
                            </div>
                            <div class="col-sm-1">
                                <strong> {{ $fixture->awayTeam->name }}</strong>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection