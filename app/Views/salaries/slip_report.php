<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Laporan Slip Gaji<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Laporan Slip Gaji<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Laporan / Slip Gaji<?= $this->endSection() ?>
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
  <div class="card-header py-3 bg-primary text-white">
    <h6 class="mb-0">Filter Slip</h6>
  </div>
  <div class="card-body">
    <form class="row g-3" method="get" action="<?= site_url('salaries/slip-report') ?>">
      <div class="col-md-4">
        <label class="form-label">Pegawai</label>
        <select name="user_id" class="form-select form-control" required>
          <option value="">-- Pilih Pegawai --</option>
          <?php foreach (($users ?? []) as $u): ?>
            <option value="<?= esc($u['id']) ?>" <?= ($selectedUserId ?? '') === ($u['id'] ?? '') ? 'selected' : '' ?>><?= esc($u['name'] ?? $u['username']) ?> (<?= esc($u['nin'] ?? '-') ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Bulan</label>
        <select name="month" class="form-select form-control">
          <?php $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>
          <?php foreach ($months as $m => $label): ?>
            <option value="<?= $m ?>" <?= ($month ?? date('n')) == $m ? 'selected' : '' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Tahun</label>
        <input type="number" name="year" class="form-control" value="<?= esc($year ?? date('Y')) ?>" min="2000" max="2100">
      </div>
      <div class="col-md-4">
        <label class="form-label">Tanggal Cetak</label>
        <input type="date" name="date" class="form-control" value="<?= esc($date ?? date('Y-m-d')) ?>">
      </div>
      <div class="col-12 d-flex justify-content-end">
        <?php $baseQuery = 'user_id=' . urlencode($selectedUserId ?? '') . '&month=' . urlencode((string) ($month ?? date('n'))) . '&year=' . urlencode((string) ($year ?? date('Y'))) . '&date=' . urlencode((string) ($date ?? date('Y-m-d'))); ?>
        <a id="btnExcel" class="btn btn-success mx-1 <?= ($selectedUserId ?? '') === '' ? 'disabled' : '' ?>" aria-disabled="<?= ($selectedUserId ?? '') === '' ? 'true' : 'false' ?>" href="<?= ($selectedUserId ?? '') !== '' ? site_url('salaries/slip-export?format=excel&' . $baseQuery) : '#' ?>"><i class="fas fa-file-excel mr-1"></i> Cetak Excel</a>
        <a id="btnPdf" class="btn btn-danger mx-1 <?= ($selectedUserId ?? '') === '' ? 'disabled' : '' ?>" aria-disabled="<?= ($selectedUserId ?? '') === '' ? 'true' : 'false' ?>" href="<?= ($selectedUserId ?? '') !== '' ? site_url('salaries/slip-export?format=pdf&' . $baseQuery) : '#' ?>"><i class="fas fa-file-pdf mr-1"></i> Cetak PDF</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  (function(){
    var base = '<?= site_url('salaries/slip-export') ?>';
    function update() {
      var uid = document.querySelector('[name="user_id"]').value;
      var m = document.querySelector('[name="month"]').value;
      var y = document.querySelector('[name="year"]').value;
      var d = document.querySelector('[name="date"]').value;
      var excel = document.getElementById('btnExcel');
      var pdf = document.getElementById('btnPdf');
      var qs = '?user_id=' + encodeURIComponent(uid) + '&month=' + encodeURIComponent(m) + '&year=' + encodeURIComponent(y) + '&date=' + encodeURIComponent(d);
      if (uid) {
        excel.classList.remove('disabled');
        pdf.classList.remove('disabled');
        excel.setAttribute('aria-disabled','false');
        pdf.setAttribute('aria-disabled','false');
        excel.href = base + qs + '&format=excel';
        pdf.href = base + qs + '&format=pdf';
      } else {
        excel.classList.add('disabled');
        pdf.classList.add('disabled');
        excel.setAttribute('aria-disabled','true');
        pdf.setAttribute('aria-disabled','true');
        excel.href = '#';
        pdf.href = '#';
      }
    }
    document.querySelector('[name="user_id"]').addEventListener('change', update);
    document.querySelector('[name="month"]').addEventListener('change', update);
    document.querySelector('[name="year"]').addEventListener('input', update);
    document.querySelector('[name="date"]').addEventListener('change', update);
  })();
</script>
<?= $this->endSection() ?>
