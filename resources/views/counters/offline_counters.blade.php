<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hisoblagich ma'lumotlari</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> {{-- Mobile responsiveness --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .wrapper {
            background-color: white;
            max-width: 100%;
            width: 600px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            word-break: break-word;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
            width: 40%;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <h1>Hisoblagich ma'lumotlari</h1>

    @if ($counter)
        <table>
            <tr>
                <th>ID</th>
                <td>{{ $counter->id }}</td>
            </tr>
            <tr>
                <th>Serial Number</th>
                <td>{{ $counter->serial_number }}</td>
            </tr>
            <tr>
                <th>Caliber</th>
                <td>{{ $counter->caliber }}</td>
            </tr>
            <tr>
                <th>Production Time</th>
                <td>{{ $counter->production_time }}</td>
            </tr>
            <tr>
                <th>Producer Country</th>
                <td>{{ $counter->producer_country }}</td>
            </tr>
            <tr>
                <th>Supplier</th>
                <td>{{ $counter->supplier }}</td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>{{ $counter->phone_number }}</td>
            </tr>
            <tr>
                <th>Hash</th>
                <td>{{ $counter->hash }}</td>
            </tr>
        </table>
    @else
        <p>Counter not found.</p>
    @endif
</div>

</body>
</html>
