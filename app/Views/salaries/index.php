<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Data Gaji<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Data Gaji<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Transaksi / Data Gaji<?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-end align-items-center mb-3">
  <div class="btn-group">
    <!-- <a class="btn btn-success">Export</a> -->
    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="pr-2">Export</span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
      <a class="dropdown-item" href="<?= site_url('salaries/export?format=csv&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">CSV</a>
      <a class="dropdown-item" href="<?= site_url('salaries/export?format=excel&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Excel</a>
      <a class="dropdown-item" href="<?= site_url('salaries/export?format=pdf&month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">PDF</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card shadow-sm mb-3">
  <div class="card-header py-3 bg-primary text-white">
    <h5 class="card-title mb-0">Filter Data Gaji</h5>
  </div>
  <div class="card-body py-3">
    <form class="row justify-content-between align-items-center" method="get" action="<?= site_url('salaries') ?>">
      <div class="col-xl-6 d-flex mb-md-3">
        <div class="col-md-6">
          <span class="form-label">Bulan : </span>
          <select name="month" class="form-select form-control">
            <?php for ($m = 1; $m <= 12; $m++): ?>
              <option value="<?= $m ?>" <?= ($month ?? date('n')) == $m ? 'selected' : '' ?>>
                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-6">
          <span class="form-label">Tahun : </span>
          <select name="year" class="form-select form-control">
            <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
              <option value="<?= $y ?>" <?= ($year ?? date('Y')) == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
      <div class="col-xl-6 d-flex justify-content-end">
        <button class="btn btn-outline-secondary mx-2" type="submit">Tampilkan Data</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table id="salariesTable" class="table table-striped border" style="width:100%">
      <thead>
        <tr>
          <th>NIK</th>
          <th>Jabatan</th>
          <th>Gaji Pokok</th>
          <th>Tunj. Transport</th>
          <th>Tunj. Makan</th>
          <th>Potongan</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach (($rows ?? []) as $r): ?>
        <tr>
          <td><?= esc($r['nin']) ?></td>
          <td><?= esc($r['position_name']) ?></td>
          <td><?= number_format($r['base_salary'], 2, ',', '.') ?></td>
          <td><?= number_format($r['transport_allowance'], 2, ',', '.') ?></td>
          <td><?= number_format($r['meal_allowance'], 2, ',', '.') ?></td>
          <td><?= number_format($r['deduction_amount'], 2, ',', '.') ?></td>
          <td><?= number_format($r['total_salary'], 2, ',', '.') ?></td>
          <td class="text-nowrap">
            <a class="btn btn-sm btn-outline-primary" target="_blank" href="<?= site_url('salaries/slip/' . esc($r['id'])) ?>">Slip</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(function() {
    $('#salariesTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
    });
  });
</script>
<?= $this->endSection() ?>

