@extends('layout.guest')
@section('content')

    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar"></div>
            <div class="form-box">
                <form action="{{url('/login')}}" method="post">
                    {!! csrf_field() !!}
                    <input name="email" type="email" id="email" placeholder="email">
                    <input name="password" type="password" id="password" placeholder="password">
                    <button class="btn btn-info btn-block login" type="submit">Login</button>
                    <div class="etc-login-form">
                        <!--<input name="remember" id="remember" type="checkbox" class="checkbox"> Remember Me -->
                        <br><p>new user? <a href="{{url('/register')}}">create new account</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>
	
@stop()