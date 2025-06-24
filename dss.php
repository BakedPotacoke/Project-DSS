<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Normalisasi dan Perhitungan Akhir</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Tabel Normalisasi Alternatif</h2>
    <table>
        <thead>
            <tr>
                <th>ID Alternatif</th>
                <th>Nama Makanan</th>
                <th>Harga (Cost)</th>
                <th>Jarak (Cost)</th>
                <th>Waktu Tunggu (Cost)</th>
                <th>Popularitas (Benefit)</th>
                <th>Kebersihan (Benefit)</th>
                <th>Variasi (Benefit)</th>
                <th>Pembayaran (Benefit)</th>
                <th>Pelengkap (Benefit)</th>
                <th>Kelengkapan Alat (Benefit)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Bobot kriteria sesuai input user
        $bobot = [
            'harga' => 0.1785714286,
            'jarak' => 0.07142857143,
            'waktu' => 0.1071428571,
            'popularitas' => 0.1428571429,
            'kebersihan' => 0.1785714286,
            'variasi' => 0.1785714286,
            'pembayaran' => 0.07142857143,
            'pelengkap' => 0.03571428571,
            'kelengkapan' => 0.03571428571
        ];

        $sql = "
        SELECT 
            a.id_alternatif,
            a.nama_makanan,

            1 + 4 * (
                (SELECT MAX(harga) FROM view_nilai_pivot) - harga
            ) / NULLIF(
                (SELECT MAX(harga) - MIN(harga) FROM view_nilai_pivot), 0
            ) AS norm_harga,

            1 + 4 * (
                (SELECT MAX(jarak) FROM view_nilai_pivot) - jarak
            ) / NULLIF(
                (SELECT MAX(jarak) - MIN(jarak) FROM view_nilai_pivot), 0
            ) AS norm_jarak,

            1 + 4 * (
                (SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - waktu_tunggu
            ) / NULLIF(
                (SELECT MAX(waktu_tunggu) - MIN(waktu_tunggu) FROM view_nilai_pivot), 0
            ) AS norm_waktu,

            1 + 4 * (
                popularitas - (SELECT MIN(popularitas) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(popularitas) - MIN(popularitas) FROM view_nilai_pivot), 0
            ) AS norm_popularitas,

            1 + 4 * (
                kebersihan - (SELECT MIN(kebersihan) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(kebersihan) - MIN(kebersihan) FROM view_nilai_pivot), 0
            ) AS norm_kebersihan,

            1 + 4 * (
                variasi - (SELECT MIN(variasi) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(variasi) - MIN(variasi) FROM view_nilai_pivot), 0
            ) AS norm_variasi,

            1 + 4 * (
                pembayaran - (SELECT MIN(pembayaran) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(pembayaran) - MIN(pembayaran) FROM view_nilai_pivot), 0
            ) AS norm_pembayaran,

            1 + 4 * (
                pelengkap - (SELECT MIN(pelengkap) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(pelengkap) - MIN(pelengkap) FROM view_nilai_pivot), 0
            ) AS norm_pelengkap,

            1 + 4 * (
                kelengkapan - (SELECT MIN(kelengkapan) FROM view_nilai_pivot)
            ) / NULLIF(
                (SELECT MAX(kelengkapan) - MIN(kelengkapan) FROM view_nilai_pivot), 0
            ) AS norm_kelengkapan

        FROM view_nilai_pivot v
        JOIN food_dss.alternatif a ON v.id_alternatif = a.id_alternatif
        ";

        $result = mysqli_query($conn, $sql);

        $data_normalisasi = [];

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id_alternatif']}</td>
                <td>{$row['nama_makanan']}</td>
                <td>" . number_format($row['norm_harga'], 4) . "</td>
                <td>" . number_format($row['norm_jarak'], 4) . "</td>
                <td>" . number_format($row['norm_waktu'], 4) . "</td>
                <td>" . number_format($row['norm_popularitas'], 4) . "</td>
                <td>" . number_format($row['norm_kebersihan'], 4) . "</td>
                <td>" . number_format($row['norm_variasi'], 4) . "</td>
                <td>" . number_format($row['norm_pembayaran'], 4) . "</td>
                <td>" . number_format($row['norm_pelengkap'], 4) . "</td>
                <td>" . number_format($row['norm_kelengkapan'], 4) . "</td>
            </tr>";

            $data_normalisasi[] = [
                'id' => $row['id_alternatif'],
                'nama' => $row['nama_makanan'],
                'harga' => $row['norm_harga'],
                'jarak' => $row['norm_jarak'],
                'waktu' => $row['norm_waktu'],
                'popularitas' => $row['norm_popularitas'],
                'kebersihan' => $row['norm_kebersihan'],
                'variasi' => $row['norm_variasi'],
                'pembayaran' => $row['norm_pembayaran'],
                'pelengkap' => $row['norm_pelengkap'],
                'kelengkapan' => $row['norm_kelengkapan']
            ];
        }
        ?>
        </tbody>
    </table>

        <h2>Tabel Hasil Bobot x Nilai Normalisasi (Utilitas)</h2>
    <table>
        <thead>
            <tr>
                <th>ID Alternatif</th>
                <th>Nama Makanan</th>
                <th>Harga</th>
                <th>Jarak</th>
                <th>Waktu Tunggu</th>
                <th>Popularitas</th>
                <th>Kebersihan</th>
                <th>Variasi</th>
                <th>Pembayaran</th>
                <th>Pelengkap</th>
                <th>Kelengkapan Alat</th>
                <th>Total Skor</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data_normalisasi as $alt) {
            // Hitung bobot * util per kriteria
            $harga = $alt['harga'] * $bobot['harga'];
            $jarak = $alt['jarak'] * $bobot['jarak'];
            $waktu = $alt['waktu'] * $bobot['waktu'];
            $popularitas = $alt['popularitas'] * $bobot['popularitas'];
            $kebersihan = $alt['kebersihan'] * $bobot['kebersihan'];
            $variasi = $alt['variasi'] * $bobot['variasi'];
            $pembayaran = $alt['pembayaran'] * $bobot['pembayaran'];
            $pelengkap = $alt['pelengkap'] * $bobot['pelengkap'];
            $kelengkapan = $alt['kelengkapan'] * $bobot['kelengkapan'];

            $total_skor = $harga + $jarak + $waktu + $popularitas + $kebersihan + $variasi + $pembayaran + $pelengkap + $kelengkapan;

            echo "<tr>
                <td>{$alt['id']}</td>
                <td>{$alt['nama']}</td>
                <td>" . number_format($harga, 4) . "</td>
                <td>" . number_format($jarak, 4) . "</td>
                <td>" . number_format($waktu, 4) . "</td>
                <td>" . number_format($popularitas, 4) . "</td>
                <td>" . number_format($kebersihan, 4) . "</td>
                <td>" . number_format($variasi, 4) . "</td>
                <td>" . number_format($pembayaran, 4) . "</td>
                <td>" . number_format($pelengkap, 4) . "</td>
                <td>" . number_format($kelengkapan, 4) . "</td>
                <td><strong>" . number_format($total_skor, 4) . "</strong></td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>
