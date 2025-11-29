<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Profil<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Profil Pengguna<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Pengaturan / Profil<?= $this->endSection() ?>
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

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <img class="img-profile rounded-circle mb-3" style="width: 160px; height: 160px; object-fit: cover;" src="<?= esc((session()->get('profile_image') ? base_url(session()->get('profile_image')) : base_url('img/undraw_profile.svg'))) ?>">
        <div class="h5 mb-0"><?= esc($user['name'] ?? '') ?></div>
        <div class="text-muted">NIK: <?= esc($user['nin'] ?? '-') ?></div>
        <div class="text-muted">Role: <?= esc($user['role'] ?? '-') ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-header py-3 bg-primary text-white">
        <h6 class="mb-0">Ubah Profil</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?= site_url('profile/update') ?>" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= esc($user['username'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="<?= esc($user['name'] ?? '') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="gender" class="form-select form-control">
              <option value="" <?= empty($user['gender']) ? 'selected' : '' ?>>-</option>
              <option value="M" <?= ($user['gender'] ?? '') === 'M' ? 'selected' : '' ?>>Laki-laki</option>
              <option value="F" <?= ($user['gender'] ?? '') === 'F' ? 'selected' : '' ?>>Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="hire_date" class="form-control" value="<?= esc($user['hire_date'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Password Lama</label>
            <input type="password" name="current_password" class="form-control" placeholder="Wajib diisi jika mengubah password">
          </div>
          <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</div>
<?= $this->endSection() ?>
