<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                @if (in_array('name', $selectedColumns))
                    <th>{{ $columnLabels['name'] }}</th>
                @endif
                @if (in_array('email', $selectedColumns))
                    <th>{{ $columnLabels['email'] }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if (in_array('name', $selectedColumns))
                        <td>{{ $user->name }}</td>
                        <!-- Pastikan ini sesuai dengan data yang ingin ditampilkan -->
                    @endif
                    @if (in_array('email', $selectedColumns))
                        <td>{{ $user->email }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
