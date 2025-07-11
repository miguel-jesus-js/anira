<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tipo de empleados</title>
    <style>
        table {
            border-collapse: collapse;
            font-size: 0.8em;
            font-family: sans-serif;
            min-width: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        table thead tr {
            background-color: #000;
            color: #ffffff;
        }
        table th, table td {
            text-align: center;
            padding: 5px 0;
        }
        table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        .desc{
            border-collapse: collapse;
            font-size: .8em;
            font-family: sans-serif;
            width: 150px;
            float: right;
            position: absolute;
            top: -20px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>N°</th>
            @foreach ($columns as $column)
                <th>{{ $column  }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < sizeof($type_employees); $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                @foreach ($columns as $key => $column)
                    @switch($key)
                        @case('id')
                            <th>{{ $type_employees[$i][$key]  }}</th>
                            @break
                        @case('type_employee')
                            <th>{{ $type_employees[$i][$key]  }}</th>
                            @break
                        @case('status')
                            <th>{{ $type_employees[$i]['status_text']  }}</th>
                            @break
                    @endswitch
                @endforeach
            </tr>

        @endfor
        </tbody>
    </table>
</div>
</body>
</html>
