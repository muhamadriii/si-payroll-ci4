<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Laporan Gaji<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Laporan Gaji Bulanan<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Laporan / Gaji Bulanan<?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div></div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<?php $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>

<div class="card shadow-sm mb-4">
  <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
    <h6 class="mb-0">Filter Laporan</h6>
    <div class="d-flex">
      <a id="btnSalExcel" class="btn btn-light btn-sm mx-1" href="<?= site_url('salaries/export?format=excel&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Cetak Excel</a>
      <a id="btnSalPdf" class="btn btn-outline-light btn-sm mx-1" href="<?= site_url('salaries/export?format=pdf&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Cetak PDF</a>
    </div>
  </div>
  <div class="card-body">
    <form class="row g-3" method="get" action="<?= site_url('salaries/report') ?>">
      <div class="col-md-4">
        <label class="form-label">Bulan</label>
        <select name="month" class="form-select form-control">
          <?php foreach ($months as $m => $label): ?>
            <option value="<?= $m ?>" <?= ($month ?? date('n')) == $m ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Tahun</label>
        <input type="number" name="year" class="form-control" value="<?= esc($year ?? date('Y')) ?>" min="2000" max="2100">
      </div>
      
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  (function(){
    var base = '<?= site_url('salaries/export') ?>';
    function update() {
      var m = document.querySelector('[name="month"]').value;
      var y = document.querySelector('[name="year"]').value;
      var qs = '?month=' + encodeURIComponent(m) + '&year=' + encodeURIComponent(y);
      document.getElementById('btnSalExcel').href = base + qs + '&format=excel';
      document.getElementById('btnSalPdf').href = base + qs + '&format=pdf';
    }
    document.querySelector('[name="month"]').addEventListener('change', update);
    document.querySelector('[name="year"]').addEventListener('input', update);
    update();
  })();
</script>
<?= $this->endSection() ?>
