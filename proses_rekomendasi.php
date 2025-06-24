<?php
<<<<<<< HEAD
session_start();
include 'connection.php'; // koneksi ke database MySQL

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit('Akses ditolak.');
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Permintaan tidak valid (token CSRF salah).');
}

if (!isset($_POST['bobot']) || !is_array($_POST['bobot'])) {
    die("Bobot kriteria tidak ditemukan.");
}

$bobot_input = array_map(function($v) {
    return floatval(trim($v));
}, $_POST['bobot']);

foreach ($bobot_input as $k => $v) {
    if (!is_numeric($v) || $v < 0) {
        exit("Semua nilai bobot harus berupa angka positif.");
    }
}

$total_bobot = array_sum($bobot_input);
if ($total_bobot == 0) {
    die("Total bobot tidak boleh nol.");
}

=======
include 'connection.php'; // koneksi ke database MySQL

if (!isset($_POST['bobot']) || !is_array($_POST['bobot'])) {
    die("Bobot kriteria tidak ditemukan.");
}
$bobot_input = $_POST['bobot'];

$total_bobot = array_sum($bobot_input);

if ($total_bobot == 0) {
    die("Total bobot tidak boleh nol.");
}
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
$bobot = [];
foreach ($bobot_input as $k => $v) {
    $bobot[$k] = floatval($v) / $total_bobot;
}

<<<<<<< HEAD
=======
$bobot_input = $_POST['bobot'];

>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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

<<<<<<< HEAD
=======

>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
$sql = "
SELECT 
    a.id_alternatif,
    a.nama_makanan,
<<<<<<< HEAD
    a.nama_warung,
    a.lokasi_warung,
    1 + 4 * ((SELECT MAX(harga) FROM view_nilai_pivot) - harga) / NULLIF((SELECT MAX(harga) FROM view_nilai_pivot) - (SELECT MIN(harga) FROM view_nilai_pivot),0) AS norm_harga,
    1 + 4 * ((SELECT MAX(jarak) FROM view_nilai_pivot) - jarak) / NULLIF((SELECT MAX(jarak) FROM view_nilai_pivot) - (SELECT MIN(jarak) FROM view_nilai_pivot),0) AS norm_jarak,
    1 + 4 * ((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - waktu_tunggu) / NULLIF((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - (SELECT MIN(waktu_tunggu) FROM view_nilai_pivot),0) AS norm_waktu_tunggu,
=======
    -- Normalisasi cost: 1 + 4 * (max - nilai) / (max - min)
    1 + 4 * ((SELECT MAX(harga) FROM view_nilai_pivot) - harga) / NULLIF((SELECT MAX(harga) FROM view_nilai_pivot) - (SELECT MIN(harga) FROM view_nilai_pivot),0) AS norm_harga,
    1 + 4 * ((SELECT MAX(jarak) FROM view_nilai_pivot) - jarak) / NULLIF((SELECT MAX(jarak) FROM view_nilai_pivot) - (SELECT MIN(jarak) FROM view_nilai_pivot),0) AS norm_jarak,
    1 + 4 * ((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - waktu_tunggu) / NULLIF((SELECT MAX(waktu_tunggu) FROM view_nilai_pivot) - (SELECT MIN(waktu_tunggu) FROM view_nilai_pivot),0) AS norm_waktu_tunggu,
    -- Normalisasi benefit: 1 + 4 * (nilai - min) / (max - min)
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD
        'nama_warung' => $row['nama_warung'],
        'lokasi_warung' => $row['lokasi_warung'],
=======
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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

<<<<<<< HEAD
$data_skor = [];
foreach ($data_normalisasi as $alt) {
    $score = 0;
    foreach ($bobot as $k => $b) {
        $score += $alt[$k] * $b;
    }
    $alt['score'] = $score;
    $data_skor[] = $alt;
}

usort($data_skor, function($a, $b) {
    return $b['score'] <=> $a['score'];
});

foreach ($data_normalisasi as &$alt) {
    $total = 0;
    foreach ($bobot as $k => $b) {
        $total += $alt[$k] * $b;
    }
    $alt['total_skor'] = $total;
}
unset($alt);

usort($data_normalisasi, function($a, $b) {
    return $b['total_skor'] <=> $a['total_skor'];
});
?>

=======
// Hitung skor untuk setiap alternatif dan simpan dalam array baru
$data_skor = [];
foreach ($data_normalisasi as $alt) {
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
    $alt['score'] = $score;
    $data_skor[] = $alt;
}
// Urutkan berdasarkan score tertinggi
usort($data_skor, function($a, $b) {
    return $b['score'] <=> $a['score'];
});
?>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minta Rekomendasi - DSS MAUT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
=======
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a class="nav-link" href="perhitungan.php"><i class="bi bi-journal-text me-2"></i>Proses perhitungan</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
                <li class="nav-item"><a class="nav-link active" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
                <li class="nav-item"><a class="nav-link" href="rekomendasi-orang-lain.php"><i class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
                <li class="nav-item"><a class="nav-link" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data Alternatif</a></li>
            </ul>
=======
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
        <li class="nav-item"><a class="nav-link active" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
        <li class="nav-item"><a class="nav-link" href="rekomendasi-orang-lain.php"><i class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
        <li class="nav-item"><a class="nav-link" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data Alternatif</a></li>
      </ul>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD
    <h2 class="mb-3">Hasil Perhitungan DSS MAUT</h2>

    <div class="accordion" id="accordionHasilMAUT">

        <!-- SECTION 1 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Perhitungan Score Akhir (MAUT)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionHasilMAUT">
            <div class="accordion-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID Alternatif</th>
                                <th>Nama Makanan</th>
                                <th>nama warung</th>
                                <th>lokasi warung</th>
                                <th>Score Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_skor as $alt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($alt['id']) ?></td>
                                    <td><?= htmlspecialchars($alt['nama']) ?></td>
                                    <td><?= htmlspecialchars($alt['nama_warung']) ?></td>
                                    <td><?= htmlspecialchars($alt['lokasi_warung']) ?></td>
                                    <td><?= number_format($alt['score'], 4) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECTION 2 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    Hasil Perkalian Bobot x Utility (MAUT)
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionHasilMAUT">
            <div class="accordion-body">
                    <table class="table table-striped table-bordered">
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
                                $total = 0; ?>
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
                </div>
            </div>
        </div>

        <!-- SECTION 3 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    Tabel Normalisasi Alternatif
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionHasilMAUT">
                <div class="accordion-body">
                    <table class="table table-bordered table-bordered">
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
                </div>
            </div>
        </div>

        <!-- SECTION 4 -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                    Bobot Kriteria (Awal dan Ternormalisasi)
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionHasilMAUT">
                <div class="accordion-body">
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
        </div>

    </div>
</div>

=======
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
                foreach ($data_skor as $alt):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($alt['id']) ?></td>
                        <td><?= htmlspecialchars($alt['nama']) ?></td>
                        <td><?= number_format($alt['score'], 4) ?></td>
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
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
  <script src="main.js"></script>
</body>
</html>
