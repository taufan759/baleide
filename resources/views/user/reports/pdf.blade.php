<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas - Baleide</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6366f1;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #6366f1;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            page-break-inside: avoid;
        }
        .info-section h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 5px;
        }
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            flex: 1;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
            border-radius: 5px;
        }
        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #6366f1;
        }
        .stat-box .label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #6366f1;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .print-btn:hover {
            background: #4f46e5;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak / Simpan PDF
    </button>

    <div class="header">
        <h1>LAPORAN AKTIVITAS BALEIDE</h1>
        <p><strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
        <p>Periode: {{ $startDate ? $startDate->format('d/m/Y') : 'Semua' }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h3>Ringkasan Statistik</h3>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="value">{{ $stats['total_transactions'] }}</div>
                <div class="label">Total Transaksi</div>
            </div>
            <div class="stat-box">
                <div class="value">Rp {{ number_format($stats['total_spending'], 0, ',', '.') }}</div>
                <div class="label">Total Pengeluaran</div>
            </div>
            <div class="stat-box">
                <div class="value">{{ $stats['total_books'] }}</div>
                <div class="label">Total Buku Dibeli</div>
            </div>
            <div class="stat-box">
                <div class="value">{{ $stats['period'] }}</div>
                <div class="label">Periode Laporan</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Breakdown Per Kategori</h3>
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Kategori</th>
                    <th width="20%">Jumlah Buku</th>
                    <th width="35%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($categoryBreakdown as $category => $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $category }}</strong></td>
                        <td>{{ $data['count'] }} buku</td>
                        <td>Rp {{ number_format($data['total_price'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="info-section">
        <h3>Riwayat Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="10%">ID</th>
                    <th width="40%">Item Buku</th>
                    <th width="20%">Total</th>
                    <th width="15%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                    <tr>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td>#{{ $trx->id }}</td>
                        <td>
                            @foreach($trx->items as $item)
                                • {{ $item->ebook->title }}<br>
                            @endforeach
                        </td>
                        <td><strong>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</strong></td>
                        <td>Berhasil</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem Baleide</p>
        <p>© {{ date('Y') }} Baleide - Platform E-Book Digital</p>
    </div>

    <script>
        // Auto print saat load (optional)
        // window.onload = () => window.print();
    </script>
</body>
</html>
