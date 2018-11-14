@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">                    
                    Dashboard                  

                    <div class="nav-item dropdown float-right">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <br>
                    <img src="{{Storage::url(auth()->user()->avatar)}}" width="300px">
                    
                    <br>
                    <form action="{{route('image',1)}}" method="POST" enctype="multipart/form-data">
                        <input type="file" name="file">
                        <input type="submit" value="enviar">
                    </form>
                    {{--<a href="{{route('users.show',auth()->user()->id)}}" class="btn btn-success">My User</a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
