<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Eksekutif_Travel_{{ $startDate }}_to_{{ $endDate }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm; 
        }
        
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #0f172a;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background: #ffffff;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-container {
            width: 100%;
            max-width: 170mm; 
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
        }

        /* DESAIN KOP SURAT */
        .cop-surat { 
            text-align: center; 
            margin-bottom: 25px; 
        }
        .cop-surat h1 { 
            font-size: 16pt; 
            margin: 0; 
            font-weight: bold; 
            text-transform: uppercase; 
        }
        .cop-surat h2 { 
            font-size: 12pt; 
            margin: 4px 0; 
            color: #0369a1; 
            text-transform: uppercase; 
        }
        .cop-surat .periode { 
            font-size: 10pt; 
            font-style: italic; 
            color: #475569; 
        }
        .cop-surat .garis-kop { 
            border-bottom: 3px solid #0f172a; 
            border-top: 1px solid #0f172a; 
            height: 2px; 
            margin-top: 10px; 
        }
        
        /* JUDUL SUB-BAB LAPORAN */
        .section-title { 
            font-size: 11pt; 
            font-weight: bold; 
            border-left: 4px solid #0369a1; 
            padding-left: 8px; 
            margin: 25px 0 12px 0; 
            text-transform: uppercase; 
            page-break-after: avoid;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
            table-layout: fixed;
        }
        tr { 
            page-break-inside: avoid; 
        }
        th { 
            background-color: #f8fafc; 
            border: 1px solid #475569; 
            padding: 8px 10px; 
            font-size: 10pt; 
            font-weight: bold; 
            text-align: left; 
        }
        td { 
            border: 1px solid #cbd5e1; 
            padding: 8px 10px; 
            font-size: 9.5pt; 
            vertical-align: middle; 
            word-wrap: break-word;
        }
        
        .text-emerald { color: #047857; font-weight: bold; }
        .text-sky { color: #0369a1; font-weight: 500; }
        .text-center { text-align: center; }
        
        .badge { 
            display: block; 
            padding: 3px; 
            font-size: 8pt; 
            font-weight: bold; 
            border-radius: 4px; 
            text-align: center; 
            text-transform: uppercase; 
        }
        .badge-paid { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-unpaid, .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .badge-canceled, .badge-expired { background-color: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3; }

        .kotak-omset { 
            background-color: #ecfdf5; 
            border: 1px solid #86efac; 
            padding: 12px 15px; 
            border-radius: 6px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-top: 25px; 
            page-break-inside: avoid;
        }
        .kotak-omset .label { font-weight: bold; color: #065f46; font-size: 10pt; }
        .kotak-omset .nilai { font-weight: 900; font-size: 14pt; color: #047857; }

        .lembar-pengesahan { 
            margin-top: 40px; 
            float: right; 
            width: 220px; 
            text-align: center; 
            page-break-inside: avoid; 
        }
        .lembar-pengesahan .space { height: 60px; }
        
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <div class="print-container clearfix">

        <div class="cop-surat">
            <h1>Laporan Eksekutif Realisasi Pendapatan</h1>
            <h2>Sistem Reservasi Travel Belitung Begaye</h2>
            <p class="periode">
                Periode Data: 
                {{ \Carbon\Carbon::parse($startDate)->locale('id')->settings(['parseFormat' => 'Y-m-d'])->translatedFormat('d F Y') }} 
                s/d 
                {{ \Carbon\Carbon::parse($endDate)->locale('id')->settings(['parseFormat' => 'Y-m-d'])->translatedFormat('d F Y') }}
            </p>
            <div class="garis-kop"></div>
        </div>

        <div class="section-title">I. Ringkasan Eksekutif Finansial</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%">Indikator Parameter</th>
                    <th style="width: 25%">Volume / Kuantitas</th>
                    <th style="width: 35%">Akumulasi Nilai Capaian</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Total Transaksi Berhasil (Paid)</td>
                    <td>{{ $reservations->where('status', 'paid')->count() }} Kontrak Wisata</td>
                    <td class="text-emerald">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Transaksi Menunggu Pembayaran (Unpaid)</td>
                    <td>{{ $reservations->whereIn('status', ['unpaid', 'pending'])->count() }} Invoice</td>
                    <td>Rp {{ number_format($reservations->whereIn('status', ['unpaid', 'pending'])->sum('total_price'), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Transaksi Dibatalkan / Kedaluwarsa</td>
                    <td>{{ $reservations->whereIn('status', ['canceled', 'expired'])->count() }} Rekaman</td>
                    <td>Rp {{ number_format($reservations->whereIn('status', ['canceled', 'expired'])->sum('total_price'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">II. Daftar Log Transaksi Rinci (FR-11)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 18%">No. Order</th>
                    <th style="width: 17%">Waktu Masuk</th>
                    <th style="width: 19%">Nama Wisatawan</th>
                    <th style="width: 23%">Paket Destinasi Wisata</th>
                    <th style="width: 14%">Subtotal</th>
                    <th style="width: 9%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td style="font-family: monospace; font-weight: bold;">{{ $res->order_id }}</td>
                        <td>{{ optional($res->created_at)->format('d/m/Y H:i') ?? '-' }} WIB</td>
                        <td style="font-weight: bold;">{{ $res->user->name ?? 'Wisatawan' }}</td>
                        <td class="text-sky">{{ $res->package->title ?? 'Paket Pilihan' }}</td>
                        <td style="font-weight: bold;">Rp {{ number_format($res->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($res->status) }}">
                                {{ $res->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 20px; color: #64748b;">
                            Tidak ada transaksi terrekam pada rentang tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="kotak-omset">
            <div class="label">TOTAL REALISASI OMSET PENDAPATAN (SUCCESS):</div>
            <div class="nilai">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        </div>

        <div class="lembar-pengesahan">
            <p>Batam, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold;">Disahkan Oleh,</p>
            <div class="space"></div>
            <p style="font-weight: bold; text-decoration: underline;">Sistem Administrasi Finansial</p>
            <p style="font-size: 8.5pt; color: #64748b;">Pusat Kendali Belitung Begaye</p>
        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>