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

<div class="row mt-4">
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <div class="h6 mb-0">Komposisi Payroll Bulan Ini</div>
      </div>
      <div class="card-body">
        <canvas id="piePayroll" height="220"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-header bg-white">
        <div class="h6 mb-0">Total Payroll 6 Bulan Terakhir</div>
      </div>
      <div class="card-body">
        <canvas id="barPayroll" height="220"></canvas>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  (function(){
    var pieCtx = document.getElementById('piePayroll').getContext('2d');
    var barCtx = document.getElementById('barPayroll').getContext('2d');
    var compLabels = <?= json_encode($compLabels ?? []) ?>;
    var compData = <?= json_encode($compData ?? []) ?>;
    var barLabels = <?= json_encode($barLabels ?? []) ?>;
    var barData = <?= json_encode($barData ?? []) ?>;

    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: compLabels,
        datasets: [{
          data: compData,
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#e74a3b'],
        }]
      },
      options: {
        plugins: { legend: { position: 'bottom' } },
        responsive: true,
        maintainAspectRatio: false
      }
    });

    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: barLabels,
        datasets: [{
          label: 'Total Dibayarkan',
          data: barData,
          backgroundColor: '#4e73df'
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        },
        plugins: { legend: { display: false } },
        responsive: true,
        maintainAspectRatio: false
      }
    });
  })();
</script>
<?= $this->endSection() ?>
