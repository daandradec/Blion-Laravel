@extends('layouts.template')

@section('content')
    <section class="h-100 bg-dark m-0 p-0 center">
        @include('layouts.forms.loginform',['head'=>'Login To Blion','route' => url('/login')])
    </section>
@endsection