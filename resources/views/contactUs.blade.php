@extends('layouts.master')
@section('title')
    Contact Us
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
</header>
@section('content')
    <div class="about_box">
        <div class="text-center">
            <h3 style="color: yellowgreen; font-size: 30px"><b>About Me</b></h3>
        </div>
        <footer style="width: fit-content; width: -moz-fit-content; float: bottom; margin-left: auto; margin-right: auto; ">
            <div class="chip">
                <img src="{{ Url::to('images/rajput.jpg') }}" alt="Rajput Boy" width="150" height="150">
                <b>Jitendra Singh Shekhawat</b>
            </div>
            @if(strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android'))
                <p>Mobile Number: <a href="tel:+917014967427">+917014967427</a> </p>
            @else
                <p>Mobile Number: <b style="color: blue">+917014967427</b> </p>
            @endif
            <p>Email Id: <a href="mailto:jitendrasinghjs1997@gmail.com" style="color: #cbb956">jitendrasinghjs1997@gmail.com</a> </p>
            <p>Address: Ramgarh Shekhawati, Sikar(Rajasthan), India.</p>
        </footer>

    </div>
    <div class="text-center">
        <h4 style="margin-top: 30px;">You can send mail to my email id for any query or problem regarding to my site.</h4>
    </div>
@endsection