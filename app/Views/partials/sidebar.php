<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('/') ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-receipt"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Si Payroll</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="<?= site_url('dashboard') ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
      aria-expanded="true" aria-controls="collapseMaster">
      <i class="fas fa-database"></i>
      <span>Master Data</span>
    </a>
    <div id="collapseMaster" class="collapse" aria-labelledby="headingMaster" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?= site_url('users') ?>">Pegawai</a>
        <a class="collapse-item" href="<?= site_url('positions') ?>">Jabatan</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaction"
      aria-expanded="true" aria-controls="collapseTransaction">
      <i class="fas fa-file-invoice-dollar"></i>
      <span>Transaksi</span>
    </a>
    <div id="collapseTransaction" class="collapse" aria-labelledby="headingTransaction" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?= site_url('attendance') ?>">Absensi</a>
        <a class="collapse-item" href="<?= site_url('deductions') ?>">Potongan Gaji</a>
        <a class="collapse-item" href="<?= site_url('salaries') ?>">Data Gaji</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
      aria-expanded="true" aria-controls="collapseReport">
      <i class="fas fa-file-invoice-dollar"></i>
      <span>Laporan</span>
    </a>
    <div id="collapseReport" class="collapse" aria-labelledby="headingTransaction" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="<?= site_url('attendance/report') ?>">Laporan Absensi</a>
        <a class="collapse-item" href="<?= site_url('salaries/report') ?>">Laporan Gaji</a>
        <a class="collapse-item" href="<?= site_url('salaries/slip-report') ?>">Slip Gaji</a>
      </div>
    </div>
  </li>

</ul>
<!-- End of Sidebar -->
