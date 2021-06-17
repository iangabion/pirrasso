<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" 
    integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
  </head>
<body>
    <div>
        <h3>Here is your security code:</h3>
        <h2>{{$code}}</h2>
            <p>
                Hello {{$user['username']}}!
                <br>
                <br>
                    We have received a security request for your Brocante account. Please use the code above to reset your password.
                <br>
                <br>
                    Note: The code will expire in 15 minutes, so please check back soon!
            </p>
    </div>
</body>
</html>
