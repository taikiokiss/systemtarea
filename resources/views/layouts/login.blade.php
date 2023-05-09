<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name', 'AGENBATEC') }}</title>
    <link rel="icon" type="image/ico" href="/images/icono.ico" />  
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets1/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="/assets1/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets1/css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

      <style>
        .whatsapp {
          position:fixed;
          width:60px;
          height:60px;
          bottom:40px;
          right:40px;
          background-color:#25d366;
          color:#FFF;
          border-radius:50px;
          text-align:center;
          font-size:30px;
          z-index:100;
        }

        .whatsapp-icon {
          margin-top:13px;
        }
    </style>

</head>

<body>
    @yield('content')
  <script src="/assets1/js/jquery-3.4.1.min.js"></script>
  <script src="/assets1/js/popper.min.js"></script>
  <script src="/assets1/js/bootstrap.min.js"></script>    
</body>
</html>
