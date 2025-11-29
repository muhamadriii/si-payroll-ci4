<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Payroll - Kelola Gaji Lebih Mudah</title>
  <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    .hero {
      background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%);
      color: #fff;
    }
    .feature-card { transition: transform .2s ease, box-shadow .2s ease; }
    .feature-card:hover { transform: translateY(-4px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15); }
    .brand-logo { font-weight: 800; letter-spacing: .5px; }
    .cta-btn { min-width: 180px; }
    .section-title { font-weight: 800; }
  </style>
  <link rel="icon" href="<?= base_url('favicon.ico') ?>">
  <meta name="description" content="Sistem payroll modern untuk mengelola pegawai, absensi, dan penggajian secara efisien.">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand brand-logo" href="<?= site_url('/') ?>">Web Payroll</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
          <li class="nav-item"><a class="nav-link" href="#demo">Demo</a></li>
          <li class="nav-item"><a class="btn btn-primary ml-lg-3" href="<?= site_url('login') ?>">Masuk</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="hero py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h1 class="display-4 mb-3">Cetak Slip & Penggajian Lebih Mudah</h1>
          <p class="lead mb-4">Kelola payroll modern: rekap absensi, hitung gaji otomatis, dan cetak slip/invoice profesional dalam satu sistem.</p>
          <div class="d-flex">
            <a class="btn btn-light btn-lg cta-btn mr-3" href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt mr-2"></i>Masuk</a>
            <a class="btn btn-outline-light btn-lg cta-btn" href="#fitur"><i class="fas fa-bolt mr-2"></i>Pelajari Fitur</a>
          </div>
        </div>
        <div class="col-lg-6 text-center">
          <img src="<?= base_url('img/printing-invoices.svg') ?>" alt="Hero Image" class="img-fluid">
        </div>
      </div>
    </div>
  </header>

  <section id="fitur" class="py-5">
    <div class="container">
      <h2 class="section-title h1 text-center mb-4">Fitur Utama</h2>
      <p class="text-center text-muted mb-5">Semua yang Anda butuhkan untuk operasional HR dan payroll harian.</p>
      <div class="row">
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body">
              <div class="mb-3 text-primary"><i class="fas fa-users fa-2x"></i></div>
              <h5 class="card-title">Manajemen Pegawai</h5>
              <p class="card-text text-muted">Kelola data pegawai, posisi, dan riwayat dengan cepat.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body">
              <div class="mb-3 text-success"><i class="fas fa-calendar-check fa-2x"></i></div>
              <h5 class="card-title">Absensi & Presensi</h5>
              <p class="card-text text-muted">Rekap sakit, cuti, dan ketidakhadiran secara terstruktur.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body">
              <div class="mb-3 text-info"><i class="fas fa-coins fa-2x"></i></div>
              <h5 class="card-title">Penggajian Otomatis</h5>
              <p class="card-text text-muted">Hitung gaji, tunjangan, dan potongan secara akurat.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="card feature-card h-100 shadow-sm">
            <div class="card-body">
              <div class="mb-3 text-warning"><i class="fas fa-chart-line fa-2x"></i></div>
              <h5 class="card-title">Laporan & Slip</h5>
              <p class="card-text text-muted">Cetak slip gaji dan ekspor laporan bulanan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="demo" class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-2 order-lg-1">
          <h3 class="mb-3">Siap mulai?</h3>
          <p class="text-muted mb-4">Masuk untuk melihat dashboard dan mulai mengelola data pegawai serta proses penggajian.</p>
          <a class="btn btn-primary btn-lg" href="<?= site_url('login') ?>">Masuk ke Sistem</a>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 text-center mb-4 mb-lg-0">
          <img src="<?= base_url('img/undraw_posting_photo.svg') ?>" alt="Demo" class="img-fluid" style="max-height: 300px;">
        </div>
      </div>
    </div>
  </section>

  <footer class="py-4 bg-white border-top">
    <div class="container text-center text-muted">
      <small>&copy; <?= date('Y') ?> Web Payroll</small>
    </div>
  </footer>

  <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
  <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
</body>
</html>
