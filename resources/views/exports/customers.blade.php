<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>
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
            padding: 5px 0px;
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
        @for ($i = 0; $i < sizeof($customers); $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                @foreach ($columns as $key => $column)
                    @switch($key)
                        @case('first_name')
                            <th>{{ $customers[$i]['people'][$key]  }}</th>
                            @break
                        @case('last_name')
                            <th>{{ $customers[$i]['people'][$key]  }}</th>
                            @break
                        @case('email')
                            <th>{{ $customers[$i]['people'][$key]  }}</th>
                            @break
                        @case('dni')
                            <th>{{ $customers[$i]['people'][$key]  }}</th>
                            @break
                        @case('phone_number')
                            <th>{{ $customers[$i]['people'][$key]  }}</th>
                            @break
                        @case('user_name')
                            <th>{{ $customers[$i]['people']['user'][$key]  }}</th>
                            @break
                        @case('type_customer_id')
                            <th>{{ $customers[$i]['typeCustomer']['type_customer']  }}</th>
                            @break
                        @case('status')
                            <th>{{ \App\Models\Customer::STATUS[$customers[$i]['status']]  }}</th>
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
