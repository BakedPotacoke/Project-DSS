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
        <a href="index.php" class="text-white" style="text-decoration:none;"><i class="bi bi-house-door-fill"></i> Home</a>
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
          <h5 class="mb-0">Minta Rekomendasi</h5>
        </div>
      </div>
    </div>
    <div class="container mt-4">
      <div class="card">
        <div class="card-body">
          <h3>Input Kriteria Rekomendasi</h3>
          <form action="" method="POST">
            <!-- Tambahkan CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <?php
            $kriteria = [
              'harga' => [
                'nama' => 'Harga Makanan',
                'jenis' => 'cost',
                'pertanyaan' => 'Seberapa penting harga makanan bagi Anda saat memilih makanan di kantin kampus?',
                'penjelasan' => 'Apakah kamu sering memilih menu karena harganya terjangkau, agar bisa hemat? Jika ya, maka bobot harga harus tinggi.'
              ],
              'jarak' => [
                'nama' => 'Jarak',
                'jenis' => 'cost',
                'pertanyaan' => 'Seberapa penting jarak warung dari gedung GSG?',
                'penjelasan' => 'Kalau kamu malas jalan jauh dan lebih sering makan di warung dekat-dekat, maka kamu menganggap jarak penting.'
              ],
              'waktu_tunggu' => [
                'nama' => 'Waktu Tunggu',
                'jenis' => 'cost',
                'pertanyaan' => 'Seberapa penting waktu tunggu saat menunggu pesanan makanan bagi Anda?',
                'penjelasan' => 'Kalau kamu tidak suka menunggu lama, maka bobot waktu tunggu akan tinggi.'
              ],
              'popularitas' => [
                'nama' => 'Popularitas',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting popularitas warung bagi Anda dalam memilih tempat makan?',
                'penjelasan' => 'Jika kamu percaya tempat yang ramai pasti enak, maka popularitas penting buat kamu.'
              ],
              'kebersihan' => [
                'nama' => 'Kebersihan Makanan',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting kebersihan makanan dan penyajiannya bagi Anda?',
                'penjelasan' => 'Kalau kamu sangat memperhatikan kebersihan, maka bobotnya tinggi.'
              ],
              'variasi' => [
                'nama' => 'Variasi Makanan',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting banyaknya variasi makanan?',
                'penjelasan' => 'Kalau kamu suka banyak pilihan menu, maka bobotnya tinggi.'
              ],
              'pembayaran' => [
                'nama' => 'Kemudahan Pembayaran',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting tersedianya banyak opsi pembayaran?',
                'penjelasan' => 'Kalau kamu suka pakai QRIS/e-wallet, maka ini penting.'
              ],
              'pelengkap' => [
                'nama' => 'Pelengkap Makanan',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting adanya pelengkap seperti sambal, kerupuk?',
                'penjelasan' => 'Kalau kamu merasa pelengkap bikin makanan lebih enak, maka bobotnya tinggi.'
              ],
              'kelengkapan' => [
                'nama' => 'Kelengkapan Alat Makan',
                'jenis' => 'benefit',
                'pertanyaan' => 'Seberapa penting tersedianya alat makan yang lengkap?',
                'penjelasan' => 'Kalau kamu suka alat makan yang bersih dan lengkap, bobotnya tinggi.'
              ]
            ];

            foreach ($kriteria as $id => $info) :
            ?>
              <div class="mb-4">
                <label for="slider_<?php echo $id; ?>" class="form-label fw-bold">
                  <?php echo $info['nama']; ?> (<?php echo $info['jenis']; ?>)
                </label>
                <div class="mb-1 text-muted">
                  <em><?php echo $info['pertanyaan']; ?></em>
                </div>
                <div class="d-flex align-items-center">
                  <input type="range"
                         class="form-range form-range-custom me-3"
                         id="slider_<?php echo $id; ?>"
                         name="bobot[<?php echo $id; ?>]"
                         min="1" max="5" step="0.1" value="3"
                         oninput="document.getElementById('label_<?php echo $id; ?>').innerText = this.value">
                  <span>Bobot: <span id="label_<?php echo $id; ?>">3.0</span></span>
                </div>
                <div class="penjelasan">
                  <?php echo $info['penjelasan']; ?>
                </div>
              </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Proses Rekomendasi</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>
