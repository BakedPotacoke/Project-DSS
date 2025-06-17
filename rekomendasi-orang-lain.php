<<<<<<< HEAD
<?php
include 'connection.php';

// Definisikan kriteria dan deskripsi
$kriteria = [
  'bobot_harga_makanan' => ['label' => 'Harga Makanan', 'deskripsi' => 'Apakah kamu sering memilih menu karena harganya terjangkau, agar bisa hemat? Jika ya, maka bobot harga harus tinggi.'],
  'bobot_jarak' => ['label' => 'Jarak', 'deskripsi' => 'Kalau kamu malas jalan jauh dan lebih sering makan di warung dekat-dekat, maka kamu menganggap jarak penting.'],
  'bobot_waktu_tunggu' => ['label' => 'Waktu Tunggu', 'deskripsi' => 'Kalau kamu tidak suka menunggu lama, maka bobot waktu tunggu akan tinggi.'],
  'bobot_popularitas' => ['label' => 'Popularitas', 'deskripsi' => 'Jika kamu percaya tempat yang ramai pasti enak, maka popularitas penting buat kamu.'],
  'bobot_kebersihan_makanan' => ['label' => 'Kebersihan Makanan', 'deskripsi' => 'Kalau kamu sangat memperhatikan kebersihan, maka bobotnya tinggi.'],
  'bobot_variasi_makanan' => ['label' => 'Variasi Makanan', 'deskripsi' => 'Kalau kamu suka banyak pilihan menu, maka bobotnya tinggi.'],
  'bobot_kemudahan_pembayaran' => ['label' => 'Kemudahan Pembayaran', 'deskripsi' => 'Kalau kamu suka pakai QRIS/e-wallet, maka ini penting.'],
  'bobot_pelengkap_makanan' => ['label' => 'Pelengkap Makanan', 'deskripsi' => 'Kalau kamu merasa pelengkap bikin makanan lebih enak, maka bobotnya tinggi.'],
  'bobot_kelengkapan_alat_makan' => ['label' => 'Kelengkapan Alat Makan', 'deskripsi' => 'Kalau kamu suka alat makan yang bersih dan lengkap, bobotnya tinggi.']
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekomendasi Orang Lain - DSS MAUT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="style.css" rel="stylesheet">
  <style>
    .card-text { font-size: 0.95rem; }
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
          <h5 class="mb-0">Rekomendasi Orang Lain</h5>
=======
  <?php
  include 'connection.php';

  $kriteria = [
    'bobot_harga_makanan' => ['label' => 'Harga Makanan', 'deskripsi' => 'Apakah kamu sering memilih menu karena harganya terjangkau, agar bisa hemat? Jika ya, maka bobot harga harus tinggi.'],
    'bobot_jarak' => ['label' => 'Jarak', 'deskripsi' => 'Kalau kamu malas jalan jauh dan lebih sering makan di warung dekat-dekat, maka kamu menganggap jarak penting.'],
    'bobot_waktu_tunggu' => ['label' => 'Waktu Tunggu', 'deskripsi' => 'Kalau kamu tidak suka menunggu lama, maka bobot waktu tunggu akan tinggi.'],
    'bobot_popularitas' => ['label' => 'Popularitas', 'deskripsi' => 'Jika kamu percaya tempat yang ramai pasti enak, maka popularitas penting buat kamu.'],
    'bobot_kebersihan_makanan' => ['label' => 'Kebersihan Makanan', 'deskripsi' => 'Kalau kamu sangat memperhatikan kebersihan, maka bobotnya tinggi.'],
    'bobot_variasi_makanan' => ['label' => 'Variasi Makanan', 'deskripsi' => 'Kalau kamu suka banyak pilihan menu, maka bobotnya tinggi.'],
    'bobot_kemudahan_pembayaran' => ['label' => 'Kemudahan Pembayaran', 'deskripsi' => 'Kalau kamu suka pakai QRIS/e-wallet, maka ini penting.'],
    'bobot_pelengkap_makanan' => ['label' => 'Pelengkap Makanan', 'deskripsi' => 'Kalau kamu merasa pelengkap bikin makanan lebih enak, maka bobotnya tinggi.'],
    'bobot_kelengkapan_alat_makan' => ['label' => 'Kelengkapan Alat Makan', 'deskripsi' => 'Kalau kamu suka alat makan yang bersih dan lengkap, bobotnya tinggi.']
  ];
  ?>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>Rekomendasi Orang Lain - DSS MAUT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <style>
      .card-text {
        font-size: 0.95rem;
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
          <li class="nav-item"><a class="nav-link" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
          <li class="nav-item"><a class="nav-link active" href="rekomendasi-orang-lain.php"><i class="bi bi-people me-2"></i>Rekomendasi Orang Lain</a></li>
          <li class="nav-item"><a class="nav-link" href="alternatif.php"><i class="bi bi-list-ul me-2"></i>Data Alternatif</a></li>
        </ul>
      </div>
    </div>

    <div class="main-content">
      <div id="header-container">
        <div class="topbar">
          <div class="d-flex align-items-center">
            <i class="bi bi-list hamburger-menu" id="hamburgerToggle"></i>
            <h5 class="mb-0">Rekomendasi Orang Lain</h5>
          </div>
        </div>
      </div>

      <div class="container mt-4">
        <h3 class="mb-4">Riwayat Bobot Unik</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
          <?php
          $query = "SELECT * FROM history_bobot WHERE tipe = 'unik' ORDER BY num DESC";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $num = $row['num'];
              ?>
              <div class="col">
                <div class="card shadow-sm h-100">
                  <div class="card-body">
                    <h5 class="card-title">Rekomendasi #<?= $num ?></h5>
                    <p class="card-text">Klik untuk melihat detail bobot dan gunakan rekomendasi ini.</p>
                    <button class="btn btn-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#bobot<?= $num ?>">Lihat Bobot</button>
                    <div class="collapse" id="bobot<?= $num ?>">
                      <ul class="list-group list-group-flush mb-2">
                        <?php
                        foreach ($kriteria as $key => $info) {
                          echo "<li class='list-group-item'><strong>{$info['label']}</strong> (".number_format($row[$key], 1).")<br><small class='text-muted'>{$info['deskripsi']}</small></li>";
                        }
                        ?>
                      </ul>
                    </div>
                    <?php
                    // Kirim data sebagai query string ke proses_rekomendasi.php
                    $params = http_build_query(array_map('floatval', array_filter($row, fn($k) => str_starts_with($k, 'bobot_'), ARRAY_FILTER_USE_KEY)));
                    ?>
                    <a href="proses_orang_lain.php?<?= htmlspecialchars($params) ?>" class="btn btn-primary">Gunakan Bobot Ini</a>                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo "<p class='text-muted'>Belum ada data bobot unik.</p>";
          }
          ?>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
        </div>
      </div>
    </div>

<<<<<<< HEAD
    <div class="container mt-4">
      <h3 class="mb-4">Riwayat Bobot Unik</h3>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        $query = "SELECT * FROM history_bobot WHERE tipe = 'unik' ORDER BY num DESC";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $num = (int)$row['num']; // pastikan num aman untuk digunakan di id HTML
            ?>
            <div class="col">
              <div class="card shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title">Rekomendasi #<?= $num ?></h5>
                  <p class="card-text">Klik untuk melihat detail bobot dan gunakan rekomendasi ini.</p>
                  <button class="btn btn-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#bobot<?= $num ?>" aria-expanded="false" aria-controls="bobot<?= $num ?>">Lihat Bobot</button>
                  <div class="collapse" id="bobot<?= $num ?>">
                    <ul class="list-group list-group-flush mb-2">
                      <?php
                      foreach ($kriteria as $key => $info) {
                        $nilai = isset($row[$key]) ? number_format((float)$row[$key], 1) : '0.0';
                        echo "<li class='list-group-item'><strong>" . htmlspecialchars($info['label']) . "</strong> ($nilai)<br><small class='text-muted'>" . htmlspecialchars($info['deskripsi']) . "</small></li>";
                      }
                      ?>
                    </ul>
                  </div>
                  <?php
                  // Validasi data yang akan dikirim via GET
                  $valid_params = [];
                  foreach ($kriteria as $key => $_) {
                    if (isset($row[$key])) {
                      $valid_params[$key] = (float)$row[$key]; // konversi ke float untuk keamanan
                    }
                  }
                  $queryString = http_build_query($valid_params);
                  ?>
                  <a href="proses_orang_lain.php?<?= htmlspecialchars($queryString) ?>" class="btn btn-primary">Gunakan Bobot Ini</a>
                </div>
              </div>
            </div>
            <?php
          }
        } else {
          echo "<p class='text-muted'>Belum ada data bobot unik.</p>";
        }
        ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="main.js"></script>
</body>
</html>
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
  </html>
>>>>>>> fbb9d23f5db789eb218d481d30a029b5afd5da8c
