@extends('layouts.app')

@section('content')
    <section class="h-100 bg-dark m-0 p-0 center">
        @include('layouts.forms.loginform',['head'=>'Welcome To Blion Admin','route' => url('/admin/login')])
    </section>
@endsection