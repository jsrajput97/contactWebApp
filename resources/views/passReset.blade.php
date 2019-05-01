@extends('layouts.master')
@section('title')
    Reset Password
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</header>
@section('content')
    <div class="text-center size">
        <h3 class="hsize">Password Reset</h3>
        <form action="{{ route('passreset.link') }}" method="post">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="lsize" for="email">Your E-mail</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ Request::old('email') }}">
            </div>
            <button type="submit" class="lsize" >Send Password Reset Link</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
    </div>
    <div class="err">
        @include('includes.errorMessage')
    </div>
@endsection