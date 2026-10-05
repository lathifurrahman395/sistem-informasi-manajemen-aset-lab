<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Jadwal Penggunaan Semua Lab</title>
    <style>
        @page {
            margin: 24px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            font-size: 11px;
        }

        .lab-page {
            page-break-after: always;
        }

        .lab-page:last-child {
            page-break-after: auto;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #b8860b;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 4px 0;
            color: #1f2937;
        }

        .header p {
            margin: 0;
            font-size: 12px;
            color: #6b7280;
        }

        .lab-badge {
            display: inline-block;
            background: #b8860b;
            color: #fff;
            padding: 4px 14px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 13px;
            margin-top: 6px;
        }

        .day-block {
            margin-bottom: 14px;
        }

        .day-title {
            background: #f3f4f6;
            border-left: 4px solid #b8860b;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #fafafa;
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .col-jam {
            width: 18%;
            font-weight: bold;
        }

        .col-matkul {
            width: 42%;
        }

        .col-dosen {
            width: 40%;
            font-size: 10px;
        }

        .empty-day {
            padding: 8px;
            color: #9ca3af;
            font-style: italic;
            font-size: 10px;
        }

        .footer {
            margin-top: 24px;
            text-align: right;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    @foreach ($locations as $location)
    <div class="lab-page">
        <div class="header">
            <h1>Jadwal Penggunaan Laboratorium</h1>
            <p>SI-ASET UNIMAL — Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}</p>
            <div class="lab-badge">{{ $location->nama_lab }}</div>
        </div>

        @php $jadwal = $jadwalPerLab[$location->id] ?? collect(); @endphp

        @foreach ($hariUrutan as $hari)
        <div class="day-block">
            <div class="day-title">{{ $hari }}</div>

            @if (isset($jadwal[$hari]) && $jadwal[$hari]->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-jam">Jam</th>
                        <th class="col-matkul">Mata Kuliah / Kegiatan</th>
                        <th class="col-dosen">Dosen Pengampu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal[$hari] as $item)
                    <tr>
                        <td class="col-jam">{{ $item->waktu }}</td>
                        <td class="col-matkul">{{ $item->keperluan }}</td>
                        <td class="col-dosen">{{ $item->user_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-day">Tidak ada jadwal pada hari ini.</div>
            @endif
        </div>
        @endforeach

        <div class="footer">
            Dokumen ini digenerate otomatis oleh sistem SI-ASET UNIMAL.
        </div>
    </div>
    @endforeach

</body>

</html>