<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Absensi Bulan<?= $this->endSection() ?>
<?= $this->section('title_page') ?>Edit Presensi<?= $this->endSection() ?>
<?= $this->section('breadcrumbs') ?>Transaksi / Absensi / Edit<?= $this->endSection() ?>
<?= $this->section('header_button') ?>
<div class="d-flex justify-content-end align-items-center mb-3">
  <a class="btn btn-secondary" href="<?= site_url('attendance?month=' . ($month ?? date('n')) . '&year=' . ($year ?? date('Y'))) ?>">Kembali</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-body">
    <form method="post" action="<?= site_url('attendance/update') ?>">
      <?= csrf_field() ?>
      <div class="form-row mb-3">
        <div class="form-group col-md-3">
          <label>Bulan</label>
          <select name="month" class="custom-select">
            <?php for ($m=1;$m<=12;$m++): ?>
              <option value="<?= $m ?>" <?= ($month ?? date('n'))==$m?'selected':'' ?>><?= date('F', mktime(0,0,0,$m,1)) ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label>Tahun</label>
          <select name="year" class="custom-select">
            <?php for ($y=date('Y')-2;$y<=date('Y')+2;$y++): ?>
              <option value="<?= $y ?>" <?= ($year ?? date('Y'))==$y?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped border" id="editAttendanceTable">
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
                <td><input type="number" name="sick_days[<?= esc($row['id']) ?>]" min="0" class="form-control" value="<?= (int)($row['sick_days'] ?? 0) ?>"></td>
                <td><input type="number" name="leave_days[<?= esc($row['id']) ?>]" min="0" class="form-control" value="<?= (int)($row['leave_days'] ?? 0) ?>"></td>
                <td><input type="number" name="absent_days[<?= esc($row['id']) ?>]" min="0" class="form-control" value="<?= (int)($row['absent_days'] ?? 0) ?>"></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer text-end bg-white border-0 px-0">
        <button class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function(){
  $('#editAttendanceTable').DataTable({
    pageLength: 10,
    lengthMenu: [10,25,50,100],
  });
});
</script>
<?= $this->endSection() ?>
