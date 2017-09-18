<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <link href="js/app.js" rel="stylesheet" type="text/css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top:200px">
                    {!! Form::open(['route' => 'get-data', 'method' => 'get', 'class'=>'form-horizontal']) 
                    !!}
                    	<fieldset class="content-group">
                            <div class="form-group">
                                <label class="control-label col-md-3">Tweet URL</label>
                                <div class="col-md-6">
                                    {!! Form::text('tweet_url',null, 
                                        array(
                                            'required', 
                                            'class'     =>'form-control',
                                            'Tweet URL' =>''
                                        )) 
                                    !!}
                                    <p class="text-danger list">{!! $errors->first('tweet_url') !!}</p>
                                </div>
                                <div class="col-md-3">
                                    {!! Form::submit('Get Reach', 
                                        array('class'=>'btn bg-teal-400'))
                                    !!}
                                </div>                                  
                            </div>                                   
                        </fieldset>                         
                    {!! Form::close() !!}
                </div>
                <div class="col-md-12">
                    @if(!empty($tweet))
                        <table class="table table-striped ">
                            <tr>
                                <th width="50%">Tweet Id</th>
                                <td>{{ $tweet->tweet_id }}</td>
                            </tr>

                            <tr>
                                <th width="50%">Total Retweets</th>
                                <td>{{ $tweet->total_retweets }}</td>
                            </tr>

                            <tr>
                                <th>Counted Retweets</th>
                                <td>{{ $tweet->counted_retweets }}</td>
                            </tr>

                            <tr>
                                <th>Reach</th>
                                <td>{{ $tweet->reach}}</td>
                            </tr>

                            <tr>
                                <th>Last Update</th>
                                <td>{{ $tweet->updated_at ? $tweet->updated_at->format('jS F Y H:i') : '' }} at {{ $tweet->updated_at ? $tweet->updated_at->format('h:i A') : '' }}</td>
                            </tr>

                        </table>                    
                        <p class="text-warning">Reach metric is calculated from the last {{ $tweet->counted_retweets }} retweets! </p>
                    @endif

                </div>
            </div>     
        </div>
    </body>
</html>
