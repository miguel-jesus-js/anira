<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Vue</title>
    @vite(['resources/js/app.ts', 'resources/css/app.css'])
</head>
<body>
    <div id="app">
        <menu-component></menu-component>
        @yield('content')
    </div>
</body>
</html>
