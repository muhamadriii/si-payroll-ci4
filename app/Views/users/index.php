<?= $this->extend('layouts/admin') ?>

<?= $this->section('title_page') ?><?= esc($title ?? 'Pegawai') ?><?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Master Data / <?= esc($title ?? 'Pegawai') ?><?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<a class="btn btn-primary" href="<?= site_url('users/create') ?>">Tambah Pegawai</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <table id="usersTable" class="table table-striped border" style="width:100%">
      <thead>
        <tr>
          <th>Foto</th>
          <th>NIK</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Masuk</th>
          <th>Jabatan</th>
          <th>Hak Akses</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($rows ?? []) as $row): ?>
          <tr>
            <td>
              <img src="<?= base_url(!empty($row['profile_image']) ? $row['profile_image'] : 'img/undraw_profile.svg') ?>" alt="Foto <?= esc($row['name']) ?>" class="js-user-photo" data-name="<?= esc($row['name']) ?>" style="width:40px;height:40px;border-radius:50%;object-fit:cover;cursor:pointer">
            </td>
            <td><?= esc($row['nin']) ?></td>
            <td><?= esc($row['username']) ?></td>
            <td><?= esc($row['name']) ?></td>
            <td><?= $row['gender'] === 'M' ? 'Laki-laki' : 'Perempuan' ?></td>
            <td><?= esc($row['hire_date']) ?></td>
            <td><?= esc(($positionsById[$row['position_id']] ?? '-')) ?></td>
            <td>
              <?= esc($row['role'] === 'employee' ? 'Pegawai' : ($row['role'] === 'superadmin' ? 'Administrator' : ucfirst(strtolower($row['role'] ?? '')))) ?>
            </td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-primary" href="<?= site_url('users/' . $row['id'] . '/edit') ?>">Edit</a>
              <form method="post" action="<?= site_url('users/' . $row['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus pegawai?')">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalTitle">Foto Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="photoModalImg" src="" alt="Foto" style="max-width:100%;height:auto;border-radius:8px">
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(function() {
    $('#usersTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
    });

    $('#usersTable').on('click', '.js-user-photo', function(e) {
      e.preventDefault();
      var src = $(this).attr('src');
      var name = $(this).data('name') || 'Pegawai';
      $('#photoModalTitle').text(name);
      $('#photoModalImg').attr('src', src).attr('alt', 'Foto ' + name);
      $('#photoModal').modal('show');
    });
  });
</script>
<?= $this->endSection() ?>