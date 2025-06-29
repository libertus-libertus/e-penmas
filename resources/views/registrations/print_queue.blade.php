<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Antrean</title>
    {{-- Tailwind CSS untuk styling dasar --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background-color: #f0f0f0; /* Warna latar belakang untuk tampilan non-cetak */
        }
        .print-container {
            width: 80mm; /* Lebar standar kertas struk, bisa disesuaikan */
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            text-align: center;
            font-size: 14px; /* Ukuran font default untuk struk */
            color: #333;
        }
        .header {
            margin-bottom: 10px;
            border-bottom: 1px dashed #aaa;
            padding-bottom: 5px;
        }
        .header h1 {
            font-size: 1.2em; /* Ukuran font judul Puskesmas */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 0.8em; /* Ukuran font alamat/kontak */
            line-height: 1.2;
            margin: 0;
        }
        .details {
            text-align: left;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
        .details div {
            margin-bottom: 4px;
        }
        .details strong {
            display: inline-block;
            width: 80px; /* Lebar untuk label */
        }
        .queue-number-display {
            font-size: 3em; /* Ukuran sangat besar untuk nomor antrean */
            font-weight: bold;
            margin: 20px 0;
            padding: 10px 0;
            border-top: 1px dashed #aaa;
            border-bottom: 1px dashed #aaa;
        }
        .footer {
            font-size: 0.7em;
            margin-top: 15px;
            color: #777;
        }

        /* CSS untuk mode cetak */
        @media print {
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
                /* Nonaktifkan margin default browser */
                -webkit-print-color-adjust: exact; /* Untuk cetak warna latar belakang/gambar */
                print-color-adjust: exact;
            }
            .print-container {
                width: 100%; /* Lebar penuh di mode cetak */
                box-shadow: none;
                margin: 0;
                padding: 0;
                page-break-after: always; /* Pastikan setiap struk ada di halaman baru */
            }
            .no-print {
                display: none; /* Sembunyikan elemen non-cetak */
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="header">
            <h1>Puskesmas Nanggalo Siteba</h1>
            <p>Jl. Padang Perumnas Siteba, Kel. Surau Gadang, Nanggalo, Padang City, West Sumatra 25173</p>
            <p>No. Telp: (0751) 7878690</p>
            <p>Email: puskesmasnanggalo_hcn@yahoo.co.id</p>
        </div>

        <div class="details">
            <div><strong>Nama Pasien</strong> : {{ $registration->patientDetail->user->name ?? 'N/A' }}</div>
            <div><strong>Tanggal Kunjungan</strong> : {{ $registration->visit_date->format('d/m/Y') }}</div>
        </div>

        <div class="queue-number-display">
            {{ sprintf('%03d', $registration->queue_number) }}
        </div>

        <div class="footer">
            <p>Terima Kasih Atas Kunjungan Anda</p>
            <p>Waktu Cetak: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    {{-- Tombol cetak di luar kontainer cetak --}}
    <div class="no-print absolute bottom-4 right-4">
        <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Cetak Struk Antrean
        </button>
        <a href="{{ route('registrations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
            Kembali ke Daftar
        </a>
    </div>

    <script>
        // Otomatis memicu dialog cetak setelah halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
