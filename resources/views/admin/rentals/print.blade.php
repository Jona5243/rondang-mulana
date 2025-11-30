<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $rental->id }} - Rondang Mulana</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background: #f3f4f6;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .status-paid {
            color: green;
            border: 1px solid green;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .status-pending {
            color: orange;
            border: 1px solid orange;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        /* Saat dicetak, sembunyikan tombol print bawaan browser jika ada */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <div class="logo">Rondang Mulana</div>
        <div style="text-align: right;">
            <div style="font-size: 20px; font-weight: bold;">INVOICE</div>
            <div>#{{ $rental->id }}</div>
            <div>{{ date('d M Y', strtotime($rental->created_at)) }}</div>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>DITAGIHKAN KEPADA:</strong><br>
                {{ $rental->user->name }}<br>
                {{ $rental->user->email }}<br>
                <br>
                <strong>ALAMAT PENGIRIMAN:</strong><br>
                {{ $rental->address }}
            </td>
            <td width="50%" style="text-align: right;">
                <strong>PERIODE SEWA:</strong><br>
                Mulai: {{ date('d M Y', strtotime($rental->start_date)) }}<br>
                Selesai: {{ date('d M Y', strtotime($rental->end_date)) }}<br>
                <br>
                <strong>STATUS:</strong><br>
                @if ($rental->status == 'completed' || $rental->status == 'approved')
                    <span class="status-paid">SUDAH DISETUJUI</span>
                @else
                    <span class="status-pending">MENUNGGU KONFIRMASI</span>
                @endif
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Harga / Hari</th>
                <th>Jumlah</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rental->items as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->item->name }}</td>
                    <td>Rp {{ number_format($detail->price_per_day, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        GRAND TOTAL: Rp {{ number_format($rental->total_price, 0, ',', '.') }}
    </div>

    <div class="footer">
        Terima kasih telah mempercayakan acara Anda kepada Rondang Mulana.<br>
        Silakan simpan dokumen ini sebagai bukti penyewaan yang sah.
    </div>

</body>

</html>
