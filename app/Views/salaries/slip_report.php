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
  <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
    <h6 class="mb-0">Filter Slip</h6>
    <div class="d-flex">
      <?php $baseQuery = 'user_id=' . urlencode($selectedUserId ?? '') . '&month=' . urlencode((string) ($month ?? date('n'))) . '&year=' . urlencode((string) ($year ?? date('Y'))) . '&date=' . urlencode((string) ($date ?? date('Y-m-d'))); ?>
      <a id="btnExcel" class="btn btn-light btn-sm mx-1" target="_blank" rel="noopener" href="<?= ($selectedUserId ?? '') !== '' ? site_url('salaries/slip-export?format=excel&' . $baseQuery) : '#' ?>">Cetak Excel</a>
      <a id="btnPdf" class="btn btn-outline-light btn-sm mx-1" target="_blank" rel="noopener" href="<?= ($selectedUserId ?? '') !== '' ? site_url('salaries/slip-export?format=pdf&' . $baseQuery) : '#' ?>">Cetak PDF</a>
      <a id="btnSlipPreview" class="btn btn-outline-light btn-sm mx-1" href="<?= ($selectedUserId ?? '') !== '' ? site_url('salaries/slip-report?' . $baseQuery) : '#' ?>">Preview Slip</a>
    </div>
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
          <?php $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember']; ?>
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
    </form>
  </div>
</div>

<div class="card shadow-sm mb-4">
  <div class="card-header py-3 bg-white">
    <h6 class="mb-0">Preview Slip</h6>
  </div>
  <div class="card-body">
    <?php if (($selectedUserId ?? '') === '' || !isset($row) || $row === null): ?>
      <div class="text-muted">Pilih pegawai dan periode untuk melihat preview slip.</div>
    <?php else: ?>
      <?php $base = (float) ($row['base_salary'] ?? 0); $trans = (float) ($row['transport_allowance'] ?? 0); $meal = (float) ($row['meal_allowance'] ?? 0); $ded = (float) ($row['deduction_amount'] ?? 0); $subtotal = $base + $trans + $meal - $ded; ?>
      <div class="card border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <div>
            <div class="h6 mb-0">Slip Gaji</div>
            <div class="text-muted small">Periode <?= esc($row['month']) ?>/<?= esc($row['year']) ?></div>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-8">
              <div class="text-muted small">Identitas Pegawai</div>
              <div class="fw-semibold mb-1"><?= esc(($user['name'] ?? '') !== '' ? $user['name'] : ($row['nin'] ?? '')) ?></div>
              <div class="row g-2">
                <div class="col-6"><span class="text-muted small">NIK</span><div><?= esc($row['nin']) ?></div></div>
                <div class="col-6"><span class="text-muted small">Tanggal Masuk</span><div><?= esc($user['hire_date'] ?? '-') ?></div></div>
              </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
              <div class="text-muted small">Ringkasan Absensi</div>
              <div>Sakit: <?= esc((int) ($att['sick_days'] ?? 0)) ?> | Izin: <?= esc((int) ($att['leave_days'] ?? 0)) ?> | Alfa: <?= esc((int) ($att['absent_days'] ?? 0)) ?></div>
            </div>
          </div>

          <table class="table table-sm mb-0">
            <tbody>
              <tr>
                <td>Gaji Pokok</td>
                <td class="text-end"><?= number_format($base, 2, ',', '.') ?></td>
              </tr>
              <tr>
                <td>Tunjangan Transport</td>
                <td class="text-end"><?= number_format($trans, 2, ',', '.') ?></td>
              </tr>
              <tr>
                <td>Tunjangan Makan</td>
                <td class="text-end"><?= number_format($meal, 2, ',', '.') ?></td>
              </tr>
              <tr>
                <td class="text-muted">Potongan</td>
                <td class="text-end text-danger">-<?= number_format($ded, 2, ',', '.') ?></td>
              </tr>
              <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-sm mb-0">
                        <tbody>
                          <tr>
                            <td>Sakit (<?= esc((int) ($att['sick_days'] ?? 0)) ?> × <?= number_format($deductionDetail['sakit']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                            <td class="text-end text-danger">-<?= number_format($deductionDetail['sakit']['amount'] ?? 0, 2, ',', '.') ?></td>
                          </tr>
                          <tr>
                            <td>Izin (<?= esc((int) ($att['leave_days'] ?? 0)) ?> × <?= number_format($deductionDetail['izin']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                            <td class="text-end text-danger">-<?= number_format($deductionDetail['izin']['amount'] ?? 0, 2, ',', '.') ?></td>
                          </tr>
                          <tr>
                            <td>Alfa (<?= esc((int) ($att['absent_days'] ?? 0)) ?> × <?= number_format($deductionDetail['alfa']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                            <td class="text-end text-danger">-<?= number_format($deductionDetail['alfa']['amount'] ?? 0, 2, ',', '.') ?></td>
                          </tr>
                          <tr class="table-light">
                            <td class="fw-semibold">Total Potongan</td>
                            <td class="text-end fw-semibold text-danger">-<?= number_format($deductionDetail['total'] ?? 0, 2, ',', '.') ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="table-light">
                <td class="fw-semibold">Subtotal</td>
                <td class="text-end fw-semibold"><?= number_format($subtotal, 2, ',', '.') ?></td>
              </tr>
              <tr class="table-primary">
                <td class="fw-bold">Total Dibayarkan</td>
                <td class="text-end fw-bold"><?= number_format($row['total_salary'], 2, ',', '.') ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  (function() {
    var base = '<?= site_url('salaries/slip-export') ?>';
    
    function update() {
      var uid = document.querySelector('[name="user_id"]').value;
      var m = document.querySelector('[name="month"]').value;
      var y = document.querySelector('[name="year"]').value;
      var d = document.querySelector('[name="date"]').value;
      var excel = document.getElementById('btnExcel');
      var pdf = document.getElementById('btnPdf');
      var prevBtn = document.getElementById('btnSlipPreview');
      var qs = '?user_id=' + encodeURIComponent(uid) + '&month=' + encodeURIComponent(m) + '&year=' + encodeURIComponent(y) + '&date=' + encodeURIComponent(d);
      if (uid) {
        excel.href = base + qs + '&format=excel';
        pdf.href = base + qs + '&format=pdf';
        prevBtn.href = '<?= site_url('salaries/slip-report') ?>' + qs;
        excel.dataset.disabled = 'false';
        pdf.dataset.disabled = 'false';
      } else {
        excel.href = '#';
        pdf.href = '#';
        prevBtn.href = '#';
        excel.dataset.disabled = 'true';
        pdf.dataset.disabled = 'true';
      }
    }
    document.querySelector('[name="user_id"]').addEventListener('change', update);
    document.querySelector('[name="month"]').addEventListener('change', update);
    document.querySelector('[name="year"]').addEventListener('input', update);
    document.querySelector('[name="date"]').addEventListener('change', update);
    document.getElementById('btnExcel').addEventListener('click', function(e){ var h=this.getAttribute('href'); if (h === '#') { e.preventDefault(); } });
    document.getElementById('btnPdf').addEventListener('click', function(e){ var h=this.getAttribute('href'); if (h === '#') { e.preventDefault(); } });
    document.getElementById('btnSlipPreview').addEventListener('click', function(e){ var h=this.getAttribute('href'); if (h === '#') { e.preventDefault(); } });
    update();
  })();
</script>
<?= $this->endSection() ?>
