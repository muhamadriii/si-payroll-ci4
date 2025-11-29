<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Potongan Gaji') ?><?= $this->endSection() ?>
<?= $this->section('title_page') ?><?= $mode === 'create' ? 'Tambah Potongan' : 'Edit Potongan' ?><?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Transaksi / Potongan Gaji / <?= $mode === 'create' ? 'Tambah' : 'Edit' ?><?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-end align-items-center mb-3">
  <a class="btn btn-secondary" href="<?= site_url('deductions') ?>">Kembali</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <form method="post" action="<?= $mode === 'create' ? site_url('deductions/store') : site_url('deductions/' . $deduction['id'] . '/update') ?>">
      <?= csrf_field() ?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Nama Potongan</label>
          <input type="text" name="name" value="<?= esc($deduction['name'] ?? '') ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label>Nominal</label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
            <input type="number" step="0.01" min="0" name="amount" value="<?= esc($deduction['amount'] ?? '0') ?>" class="form-control" required>
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
