<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name', 'SystemTarea') }}</title>
  <link rel="icon"  href="/images/icons/cropped-logo.webp" />  
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets1/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="/assets1/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets1/css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @yield('content')
  <script src="/assets1/js/jquery-3.4.1.min.js"></script>
  <script src="/assets1/js/popper.min.js"></script>
  <script src="/assets1/js/bootstrap.min.js"></script>    
</body>
</html>
