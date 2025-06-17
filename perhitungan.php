<?php
session_start();
include 'connection.php';

// Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bobot'])) {

    // Validasi token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit('Token CSRF tidak valid.');
    }

    $bobot = $_POST['bobot'];

    $sql = "INSERT INTO history_bobot (
      bobot_harga_makanan,
      bobot_jarak,
      bobot_waktu_tunggu,
      bobot_popularitas,
      bobot_kebersihan_makanan,
      bobot_variasi_makanan,
      bobot_kemudahan_pembayaran,
      bobot_pelengkap_makanan,
      bobot_kelengkapan_alat_makan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ddddddddd",
        $bobot['harga'],
        $bobot['jarak'],
        $bobot['waktu_tunggu'],
        $bobot['popularitas'],
        $bobot['kebersihan'],
        $bobot['variasi'],
        $bobot['pembayaran'],
        $bobot['pelengkap'],
        $bobot['kelengkapan']
    );

    if ($stmt->execute()) {
        echo "<form id='redirectForm' action='proses_rekomendasi.php' method='POST'>";
        echo "<input type='hidden' name='csrf_token' value='" . htmlspecialchars($_SESSION['csrf_token']) . "'>";
        foreach ($bobot as $key => $val) {
            echo "<input type='hidden' name='bobot[$key]' value='" . htmlspecialchars($val, ENT_QUOTES) . "'>";
        }
        echo "</form>";
        echo "<script>document.getElementById('redirectForm').submit();</script>";
        exit;
    }
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

        .penjelasan {
            font-size: 0.9rem;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>

<body>
<?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div id="sidebar-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="index.php" class="text-white" style="text-decoration:none;"><i
                        class="bi bi-house-door-fill"></i> Home</a>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a class="nav-link <?= $current == 'index.php' ? 'active' : '' ?>" href="index.php"><i class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
                <li class="nav-item"><a class="nav-link <?= $current == 'perhitungan.php' ? 'active' : '' ?>" href="perhitungan.php"><i class="bi bi-journal-text me-2"></i>Proses perhitungan</a></li>
                <li class="nav-item"><a class="nav-link <?= $current == 'rekomendasi.php' ? 'active' : '' ?>" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
                <li class="nav-item"><a class="nav-link <?= $current == 'rekomendasi-orang-lain.php' ? 'active' : '' ?>" href="rekomendasi-orang-lain.php"><i class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
                <li class="nav-item"><a class="nav-link <?= $current == 'alternatif.php' ? 'active' : '' ?>" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data Alternatif</a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <div id="header-container">
            <div class="topbar">
                <div class="d-flex align-items-center">
                    <i class="bi bi-list hamburger-menu" id="hamburgerToggle"></i>
                    <h5 class="mb-0">Proses Perhitungan</h5>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <h3>Penjelasan Metode MAUT dan Proses Perhitungan</h3>
            <p><strong>Multi Attribute Utility Theory (MAUT)</strong> adalah salah satu metode Sistem Pendukung
                Keputusan (DSS) yang digunakan untuk mengevaluasi dan mengambil keputusan berdasarkan banyak kriteria.
            </p>

            <h5>1. Normalisasi Nilai</h5>
            <p>Untuk menyamakan skala antar kriteria, dilakukan normalisasi dengan rumus:</p>
            <p><strong>Benefit Criteria:</strong></p>
            <p>\[ R_{ij} = 1 + 4 \times \frac{X_{ij} - X_{j}^{min}}{X_{j}^{max} - X_{j}^{min}} \]</p>
            <p><strong>Cost Criteria:</strong></p>
            <p>\[ R_{ij} = 1 + 4 \times \frac{X_{j}^{max} - X_{ij}}{X_{j}^{max} - X_{j}^{min}} \]</p>

            <p><strong>Contoh:</strong> Jika harga adalah kriteria cost:</p>
            <p>\[ R_{harga} = 1 + 4 \times \frac{X_{harga}^{max} - X_{harga}}{X_{harga}^{max} - X_{harga}^{min}} \]</p>

            <p>Berikut adalah contoh hasil normalisasi SQL:</p>
            <pre>
SELECT 
  a.nama_makanan,
  1 + 4 * ((SELECT MAX(harga) FROM view_nilai_pivot) - harga) / NULLIF((SELECT MAX(harga) FROM view_nilai_pivot) - (SELECT MIN(harga) FROM view_nilai_pivot), 0) AS harga,
  1 + 4 * (popularitas - (SELECT MIN(popularitas) FROM view_nilai_pivot)) / NULLIF((SELECT MAX(popularitas) FROM view_nilai_pivot) - (SELECT MIN(popularitas) FROM view_nilai_pivot), 0) AS popularitas,
  ...
FROM view_nilai_pivot v
JOIN alternatif a ON v.id_alternatif = a.id_alternatif
  </pre>

            <h5>2. Pembobotan Kriteria</h5>
            <p>Bobot dari user dinormalisasi agar total = 1:</p>
            <pre>
$total_bobot = array_sum($bobot_input);
foreach ($bobot_input as $k => $v) {
  $bobot[$k] = $v / $total_bobot;
}
  </pre>

            <h5>3. Perhitungan Utility Akhir</h5>
            <p>Setelah normalisasi dan pembobotan, dilakukan perhitungan skor akhir:</p>
            <p>\[ U_i = \sum_{j=1}^{n} R_{ij} \cdot W_j \]</p>
            <p>Dengan:</p>
            <ul>
                <li>\( R_{ij} \): nilai normalisasi alternatif ke-i pada kriteria ke-j</li>
                <li>\( W_j \): bobot kriteria ke-j</li>
            </ul>

            <h5>4. Contoh Alternatif Dummy</h5>
            <p>Alternatif Dummy:</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        <th>Harga</th>
                        <th>Jarak</th>
                        <th>Popularitas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nasi Goreng</td>
                        <td>12000</td>
                        <td>150</td>
                        <td>90</td>
                    </tr>
                    <tr>
                        <td>Ayam Geprek</td>
                        <td>10000</td>
                        <td>80</td>
                        <td>80</td>
                    </tr>
                </tbody>
            </table>

            <p>Bobot Dummy:</p>
            <ul>
                <li>Harga: 0.4 (cost)</li>
                <li>Jarak: 0.3 (cost)</li>
                <li>Popularitas: 0.3 (benefit)</li>
            </ul>

            <h5>5. Hasil Normalisasi (Contoh)</h5>
            <pre>
Nasi Goreng:
Harga = 1 + 4 * (12000 - 10000)/(12000 - 10000) = 1
Jarak = 1 + 4 * (150 - 80)/(150 - 80) = 1
Popularitas = 1 + 4 * (90 - 80)/(90 - 80) = 5

Ayam Geprek:
Harga = 1 + 4 * (12000 - 10000)/(12000 - 10000) = 5
Jarak = 1 + 4 * (150 - 80)/(150 - 80) = 5
Popularitas = 1 + 4 * (80 - 80)/(90 - 80) = 1
  </pre>

            <h5>6. Hasil Akhir Skor</h5>
            <pre>
Nasi Goreng:
= (1 * 0.4) + (1 * 0.3) + (5 * 0.3) = 0.4 + 0.3 + 1.5 = 2.2

Ayam Geprek:
= (5 * 0.4) + (5 * 0.3) + (1 * 0.3) = 2.0 + 1.5 + 0.3 = 3.8
  </pre>
            <p><strong>Kesimpulan:</strong> Ayam Geprek lebih direkomendasikan dengan skor 3.8 dibandingkan Nasi Goreng
                yang hanya 2.2.</p>
        </div>

        <!-- Tambahkan MathJax untuk menampilkan rumus ilmiah -->
        <script>
            window.MathJax = {
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']]
                },
                svg: {
                    fontCache: 'global'
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    </div>
    <script src="main.js"></script>
</body>

</html>