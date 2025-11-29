<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Jabatan<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Jabatan<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Master Data / Jabatan<?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-end align-items-center mb-3">
  <a class="btn btn-primary" href="<?= site_url('positions/create') ?>">Tambah Jabatan</a>
</div>
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
    <table id="positionsTable" class="table table-striped border border-x" style="width:100%">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Gaji Pokok</th>
          <th>Tunj. Transport</th>
          <th>Tunj. Makan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($rows ?? []) as $row): ?>
          <tr>
            <td><?= esc($row['name']) ?></td>
            <td><?= number_format($row['base_salary'], 2, ',', '.') ?></td>
            <td><?= number_format($row['transport_allowance'], 2, ',', '.') ?></td>
            <td><?= number_format($row['meal_allowance'], 2, ',', '.') ?></td>
            <td class="text-nowrap">
              <a class="btn btn-sm btn-outline-primary" href="<?= site_url('positions/' . $row['id'] . '/edit') ?>">Edit</a>
              <form method="post" action="<?= site_url('positions/' . $row['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Hapus jabatan?')">
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(function() {
    $('#positionsTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
    });
  });
</script>
<?= $this->endSection() ?>
