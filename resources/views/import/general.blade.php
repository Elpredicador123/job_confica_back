<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Importación Actividades Generales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="h2 py-5 bg-black text-light text-uppercase">Importación Actividades Generales</h1>
            </div>
            <div class="col-12 py-3">
                <p>"El archivo debe ser de tipo CSV text/plain"</p>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('importgeneral.file') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file-input" class="form-label">Archivo</label>
                <input class="form-control" type="file" name="file" id="file-input">
                <button type="submit" id="submit-button" class="btn btn-primary mt-3">Importar</button>
            </form>
            @if (session('message'))
                <div id="message" class="my-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Correcto!</strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="my-3" id="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error de validación!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
