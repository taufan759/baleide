<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Transaksi - Baleide</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 30px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header p {
            font-size: 14px;
            color: #7f8c8d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #3498db;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .total-amount {
            font-weight: bold;
            color: #2c3e50;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #7f8c8d;
        }

        @media print {
            body {
                margin: 0;
                background-color: #fff;
            }
            .container {
                box-shadow: none;
                width: 100%;
                max-width: none;
            }
            th {
                background-color: #3498db !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>Laporan Transaksi Baleide</h1>
            <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Order ID</th>
                    <th width="20%">User / Pelanggan</th>
                    <th width="15%">Diskon</th>
                    <th width="15%">Total Bayar</th>
                    <th width="15%">Status</th>
                    <th width="15%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaction->midtrans_order_id ?? '-' }}</td>
                        <td>{{ $transaction->user_name }}</td>
                        <td>Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                        <td class="total-amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->payment_status) }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>&copy; {{ date('Y') }} <strong>Baleide</strong>. Semua hak dilindungi.</p>
            <p>Laporan ini dihasilkan secara otomatis oleh sistem administrasi Baleide.</p>
        </div>
    </div>
</body>
</html>