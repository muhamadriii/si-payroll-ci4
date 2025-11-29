<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Absensi') ?><?= $this->endSection() ?>
<?= $this->section('title_page') ?><?= esc($title ?? 'Absensi') ?><?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Transaksi / <?= esc($title ?? 'Absensi') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>
<div class="card shadow-sm mb-3">
  <div class="card-header py-3  bg-primary text-white">
    <h5 class="card-title mb-0">Filter Absensi</h5>
  </div>
  <div class="card-body py-3">
    <form class="row justify-content-between align-items-center" method="get" action="<?= site_url('attendance') ?>">
      <div class="col-xl-6 d-flex mb-md-3">
        <!-- Bulan -->
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
  
        <!-- Tahun -->
        <div class="col-md-6">
          <span class="form-label">Tahun : </span>
          <select name="year" class="form-select form-control">
            <?php for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++): ?>
              <option value="<?= $y ?>" <?= ($year ?? date('Y')) == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <!-- Aksi -->
      <div class="col-xl-6 d-flex justify-content-end">
        <button class="btn btn-outline-secondary mx-2" type="submit">Tampilkan Data</button>
        <a class="btn btn-primary mx-2" href="<?= site_url('attendance/create?month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Rekap Presensi</a>
        <a class="btn btn-warning mx-2" href="<?= site_url('attendance/edit?month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Edit Presensi</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table id="attendanceTable" class="table table-striped border" style="width:100%">
      <thead>
        <tr>
          <th>NIK</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Sakit</th>
          <th>Izin</th>
          <th>Alpa</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($rows ?? []) as $row): ?>
          <tr>
            <td><?= esc($row['nin']) ?></td>
            <td><?= esc($row['username']) ?></td>
            <td><?= esc($row['name']) ?></td>
            <td><?= (int) $row['sick_days'] ?></td>
            <td><?= (int) $row['leave_days'] ?></td>
            <td><?= (int) $row['absent_days'] ?></td>
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
    $('#attendanceTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
    });
  });
</script>
<?= $this->endSection() ?>
