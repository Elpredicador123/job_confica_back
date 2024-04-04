<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Importar</title>
</head>
<body>
    <form action="{{ route('import.file') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Añade un ID al input de tipo file -->
        <input type="file" name="file" id="file-input">
        <!-- Añade un ID al botón de submit -->
        <button type="submit" id="submit-button">Importar</button>
    </form>
    @if (session('message'))
        <p id="message">{{ session('message') }}</p>
    @endif
</body>
</html>
