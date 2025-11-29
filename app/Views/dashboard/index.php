<?= $this->extend('layouts/admin') ?>

<?= $this->section('title_page') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Home / Dashboard<?= $this->endSection() ?>
<?= $this->section('header_button') ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row g-3">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="fw-bold">Total Karyawan</div>
        <div class="display-6"><?= esc($totalEmployees ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="fw-bold">Payroll Bulan Ini</div>
        <div class="display-6"><?= esc($processed ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="fw-bold">Total Biaya</div>
        <div class="display-6"><?= number_format($totalCost ?? 0, 2, ',', '.') ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="fw-bold">Rata-rata Gaji</div>
        <div class="display-6"><?= number_format($avgSalary ?? 0, 2, ',', '.') ?></div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
