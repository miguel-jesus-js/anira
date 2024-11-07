<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel + Vue</title>
    @vite(['resources/js/app.ts', 'resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <menu-component></menu-component>
        <router-view></router-view>
        @yield('content')
    </div>
</body>
</html>
