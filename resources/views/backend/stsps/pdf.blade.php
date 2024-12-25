<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ public_path('assets\css\bootstrap.min.css') }}">
    <style>
        /* Add your custom styles here */
        body {
            font-size: 12pt;
            font-family: Arial, sans-serif;
        }

        .logo {
            width: 75px;
            /* Adjust the width as needed */
            height: auto;
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }
    </style>
</head>

<body>
    <table class="table-sm table-borderless w-100 mb-2"
        style="border-color: black !important;border-bottom-style:double !important;border-bottom:3px;line-height:1.2;">
        <tr>
            <td style="width: 15% !important;" class="text-center">
                <img src="{{ public_path('assets\assets\img\logos\logoDinkes.png') }}" alt="Logo" class="logo">
            </td>
            <td style="width: 85% !important;" class="text-center">
                <span style="font-size: 15pt;"><strong>PEMERINTAH KABUPATEN CIAMIS</strong></span><br>
                <span style="font-size: 15pt;"><strong>DINAS KESEHATAN</strong></span><br>
                <span>
                    Jalan. Mr. Iwa Kusumasomantri No 12<br>
                    Tlp. (0265) 771139, Faximile (0265) 773828 <br>
                    Website: www.dinkes.ciamiskab.go.id , Pos 46213
                </span>
            </td>
        </tr>
    </table><br>

    <table class="table table-sm table-borderless" style="line-height: 8px;">
        <tr>
            <td style="width: 15%; margin-left:-50px;">Nomor</td>
            <td>: {{ $letter->letter_number }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>: {{ $letter->letter_number }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: Tidak ada</td>
        </tr>
    </table>

    <div style="text-indent: 20px;" class="mt-0 pt-0">
        <p class="mb-0 pb-0" style="text-indent: 0;">Dengan hormat,</p>
        <p>{{ $letter->content }}</p>
    </div>

    <table class="table table-sm table-borderless mb-0" style="line-height: 8px;">
        <tr>
            <td style="width: 15%;">Hari/Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($letter->date)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>: Mulai - selesai</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: Dinas Kesehatan</td>
        </tr>
    </table>

    <p class="mt-0">ini penutup</p><br>


    <table class="table table-sm table-borderless mt-5" style="page-break-after: avoid;">
        <tr class="text-center">
            <td style="width: 40%;"></td>
            <td style="width: 20%;">
            </td>
            <td style="width: 40%;">
                <span>Hormat kami,</span><br>
                <span>Web Developer</span>
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td></td>
            <td>
                <img src="{{ public_path('assets\assets\img\logos\logoDinkes.png') }}" alt="Logo" class="logo"
                    style="width: 60px !important">
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td></td>
            <td>
                <strong><u>Lord Daud</u></strong><br>
                NIP. 1241241241241
            </td>
        </tr>
    </table>
</body>

</html>
