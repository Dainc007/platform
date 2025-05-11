<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Data wygenerowania: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Pracownik</th>
                <th>Data rozpoczęcia</th>
                <th>Data zakończenia</th>
                <th>Status</th>
                <th>Wiadomość</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record['user'] }}</td>
                <td>{{ $record['start_date'] }}</td>
                <td>{{ $record['end_date'] }}</td>
                <td>
                    <span class="status status-{{ $record['status'] }}">
                        {{ $record['status'] }}
                    </span>
                </td>
                <td>{{ $record['message'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 