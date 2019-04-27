@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Leagues</div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>League Name</th>
                        <th>Fixture Week</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leagues as $league)
                    <tr>
                        <td>{{$league->name}}</td>
                        <td>
                            @if($league->current_week == 0)
                                The League has just created new.
                            @else
                                {{$league->current_week}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('league.show', $league->id)}}" type="button" class="btn btn-primary">Go</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $leagues->links() }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Create a new league</div>
            <div class="panel-body">
                @include('common.errors')

                <form action="{{ route('league.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="leagueName">League Name*:</label>
                        <input type="text" class="form-control" id="leagueName" name="name">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team1">Team 1*:</label>
                                <input type="text" class="form-control" id="team1" name="team1">
                            </div>
                            <div class="form-group">
                                <label for="team2">Team 2*:</label>
                                <input type="text" class="form-control" id="team2" name="team2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team3">Team 3*:</label>
                                <input type="text" class="form-control" id="team3" name="team3">
                            </div>
                            <div class="form-group">
                                <label for="team4">Team 4*:</label>
                                <input type="text" class="form-control" id="team4" name="team4">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Create League</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection