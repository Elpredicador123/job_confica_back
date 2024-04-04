<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rutas API</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <h1>Lista de Rutas GET</h1>

        <ul>
            @foreach($routes as $route)
                <li>
                    <strong>Controller:</strong> {{ $route['controller'] }}<br>
                    <strong>Link:</strong> 
                    <a target="_blank" href="{{ env('APP_URL').'/'.$route['url'] }}">{{ env('APP_URL').'/'.$route['url'] }}</a>
                </li>
                <br>
            @endforeach
        </ul>
    </div>
</body>
</html>