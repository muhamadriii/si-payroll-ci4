
<?= $this->extend('layouts/admin') ?>

<?= $this->section('title_page') ?><?= $mode === 'create' ? 'Tambah Jabatan' : 'Edit Jabatan' ?><?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Master Data / Jabatan / <?= $mode === 'create' ? 'Tambah' : 'Edit' ?><?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-end align-items-center mb-3">
  <a class="btn btn-secondary" href="<?= site_url('positions') ?>">Kembali</a>
</div>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0"><?= $mode === 'create' ? 'Tambah Jabatan' : 'Edit Jabatan' ?></h5>
  <a class="btn btn-secondary" href="<?= site_url('positions') ?>">Kembali</a>
</div>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <form method="post" action="<?= $mode === 'create' ? site_url('positions/store') : site_url('positions/' . $position['id'] . '/update') ?>">
      <?= csrf_field() ?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Nama Jabatan</label>
          <input type="text" name="name" value="<?= esc($position['name'] ?? '') ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label>Gaji Pokok</label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
            <input type="number" step="0.01" min="0" name="base_salary" value="<?= esc($position['base_salary'] ?? '') ?>" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Tunjangan Transport</label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
            <input type="number" step="0.01" min="0" name="transport_allowance" value="<?= esc($position['transport_allowance'] ?? '') ?>" class="form-control" required>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label>Tunjangan Makan</label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
            <input type="number" step="0.01" min="0" name="meal_allowance" value="<?= esc($position['meal_allowance'] ?? '') ?>" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="card-footer text-end bg-white border-0 px-0">
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
