@extends('layouts.master')
@section('title')
    Signup
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</header>
@section('content')
    <div class="text-center size" id="sign_up_page">
        <h3 class="hsize">Sign Up</h3>
        <form action="{{ route('signup') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="lsize" for="email">Your E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                <label class="lsize" for="first_name">Your First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="lsize" for="password">Your Password</label>
                <input type="password" class="form-control" name="password" id="password" value="{{ Request::old('password') }}">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="lsize" for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
            </div>
            <button type="submit" class="lsize" >Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
    <div class="err hidden">
        @include('includes.errorMessage')
    </div>
@endsection