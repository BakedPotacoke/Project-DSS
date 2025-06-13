<?php
include 'koneksi.php'; // koneksi ke database

// Ambil bobot dari URL (GET)
$bobot_input = [];
foreach ($_GET as $key => $value) {
    if (strpos($key, 'bobot_') === 0) {
        $kriteria = substr($key, 6); // hapus 'bobot_'
        $bobot_input[$kriteria] = floatval($value);
    }
}

if (empty($bobot_input)) {
    die("Bobot kriteria tidak ditemukan.");
}

// Hitung bobot ternormalisasi
$total_bobot = array_sum($bobot_input);
$bobot = [];
foreach ($bobot_input as $k => $v) {
    $bobot[$k] = $total_bobot > 0 ? $v / $total_bobot : 0;
}

// Mapping input ke kolom tabel (view_nilai_pivot)
$kriteria_mapping = [
    'harga_makanan' => 'harga',
    'jarak' => 'jarak',
    'waktu_tunggu' => 'waktu_tunggu',
    'popularitas' => 'popularitas',
    'kebersihan_makanan' => 'kebersihan',
    'variasi_makanan' => 'variasi',
    'kemudahan_pembayaran' => 'pembayaran',
    'pelengkap_makanan' => 'pelengkap',
    'kelengkapan_alat_makan' => 'kelengkapan'
];

// Daftar tipe kriteria
$kriteria_tipe = [
    'harga_makanan' => 'cost',
    'jarak' => 'cost',
    'waktu_tunggu' => 'cost',
    'popularitas' => 'benefit',
    'kebersihan_makanan' => 'benefit',
    'variasi_makanan' => 'benefit',
    'kemudahan_pembayaran' => 'benefit',
    'pelengkap_makanan' => 'benefit',
    'kelengkapan_alat_makan' => 'benefit'
];

// Query normalisasi
$sql = "
SELECT 
    a.id_alternatif,
    a.nama_makanan,
    1 + 4 * ((SELECT MAX(harga) FROM view_nilai_pivot) - harga) / NULLIF((SELECT MAX(harga) FROM view_nilai_pivot) - (SELECT MIN(harga) FROM view_nilai_pivot), 0) AS harga,
    1 + 4 * ((SELECT MAX(jarak) FROM view_nilai_pivot) - jarak) / NULLIF((SELECT MAX(jarak) FROM view_nilai_pivot) - (SELECT MIN(jarak) FROM view_nilai_pivot), 0) AS jarak,
    1 + 4 * ((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - waktu_tunggu) / NULLIF((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - (SELECT MIN(waktu_tunggu) FROM view_nilai_pivot), 0) AS waktu_tunggu,
    1 + 4 * (popularitas - (SELECT MIN(popularitas) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(popularitas) FROM view_nilai_pivot) - (SELECT MIN(popularitas) FROM view_nilai_pivot), 0) AS popularitas,
    1 + 4 * (kebersihan - (SELECT MIN(kebersihan) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(kebersihan) FROM view_nilai_pivot) - (SELECT MIN(kebersihan) FROM view_nilai_pivot), 0) AS kebersihan,
    1 + 4 * (variasi - (SELECT MIN(variasi) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(variasi) FROM view_nilai_pivot) - (SELECT MIN(variasi) FROM view_nilai_pivot), 0) AS variasi,
    1 + 4 * (pembayaran - (SELECT MIN(pembayaran) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(pembayaran) FROM view_nilai_pivot) - (SELECT MIN(pembayaran) FROM view_nilai_pivot), 0) AS pembayaran,
    1 + 4 * (pelengkap - (SELECT MIN(pelengkap) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(pelengkap) FROM view_nilai_pivot) - (SELECT MIN(pelengkap) FROM view_nilai_pivot), 0) AS pelengkap,
    1 + 4 * (kelengkapan - (SELECT MIN(kelengkapan) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(kelengkapan) FROM view_nilai_pivot) - (SELECT MIN(kelengkapan) FROM view_nilai_pivot), 0) AS kelengkapan
FROM view_nilai_pivot v
JOIN alternatif a ON v.id_alternatif = a.id_alternatif
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data_normalisasi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_normalisasi[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi - DSS MAUT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div id="sidebar-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="index.php" class="text-white" style="text-decoration:none;"><i
                        class="bi bi-house-door-fill"></i> Home</a>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a class="nav-link" href="index.php"><i
                            class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
                <li class="nav-item"><a class="nav-link active" href="rekomendasi.php"><i
                            class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
                <li class="nav-item"><a class="nav-link" href="rekomendasi-orang-lain.php"><i
                            class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
                <li class="nav-item"><a class="nav-link" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data
                        Alternatif</a></li>
            </ul>
        </div>
    </div>
    
    <div class="main-content">
        <div class="container mt-4">
        <h2 class="mb-3">Tabel Normalisasi Alternatif</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <?php foreach ($bobot_input as $key => $_): ?>
                        <th><?= ucfirst(str_replace("_", " ", $key)) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_normalisasi as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_alternatif']) ?></td>
                        <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
                        <?php foreach ($bobot_input as $k => $_):
                            $kolom = $kriteria_mapping[$k];
                            ?>
                            <td><?= number_format($row[$kolom], 4) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="container mt-4">
            <h2 class="mt-5 mb-3">Perhitungan Skor Akhir (MAUT)</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_normalisasi as $row):
                        $score = 0;
                        foreach ($bobot_input as $k => $b):
                            $kolom = $kriteria_mapping[$k];
                            $score += $row[$kolom] * $bobot[$k];
                        endforeach;
                        ?>
                        <tr>
                            <td><?= $row['id_alternatif'] ?></td>
                            <td><?= $row['nama_makanan'] ?></td>
                            <td><strong><?= number_format($score, 4) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="container mt-4">
            <h2 class="mt-5 mb-3">Bobot Kriteria</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot Awal</th>
                        <th>Bobot Ternormalisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bobot_input as $k => $v): ?>
                        <tr>
                            <td><?= ucfirst(str_replace("_", " ", $k)) ?></td>
                            <td><?= $kriteria_tipe[$k] == 'cost' ? 'Cost' : 'Benefit' ?></td>
                            <td><?= $v ?></td>
                            <td><?= number_format($bobot[$k], 4) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>