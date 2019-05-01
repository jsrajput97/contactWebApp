@extends('layouts.master')
@section('title')
    Login
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</header>
@section('content')
    <div class="text-center size">
        <h3 class="hsize">Sign In</h3>
        <form action="{{ route('signin') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="lsize" for="email">Your E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="lsize" for="password">Your Password</label>
                <input type="password" class="form-control" name="password" id="password" value="{{ Request::old('password') }}">
            </div>
            <button type="submit" class="lsize" >Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
        <a href="{{ route('resetpass') }}">Forgot Password?</a>
    </div>
    <div class="err hidden">
        @include('includes.errorMessage')
    </div>

@endsection