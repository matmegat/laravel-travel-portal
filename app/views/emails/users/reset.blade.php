<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Password reset</h2>

<p>
    You requested a password reset.
</p>
<p>
    To reset your password, go to this address: {{ URL::to('user/reset/code', array($user->id, $reset_code)) }}
</p>

<p>
   &copy;{{Config::get('site.domain')}}
</p>

</body>
</html>