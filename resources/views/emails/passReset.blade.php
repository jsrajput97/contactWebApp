<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>

<body>
<h2>Welcome to the site {{$user['first_name']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} .<br />
We received request to reset your password , Please click on the below link to reset your password
<br/>
<br/>
<a href="{{url('user/passreset', $user->PassReset->token)}}">Reset Password</a><br/>
If button is not worked then copy and paste below url.<br/><br/>
{{url('user/passreset', $user->PassReset->token)}}
</body>
</html>