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

    <hr>
    @for( $i=0; $i<$cantidad; $i++ )
        {{ $comidas[$i] }} <br>
    @endfor

</body>
</html>
