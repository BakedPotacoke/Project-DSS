<?php
include 'koneksi.php'; // koneksi ke database MySQL

if (!isset($_POST['bobot']) || !is_array($_POST['bobot'])) {
    die("Bobot kriteria tidak ditemukan.");
}
$bobot_input = $_POST['bobot'];

$total_bobot = array_sum($bobot_input);

if ($total_bobot == 0) {
    die("Total bobot tidak boleh nol.");
}
$bobot = [];
foreach ($bobot_input as $k => $v) {
    $bobot[$k] = floatval($v) / $total_bobot;
}

$bobot_input = $_POST['bobot'];

$kriteria = [
    'harga' => 'cost',
    'jarak' => 'cost',
    'waktu_tunggu' => 'cost',
    'popularitas' => 'benefit',
    'kebersihan' => 'benefit',
    'variasi' => 'benefit',
    'pembayaran' => 'benefit',
    'pelengkap' => 'benefit',
    'kelengkapan' => 'benefit'
];


$sql = "
SELECT 
    a.id_alternatif,
    a.nama_makanan,
    -- Normalisasi cost: 1 + 4 * (max - nilai) / (max - min)
    1 + 4 * ((SELECT MAX(harga) FROM view_nilai_pivot) - harga) / NULLIF((SELECT MAX(harga) FROM view_nilai_pivot) - (SELECT MIN(harga) FROM view_nilai_pivot),0) AS norm_harga,
    1 + 4 * ((SELECT MAX(jarak) FROM view_nilai_pivot) - jarak) / NULLIF((SELECT MAX(jarak) FROM view_nilai_pivot) - (SELECT MIN(jarak) FROM view_nilai_pivot),0) AS norm_jarak,
    1 + 4 * ((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - waktu_tunggu) / NULLIF((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - (SELECT MIN(waktu_tunggu) FROM view_nilai_pivot),0) AS norm_waktu_tunggu,
    -- Normalisasi benefit: 1 + 4 * (nilai - min) / (max - min)
    1 + 4 * (popularitas - (SELECT MIN(popularitas) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(popularitas) FROM view_nilai_pivot) - (SELECT MIN(popularitas) FROM view_nilai_pivot),0) AS norm_popularitas,
    1 + 4 * (kebersihan - (SELECT MIN(kebersihan) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(kebersihan) FROM view_nilai_pivot) - (SELECT MIN(kebersihan) FROM view_nilai_pivot),0) AS norm_kebersihan,
    1 + 4 * (variasi - (SELECT MIN(variasi) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(variasi) FROM view_nilai_pivot) - (SELECT MIN(variasi) FROM view_nilai_pivot),0) AS norm_variasi,
    1 + 4 * (pembayaran - (SELECT MIN(pembayaran) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(pembayaran) FROM view_nilai_pivot) - (SELECT MIN(pembayaran) FROM view_nilai_pivot),0) AS norm_pembayaran,
    1 + 4 * (pelengkap - (SELECT MIN(pelengkap) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(pelengkap) FROM view_nilai_pivot) - (SELECT MIN(pelengkap) FROM view_nilai_pivot),0) AS norm_pelengkap,
    1 + 4 * (kelengkapan - (SELECT MIN(kelengkapan) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(kelengkapan) FROM view_nilai_pivot) - (SELECT MIN(kelengkapan) FROM view_nilai_pivot),0) AS norm_kelengkapan
FROM view_nilai_pivot v
JOIN food_dss.alternatif a ON v.id_alternatif = a.id_alternatif
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data_normalisasi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_normalisasi[] = [
        'id' => $row['id_alternatif'],
        'nama' => $row['nama_makanan'],
        'harga' => $row['norm_harga'],
        'jarak' => $row['norm_jarak'],
        'waktu_tunggu' => $row['norm_waktu_tunggu'],
        'popularitas' => $row['norm_popularitas'],
        'kebersihan' => $row['norm_kebersihan'],
        'variasi' => $row['norm_variasi'],
        'pembayaran' => $row['norm_pembayaran'],
        'pelengkap' => $row['norm_pelengkap'],
        'kelengkapan' => $row['norm_kelengkapan'],
    ];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minta Rekomendasi - DSS MAUT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="style.css" rel="stylesheet">
  <style>
    .form-range-custom {
      max-width: 300px;
    }
  </style>
</head>
<body>
  <div id="sidebar-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <a href="index.php" class="text-white" style="text-decoration:none;"><i class="bi bi-house-door-fill"></i> Home</a>
      </div>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
        <li class="nav-item"><a class="nav-link active" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
        <li class="nav-item"><a class="nav-link" href="rekomendasi-orang-lain.php"><i class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
        <li class="nav-item"><a class="nav-link" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data Alternatif</a></li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <div id="header-container">
      <div class="topbar">
        <div class="d-flex align-items-center">
          <i class="bi bi-list hamburger-menu" id="hamburgerToggle"></i>
          <h5 class="mb-0">Minta Rekomendasi</h5>
        </div>
      </div>
    </div>
    <div class="container mt-4">
                <h2>Tabel Normalisasi Alternatif</h2>
        <table class="table table-striped table-bordered">
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
                <?php foreach ($data_normalisasi as $alt): ?>
                    <tr>
                        <td><?= htmlspecialchars($alt['id']) ?></td>
                        <td><?= htmlspecialchars($alt['nama']) ?></td>
                        <td><?= number_format($alt['harga'], 4) ?></td>
                        <td><?= number_format($alt['jarak'], 4) ?></td>
                        <td><?= number_format($alt['waktu_tunggu'], 4) ?></td>
                        <td><?= number_format($alt['popularitas'], 4) ?></td>
                        <td><?= number_format($alt['kebersihan'], 4) ?></td>
                        <td><?= number_format($alt['variasi'], 4) ?></td>
                        <td><?= number_format($alt['pembayaran'], 4) ?></td>
                        <td><?= number_format($alt['pelengkap'], 4) ?></td>
                        <td><?= number_format($alt['kelengkapan'], 4) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Perhitungan Score Akhir (MAUT)</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID Alternatif</th>
                    <th>Nama Makanan</th>
                    <th>Score Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data_normalisasi as $alt):
                    $score = 0;
                    $score += $alt['harga'] * $bobot['harga'];
                    $score += $alt['jarak'] * $bobot['jarak'];
                    $score += $alt['waktu_tunggu'] * $bobot['waktu_tunggu'];
                    $score += $alt['popularitas'] * $bobot['popularitas'];
                    $score += $alt['kebersihan'] * $bobot['kebersihan'];
                    $score += $alt['variasi'] * $bobot['variasi'];
                    $score += $alt['pembayaran'] * $bobot['pembayaran'];
                    $score += $alt['pelengkap'] * $bobot['pelengkap'];
                    $score += $alt['kelengkapan'] * $bobot['kelengkapan'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($alt['id']) ?></td>
                        <td><?= htmlspecialchars($alt['nama']) ?></td>
                        <td><?= number_format($score, 4) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Hasil Perkalian Bobot × Utility (MAUT)</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Makanan</th>
                    <?php foreach ($bobot as $key => $b): ?>
                        <th><?= ucfirst(str_replace("_", " ", $key)) ?> × Bobot</th>
                    <?php endforeach; ?>
                    <th><strong>Total Skor</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_normalisasi as $alt):
                    $total = 0;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($alt['id']) ?></td>
                        <td><?= htmlspecialchars($alt['nama']) ?></td>
                        <?php foreach ($bobot as $k => $b):
                            $perkalian = $alt[$k] * $b;
                            $total += $perkalian;
                            ?>
                            <td><?= number_format($perkalian, 4) ?></td>
                        <?php endforeach; ?>
                        <td><strong><?= number_format($total, 4) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Bobot Kriteria (Awal dan Ternormalisasi)</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>Tipe</th>
                    <th>Bobot Awal</th>
                    <th>Bobot Normalisasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($bobot_input as $k => $v): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= ucfirst(str_replace("_", " ", $k)) ?></td>
                        <td><?= $kriteria[$k] == 'cost' ? 'Cost' : 'Benefit' ?></td>
                        <td><?= $v ?></td>
                        <td><?= number_format($bobot[$k], 4) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>
