<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user['first_name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account
<br/>
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a><br/>
If button is not worked then copy and paste below url.<br/><br/>
{{url('user/verify', $user->verifyUser->token)}}
</body>
</html>