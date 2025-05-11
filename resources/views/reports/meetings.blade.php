<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background: #eee;
        }
        .status {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">{{ $title }}</h1>
    <p style="text-align:center;">Data wygenerowania: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record['user'] }}</td>
                    <td>{{ $record['date'] }}</td>
                    <td>{{ $record['time'] }}</td>
                    <td>{{ $record['hours_worked'] }}h</td>
                    <td class="status">{{ $record['status'] }}</td>
                    <td>{{ $record['notes'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>