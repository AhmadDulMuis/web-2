<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Daftar Ruangan</title>
    </head>

    <body>
        <h1>Daftar Ruangan</h1>
        <ul>
            @foreach ($ruangs as $ruanf)
                <li>
                    {{ $ruang->kode }} - {{ $ruang->nama }} - {{ $ruang->status }}
                </li>
            @endforeach
    </body>

</html>
