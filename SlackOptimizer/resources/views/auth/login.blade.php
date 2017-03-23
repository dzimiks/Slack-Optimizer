@extends('layouts.app')
@section('content')

<h1>Login</h1><br/>
<form role="form" method="POST" action="{{ url('/login') }}">
    {{ csrf_field() }}

    <label for="email">E-Mail Address</label>

    <input class="alignRight" id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
    <br/>

    @if ($errors->has('email'))
        <span class="error" style="clear: both;">
            {{ $errors->first('email') }}
        </span>
    @endif<br/>


    <label for="password">Password</label>


    <input class="alignRight" id="password" type="password" name="password">
    <br/>

    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif<br/>




    <label><input type="checkbox" name="remember"> Remember Me </label><br/><br/>


    <button type="submit" class="submit">Login</button>

    <a class="alignRight" href="{{ url('/password/reset') }}">Forgot Your Password?</a><br/>
    <a href="/register">Register</a>
</form>

@endsection