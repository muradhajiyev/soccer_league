@extends('layouts.app')


@section('content')

    <h2>League Name: {{$league->name}}
    </h2>
   <div class="row">
       <div class="col-md-6">
           <div class="panel panel-primary">
               <div class="panel-heading">League Table</div>
               <div class="panel-body">
                   <div class="table-responsive">
                       <table class="table table-bordered table-hover">
                           <thead>
                           <tr>
                               <th>Teams</th>
                               <th>Played</th>
                               <th>Won</th>
                               <th>Drawn</th>
                               <th>Lost</th>
                               <th>GF</th>
                               <th>GA</th>
                               <th>GD</th>
                               <th>Points</th>
                           </tr>
                           </thead>
                           <tbody>
                           @foreach($standings as $stat)
                           <tr>
                               <td>{{$stat->team->name}}</td>
                               <td>{{$stat->played}}</td>
                               <td>{{$stat->won}}</td>
                               <td>{{$stat->drawn}}</td>
                               <td>{{$stat->lost}}</td>
                               <td>{{$stat->gf}}</td>
                               <td>{{$stat->ga}}</td>
                               <td>{{$stat->gd}}</td>
                               <td><strong>{{$stat->points}}</strong></td>
                           </tr>
                               @endforeach
                           </tbody>
                       </table>

                   </div>
               </div>
           </div>
       </div>
       <div class="col-md-5 col-md-offset-1">
           <div class="panel panel-primary">
               <div class="panel-heading">Match Results</div>
               <div class="panel-body">
                   @if($league->current_week == 0)
                       <h5 style="text-align: center">The League has just created new.</h5>
                   @else
                       <h5 style="text-align: center">{{$league->current_week}} th week match results</h5>
                   @endif
                    <table class="table">
                        @foreach($league->last_week_results as $result)
                        <tr>
                            <td>{{$result->homeTeam->name}}</td>
                            <td>{{$result->goals_team_home}} - {{$result->goals_team_away}}</td>
                            <td>{{$result->awayTeam->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                   <a href="{{ url('/league/'.$id.'/results') }}" class="btn btn-primary">All Results</a>
               </div>
           </div>
       </div>
   </div>
    @if($league->current_week >= 4)
   <div class="row">
       <div class="col-md-6 col-md-offset-3">
           <div class="panel panel-primary">
               <div class="panel-heading">Predictions of Championships</div>
               <div class="panel-body">
                   <h5 style="text-align: center">{{$league->current_week}} th week predictions of Championship</h5>
                   <table class="table">
                       <tr>
                           <td>Galatasaray</td>
                           <td>45%</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
       @endif
       <div class="col-md-3">
           @if($league->has_next_fixture)
               <form action="{{ url('/playNextFixture/'.$id) }}" method="POST">
                   {{csrf_field()}}
                   <input type="submit" class="btn btn-primary" value="Play Next">
               </form>

               <form action="{{ url('/playAllFixture/'.$id) }}" method="POST">
                   {{csrf_field()}}
                   <input type="submit" class="btn btn-danger" value="Play All">
               </form>
            @else
                <h4>League finished.</h4>
            @endif
       </div>
   </div>

@endsection