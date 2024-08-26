<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My blog</title>
    <link rel="stylesheet" href="/app.css">
</head>

<body>
    {{-- Si el nombre de la variable es $slot, no es necesario definir un x-slot en el componente --}}
    {{ $content }}
</body>

</html>
