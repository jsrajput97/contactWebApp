@extends('layouts.master')
@section('title')
    Reset Password
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</header>
@section('content')
    <div class="text-center size">
        <h3 class="hsize">Reset Password</h3>
        <form action="{{ route('reset.pass') }}" method="post">
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="lsize" for="password">New Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="lsize" for="confirm_password">Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
            </div>
            <button type="submit" class="lsize" >Submit</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <input type="hidden" name="_usertoken" value="{{ $usertoken }}">
        </form>
    </div>
    <div class="err">
        @include('includes.errorMessage')
    </div>
@endsection