<?php
include 'connection.php'; // koneksi ke database

<<<<<<< HEAD
// Cegah XSS dan validasi input GET
foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Ambil dan validasi bobot dari URL (GET)
$bobot_input = [];
$valid_kriteria = [
    'harga_makanan', 'jarak', 'waktu_tunggu',
    'popularitas', 'kebersihan_makanan', 'variasi_makanan',
    'kemudahan_pembayaran', 'pelengkap_makanan', 'kelengkapan_alat_makan'
];

foreach ($_GET as $key => $value) {
    if (strpos($key, 'bobot_') === 0) {
        $kriteria = substr($key, 6); // hapus 'bobot_'

        if (!preg_match('/^[a-z_]+$/', $kriteria) || !in_array($kriteria, $valid_kriteria)) {
            die("Kriteria tidak valid.");
        }

        if (!is_numeric($value) || floatval($value) < 0) {
            die("Nilai bobot tidak valid.");
        }

=======
// Ambil bobot dari URL (GET)
$bobot_input = [];
foreach ($_GET as $key => $value) {
    if (strpos($key, 'bobot_') === 0) {
        $kriteria = substr($key, 6); // hapus 'bobot_'
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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

<<<<<<< HEAD
// Mapping input ke kolom tabel
=======
// Mapping input ke kolom tabel (view_nilai_pivot)
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD

// Hitung skor terlebih dahulu lalu simpan ke dalam array
foreach ($data_normalisasi as &$row) {
    $score = 0;
    foreach ($bobot_input as $k => $b) {
        $kolom = $kriteria_mapping[$k];
        $score += $row[$kolom] * $bobot[$k];
    }
    $row['score'] = $score; // Tambahkan skor ke array
}
unset($row); // best practice setelah by-reference foreach

// Urutkan berdasarkan skor tertinggi ke terendah
usort($data_normalisasi, function($a, $b) {
    return $b['score'] <=> $a['score'];
});
=======
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
?>

<!DOCTYPE html>
<html lang="id">
<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi - DSS MAUT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <style>
    .form-range-custom {
      max-width: 300px;
    }
  </style>
</head>
=======

<head>
    <meta charset="UTF-8">
    <title>Hasil Rekomendasi - DSS MAUT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
<body>
    <div id="sidebar-container">
        <div class="sidebar">
            <div class="sidebar-header">
<<<<<<< HEAD
                <a href="index.php" class="text-white" style="text-decoration:none;"><i class="bi bi-house-door-fill"></i> Home</a>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a class="nav-link" href="perhitungan.php"><i class="bi bi-journal-text me-2"></i>Proses perhitungan</a></li>
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
          <h5 class="mb-0">Proses Rekomendasi Orang Lain</h5>
        </div>
      </div>
    </div>
    <div class="container mt-4">
    <h2 class="mb-3">Hasil Perhitungan DSS MAUT DARI ORANG LAIN</h2>

    <div class="accordion" id="accordionHasilMAUT">

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Perhitungan Score Akhir (MAUT)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionHasilMAUT">
            <div class="accordion-body">
                    <table class="table table-bordered table-hover">
=======
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
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD
                            <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
=======
                            <td><?= $row['nama_makanan'] ?></td>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
                            <td><strong><?= number_format($score, 4) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<<<<<<< HEAD
    </div>
</div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    Tabel Normalisasi Alternatif
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionHasilMAUT">
            <div class="accordion-body">
                    <table class="table table-striped table-bordered">
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
    </div>
</div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                    Bobot Kriteria (Awal dan Ternormalisasi)
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionHasilMAUT">
                <div class="accordion-body">
                    <table class="table table-bordered">
=======

        <div class="container mt-4">
            <h2 class="mt-5 mb-3">Bobot Kriteria</h2>
            <table class="table table-bordered">
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
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
<<<<<<< HEAD
    <script src="main.js"></script>
</body>
</html>
=======

</body>

</html>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
