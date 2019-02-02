@extends('layouts.app')

@section('content')
<section class="center">
    <div class="w-75">
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    <br>
                @endif
                @if (session('fail'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('fail') }}
                    </div>
                    <br>
                @endif
                
                <div class="d-flex">
                    <div class="w-50 text-left">
                        <h1 style="font-size:3em;font-weight:bold;">NOMBRE</h1>
                        <hr>
                        <p style="font-size:2em;font-weight:100;">{{Auth::user()->name}}</p>
                        <h2 style="font-size:3em;font-weight:bold;">EMAIL</h2>
                        <hr>
                        <p style="font-size:2em;font-weight:100;">{{Auth::user()->email}}</p>
                    </div>
                    <div class="w-50">
                        @if( config('app.env') == "local" )
                            <p>Estas en local</p>
                            <img src="{{Storage::url(auth()->user()->profilePicturePath() )}}" style="max-width:300px;width:50%;">                
                        @else
                            <img src="{{"https://s3-us-west-1.amazonaws.com/blion-bucket/".auth()->user()->profilePicturePath()}}" style="max-width:300px;width:50%;">                
                        @endif                        
                        <br>
                        <form action="{{route('user.update',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                            {!! method_field('PUT') !!}
                            @csrf
                            <div class="form-group mt-3">
                                <input type="file" name="picture">
                                <br>
                                {!! $errors->first('picture','<span class=error>:message</span>') !!}
                            </div>                                                        
                            
                            <input type="submit" value="enviar" class="btn btn-success">

                        </form>
                    </div>
                </div>
                
                
                


            </div>
        </div>
    </div>
</section>
@endsection