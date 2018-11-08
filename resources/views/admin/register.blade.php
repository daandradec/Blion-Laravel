@extends('layouts.app')

@section('content')
    <section class="h-100 bg-dark m-0 p-0 center">    
        @include('layouts.forms.registerform',['head' => 'Register Super User','route'=>url('/admin/register')])
    </section>
@endsection