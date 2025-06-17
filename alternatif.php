<?php
include 'connection.php';

// Sorting berdasarkan nama warung
$order = "";
if (isset($_GET['sort']) && ($_GET['sort'] == 'asc' || $_GET['sort'] == 'desc')) {
    $order = " ORDER BY nama_warung " . strtoupper($_GET['sort']);
}

// Ambil data alternatif dengan sorting
$data = mysqli_query($conn, "SELECT * FROM alternatif" . $order);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Alternatif - DSS MAUT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    select#sort {
      padding-right: 2rem;
      background-position: right 0.5rem center;
      background-repeat: no-repeat;
      background-size: 1rem;
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
          <h5 class="mb-0">Data Alternatif</h5>
        </div>
      </div>
    </div>
    <div class="container mt-4">
      <div class="card">
        <div class="card-body">
          <h3>List Data Alternatif</h3>

          <!-- Dropdown Sorting -->
          <form method="GET" class="mb-3 d-flex align-items-center">
            <label for="sort" class="me-2">Urutkan Nama Warung:</label>
            <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
              <option value="">-- Pilih --</option>
              <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : '' ?>>A - Z &#x25B2;</option>
              <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : '' ?>>Z - A &#x25BC;</option>
            </select>
          </form>

          <!-- Tabel Alternatif -->
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Makanan</th>
                <th>Nama Warung</th>
                <th>Lokasi Warung</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($data)): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
                <td><?= htmlspecialchars($row['nama_warung']) ?></td>
                <td><?= htmlspecialchars($row['lokasi_warung']) ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="main.js"></script>
</body>
</html>
