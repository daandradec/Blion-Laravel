@extends('layouts.app')

@section('content')
    <section>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>id</th>
                    <th>email</th>
                    <th>verified</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->email_verified_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection