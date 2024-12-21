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
                <th class="text-center">No</th>
                @foreach ($columns as $column)
                    @if (in_array($column, $selectedColumns))
                        <th class="text-center">{{ $columnLabels[$column] }}</th>
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
                            <td class="text-center">
                                @if ($column === 'created_by' || $column === 'updated_by')
                                    {{ \App\Models\User::where('id', $data->{$column})->first()->name }}
                                @elseif ($column === 'gas_id')
                                    {{ $data->gas->name }}
                                @elseif ($column === 'type')
                                    @if ($data->type == 'in')
                                        <span class="badge badge-success">Masuk</span>
                                    @elseif($data->type == 'out')
                                        <span class="badge badge-danger">Keluar</span>
                                    @endif
                                @elseif($column === 'transaction_date')
                                    {{ $data->transaction_date->translatedFormat('d F Y') }}
                                @elseif($column === 'status')
                                    @if ($data->status == 'completed')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($data->status == 'canceled')
                                        <span class="badge badge-danger">Batal</span>
                                    @elseif($data->status == 'pending')
                                        <span class="badge badge-warning">Proses</span>
                                    @endif
                                @elseif ($column === 'total_amount' || $column === 'amount' || $column === 'optional_amount')
                                    Rp {{ number_format($data->{$column}, 0, ',', '.') }}
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
