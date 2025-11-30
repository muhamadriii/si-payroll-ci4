<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Laporan Absensi<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Laporan Absensi Bulanan<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Laporan / Absensi Bulanan<?= $this->endSection() ?>
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

<div class="card shadow-sm mb-4">
  <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
    <h6 class="mb-0">Filter Laporan</h6>
    <div class="d-flex">
      <a id="btnAttExcel" class="btn btn-light btn-sm mx-1" href="<?= site_url('attendance/export?format=excel&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Cetak Excel</a>
      <a id="btnAttPdf" class="btn btn-outline-light btn-sm mx-1" href="<?= site_url('attendance/export?format=pdf&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Cetak PDF</a>
    </div>
  </div>
  <div class="card-body">
    <form class="row g-3 align-items-end" method="get" action="<?= site_url('attendance/report') ?>">
      <div class="col-md-4">
        <label class="form-label">Bulan</label>
        <select name="month" class="form-select form-control">
          <?php $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>
          <?php foreach ($months as $m => $label): ?>
            <option value="<?= $m ?>" <?= ($month ?? date('n')) == $m ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Tahun</label>
        <input type="number" name="year" class="form-control" value="<?= esc($year ?? date('Y')) ?>" min="2000" max="2100">
      </div>
      <div class="col-md-4">
        <a id="btnAttPreview" class="btn btn-outline-primary w-100" href="<?= site_url('attendance/report?month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Preview Data</a>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm mb-4">
  <div class="card-header py-3 bg-white">
    <h6 class="mb-0">Preview Data</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="attTable" class="table table-striped table-hover">
        <thead class="table-light">
          <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th class="text-end">Sakit</th>
            <th class="text-end">Izin</th>
            <th class="text-end">Alfa</th>
            <th class="text-end">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($rows ?? []) as $r): ?>
            <tr>
              <td><?= esc($r['nin']) ?></td>
              <td><?= esc($r['name']) ?></td>
              <td><?= esc($r['position_name']) ?></td>
              <td class="text-end"><?= esc($r['sick_days']) ?></td>
              <td class="text-end"><?= esc($r['leave_days']) ?></td>
              <td class="text-end"><?= esc($r['absent_days']) ?></td>
              <td class="text-end fw-semibold"><?= esc(($r['sick_days'] + $r['leave_days'] + $r['absent_days'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer bg-white">
    <small class="text-muted">Periode: <?= esc($month) ?> / <?= esc($year) ?></small>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  (function(){
    var base = '<?= site_url('attendance/export') ?>';
    var rep = '<?= site_url('attendance/report') ?>';
    function update() {
      var m = document.querySelector('[name="month"]').value;
      var y = document.querySelector('[name="year"]').value;
      var qs = '?month=' + encodeURIComponent(m) + '&year=' + encodeURIComponent(y);
      document.getElementById('btnAttExcel').href = base + qs + '&format=excel';
      document.getElementById('btnAttPdf').href = base + qs + '&format=pdf';
      document.getElementById('btnAttPreview').href = rep + qs;
    }
    document.querySelector('[name="month"]').addEventListener('change', update);
    document.querySelector('[name="year"]').addEventListener('input', update);
    update();
  })();
  $(function(){
    $('#attTable').DataTable({
      pageLength: 25,
      lengthChange: false
    });
  });
</script>
<?= $this->endSection() ?>
