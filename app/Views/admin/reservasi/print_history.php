<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Reservasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 15px;
            font-size: 10px;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 4px 6px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 9px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }

        @media print {
            body {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Riwayat Reservasi</h1>
        <p>Sistem Booking Lapangan Badminton</p>
        <p><strong><?= $periode ?></strong></p>
        <p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <?php if (empty($riwayat)): ?>
        <p>Tidak ada data riwayat reservasi untuk periode yang dipilih.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama User</th>
                    <th>Nama Lapangan</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Jam Mulai</th>
                    <th class="text-center">Jam Selesai</th>
                    <th class="text-right">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $grandTotal = 0;
                foreach ($riwayat as $r):
                    $grandTotal += $r['total_harga'];
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $r['nama_user'] ?></td>
                        <td><?= $r['nama_lapangan'] ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                        <td class="text-center"><?= substr($r['jam_mulai'], 0, 5) ?></td>
                        <td class="text-center"><?= substr($r['jam_selesai'], 0, 5) ?></td>
                        <td class="text-right">Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="6" class="text-center "><strong>Total Keseluruhan</strong></td>
                    <td class="text-right"><strong>Rp <?= number_format($grandTotal, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Jumlah Record: <?= count($riwayat) ?></p>
        </div>
    <?php endif; ?>

</body>

</html>