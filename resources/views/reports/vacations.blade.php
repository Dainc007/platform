<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 text-xs">
    <div class="text-center mb-8">
        <h1 class="text-lg font-bold mb-2">{{ $title }}</h1>
        <p class="text-xs text-gray-600">Data wygenerowania: {{ $date }}</p>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th class="border border-gray-300 bg-gray-50 p-2 font-semibold text-xs">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr class="even:bg-gray-50">
                    <td class="border border-gray-300 p-2 text-center w-[15%]">{{ $record['user'] }}</td>
                    <td class="border border-gray-300 p-2 text-center w-[15%]">{{ $record['start_date'] }}</td>
                    <td class="border border-gray-300 p-2 text-center w-[15%]">{{ $record['end_date'] }}</td>
                    <td class="border border-gray-300 p-2 text-center w-[15%]">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold min-w-[80px] 
                            @if($record['status'] === 'accepted')
                                text-green-800
                            @elseif($record['status'] === 'rejected')
                                text-red-800
                            @else
                                text-yellow-800
                            @endif">
                            {{ $record['status'] }}
                        </span>
                    </td>
                    <td class="border border-gray-300 p-2 text-center w-[40%]">{{ $record['message'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 