<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="{{ public_path('backend\bootstrap4\css\bootstrap.min.css') }}" rel="stylesheet">
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
        <thead class="text-center">
            <tr class="text-center">
                <th>No</th>
                @if (in_array('nomor_agenda', $selectedColumns))
                    <th>{{ $columnLabels['nomor_agenda'] }}</th>
                @endif
                @if (in_array('nama_agenda_renstra', $selectedColumns))
                    <th>{{ $columnLabels['nama_agenda_renstra'] }}</th>
                @endif
                @if (in_array('deskripsi_uraian_renstra', $selectedColumns))
                    <th>{{ $columnLabels['deskripsi_uraian_renstra'] }}</th>
                @endif
                @if (in_array('disposisi_diteruskan', $selectedColumns))
                    <th>{{ $columnLabels['disposisi_diteruskan'] }}</th>
                @endif
                @if (in_array('tanggal_mulai', $selectedColumns))
                    <th>{{ $columnLabels['tanggal_mulai'] }}</th>
                @endif
                @if (in_array('tanggal_akhir', $selectedColumns))
                    <th>{{ $columnLabels['tanggal_akhir'] }}</th>
                @endif
                @if (in_array('status', $selectedColumns))
                    <th>{{ $columnLabels['status'] }}</th>
                @endif
                @if (in_array('is_terlaksana', $selectedColumns))
                    <th>{{ $columnLabels['is_terlaksana'] }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($rendiss as $index => $rendis)
                <tr>
                    <td  class="text-center">{{ $index + 1 }}</td>
                    @if (in_array('nomor_agenda', $selectedColumns))
                        <td>{{ $rendis->nomor_agenda }}</td>
                        <!-- Pastikan ini sesuai dengan data yang ingin ditampilkan -->
                    @endif
                    @if (in_array('nama_agenda_renstra', $selectedColumns))
                        <td>{{ $rendis->nama_agenda_renstra }}</td>
                    @endif
                    @if (in_array('deskripsi_uraian_renstra', $selectedColumns))
                        <td>{{ $rendis->deskripsi_uraian_renstra }}</td>
                    @endif
                    @if (in_array('disposisi_diteruskan', $selectedColumns))
                        <td>{{ $rendis->disposisi_diteruskan }}</td>
                    @endif
                    @if (in_array('tanggal_mulai', $selectedColumns))
                        <td>{{ $rendis->tanggal_mulai }}</td>
                    @endif
                    @if (in_array('tanggal_akhir', $selectedColumns))
                        <td>{{ $rendis->tanggal_akhir }}</td>
                    @endif
                    @if (in_array('status', $selectedColumns))
                        <td>{{ $rendis->status == 'Active' ? 'Aktif' : 'Tidak Aktif'}}</td>
                    @endif
                    @if (in_array('is_terlaksana', $selectedColumns))
                        <td>{{ $rendis->is_terlaksana ==1 ? 'Terlaksana' : 'Tidak Terlaksana' }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
