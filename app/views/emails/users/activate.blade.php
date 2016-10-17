<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Account Activation</h2>

<p>
    Thank you for registering on {{Config::get('site.title')}} site!
</p>
<p>
    To activate your account, go to this address: {{ URL::to('user/activate', array($user->id, $activation_code)) }}
</p>

<p>
   &copy;{{Config::get('site.domain')}}
</p>

</body>
</html>