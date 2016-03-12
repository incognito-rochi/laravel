@extends('layout.guest')
@section('content')

    <div class="container">
        <div class="login-container">
            <div class="form-box">
                <form action="register" method="post">
                    {!! csrf_field() !!}
                    <input name="user" type="text" placeholder="username">
                    <input name="email" type="email" placeholder="email">
                    <input type="password" placeholder="password">
                    <button class="btn btn-info btn-block login" type="submit">Register</button>
                </form>
            </div>
        </div>

    </div>
	
@stop()