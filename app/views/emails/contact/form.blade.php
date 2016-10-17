<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Sended message from contact page</h2>

<p>
    <strong>FIRST NAME: </strong> {{$data['firstname']}}
</p>
<p>
    <strong>LAST NAME: </strong> {{$data['lastname']}}
</p>
<p>
    <strong>PHONE: </strong> {{$data['phone']}}
</p>
<p>
    <strong>EMAIL: </strong> {{$data['email']}}
</p>
<p>
    <strong>CHECK IN: </strong> {{$data['check_in']}}
</p>
<p>
    <strong>CHECK OUT: </strong> {{$data['check_out']}}
</p>
<p>
    <strong>INTERESTED IN: </strong> {{$data['cat']}}
</p>
<p>
    <strong>NO. PEOPLE: </strong> {{$data['number']}}
</p>
<p>
    <strong>COMMENTS: </strong> {{$data['comments']}}
</p>

<p>
    &copy;{{Config::get('site.site')}}
</p>

</body>
</html>