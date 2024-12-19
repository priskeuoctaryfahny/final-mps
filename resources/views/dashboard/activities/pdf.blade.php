<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ public_path('backend\bootstrap4\css\bootstrap.min.css') }}">
</head>

<body>
    <h2 class="text-center">{{ $title }}</h2>
    <p class="text-center">{{ $dateFilter }}</p>
    <small>
        {{ $paperSize }} ({{ $orientation }})
    </small>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center align-middle">
                <th class="align-middle">No</th>
                @foreach ($columns as $column)
                    @if (in_array($column, $selectedColumns))
                        <th class="align-middle">{{ $columnLabels[$column] }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($exportData as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    @foreach ($columns as $column)
                        @if (in_array($column, $selectedColumns))
                            <td>
                                @if ($column === 'user_id')
                                    {{ $data->user->email }}
                                @elseif($column === 'created_at')
                                    <span class="badge badge-success">
                                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y H:i:s') }}
                                        WIB
                                    </span>
                                @else
                                    {{ $data->{$column} }}
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
