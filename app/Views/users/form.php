<?= $this->extend('layouts/admin') ?>

<?= $this->section('title_page') ?> <?= $mode === 'create' ? 'Tambah' : 'Ubah' ?> <?= esc($title ?? 'Pegawai') ?><?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Master Data / <?= esc($title ?? 'Pegawai') ?><?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <a class="btn btn-secondary" href="<?= site_url('users') ?>">Kembali</a>
</div>
<?php $this->endsection('header_button') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <span class="fw-bold">Form <?= $mode === 'create' ? 'Tambah' : 'Ubah' ?> Pegawai</span>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="<?= $mode === 'create' ? site_url('users/store') : site_url('users/' . $user['id'] . '/update') ?>">
      <?= csrf_field() ?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>NIK</label>
          <div class="input-group">
            <input type="text" name="nin" value="<?= esc($user['nin'] ?? '') ?>" class="form-control" required>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label>Nama</label>
          <input type="text" name="name" value="<?= esc($user['name'] ?? '') ?>" class="form-control" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Username</label>
          <input type="text" name="username" value="<?= esc($user['username'] ?? '') ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label>Password</label>
          <input type="password" name="password" class="form-control" <?= $mode === 'create' ? 'required' : '' ?>>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Jenis Kelamin</label>
          <?php $gender = $user['gender'] ?? 'M'; ?>
          <select name="gender" class="custom-select" required>
            <option value="M" <?= $gender === 'M' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="F" <?= $gender === 'F' ? 'selected' : '' ?>>Perempuan</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Tanggal Masuk</label>
          <input type="date" name="hire_date" value="<?= esc($user['hire_date'] ?? '') ?>" class="form-control" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Jabatan</label>
          <select name="position_id" class="custom-select">
            <?php foreach ($positions as $p): ?>
              <option value="<?= esc($p['id']) ?>" <?= isset($user['position_id']) && $user['position_id'] === $p['id'] ? 'selected' : '' ?>><?= esc($p['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Hak Akses</label>
          <?php $role = $user['role'] ?? 'employee'; ?>
          <select name="role" class="custom-select" required>
            <option value="superadmin" <?= $role === 'superadmin' ? 'selected' : '' ?>>Admintrator</option>
            <option value="employee" <?= $role === 'employee' ? 'selected' : '' ?>>Pegawai</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Foto Profil</label>
          <input type="file" name="profile_image" accept="image/*" class="form-control">
          <?php if (!empty($user['profile_image'])): ?>
            <div class="mt-2">
              <img src="<?= base_url($user['profile_image']) ?>" alt="Foto" style="height:80px;border-radius:8px;object-fit:cover">
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-footer text-end bg-white border-0 px-0 d-flex justify-content-end">
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>