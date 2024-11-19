<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css\style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-sma.png') }}" />
    <title>
        {{ @$title != '' ? "$title |" : '' }}
        {{ settings()->get('nama_sistem', 'SiAKeu') }}
      </title>
</head>
<body>
    @yield('content')
</body>
</html>