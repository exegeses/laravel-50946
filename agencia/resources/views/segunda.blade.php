<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Segunda Vista</title>
</head>
<body>
    <h1>Segunda Vista (Blade)</h1>

    {{ date('d/m/Y') }}
    <br>

    @if ( $nombre == 'marcos' )
        bievenido {{ $nombre }}
    @else
        usuario desconocido
    @endif



</body>
</html>
