<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Dokumentasi DSS MAUT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div id="sidebar-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <a href="index.php" class="text-white" style="text-decoration:none;"><i class="bi bi-house-door-fill"></i> Home</a>
      </div>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link active" href="index.php"><i class="bi bi-journal-text me-2"></i>Dokumentasi</a></li>
        <li class="nav-item"><a class="nav-link" href="rekomendasi.php"><i class="bi bi-lightbulb me-2"></i>Minta Rekomendasi</a></li>
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
          <h5 class="mb-0">Dokumentasi Sistem DSS MAUT</h5>
        </div>
      </div>
    </div>
    <div class="container mt-4">
      <div class="card">
        <div class="card-body">
          <h2>Dokumentasi Sistem DSS MAUT</h2>
          <p>Aplikasi ini menggunakan metode <b>MAUT (Multi Attribute Utility Theory)</b> untuk memberikan rekomendasi makanan terbaik berdasarkan kriteria yang Anda tentukan. Anda dapat mengisi tingkat kepentingan setiap kriteria pada menu <b>Minta Rekomendasi</b>, lalu sistem akan menghitung skor setiap alternatif dan menampilkan rekomendasi terbaik.</p>
          <ul>
            <li><b>Minta Rekomendasi:</b> Isi bobot kriteria, dapatkan rekomendasi makanan terbaik.</li>
            <li><b>Rekomendasi Orang Lain:</b> Lihat hasil rekomendasi user lain.</li>
            <li><b>List Data Alternatif:</b> Lihat daftar makanan/warung beserta detailnya.</li>
          </ul>
          <h4>Langkah Kerja MAUT:</h4>
          <ol>
            <li>Normalisasi nilai setiap alternatif pada tiap kriteria.</li>
            <li>Hitung utility value berdasarkan bobot yang diinput user.</li>
            <li>Jumlahkan skor utility untuk setiap alternatif.</li>
            <li>Alternatif dengan skor tertinggi menjadi rekomendasi terbaik.</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="main.js"></script>
</body>
</html>
