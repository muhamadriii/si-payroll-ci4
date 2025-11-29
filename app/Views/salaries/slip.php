<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Slip Gaji</title>
  <style>
    body { background: #f8f9fa; padding: 2rem; }
    .slip-card { max-width: 720px; margin: 0 auto; }
    .amount-negative { color: #dc3545; }
    @media print {
      body { background: #fff; padding: 0; }
      .btn-print { display: none; }
      .slip-card { box-shadow: none; border: 1px solid #dee2e6; }
    }
  </style>
  </head>
<body>
  <?php
    $base = (float) ($row['base_salary'] ?? 0);
    $trans = (float) ($row['transport_allowance'] ?? 0);
    $meal = (float) ($row['meal_allowance'] ?? 0);
    $ded  = (float) ($row['deduction_amount'] ?? 0);
    $subtotal = $base + $trans + $meal - $ded;
  ?>
  <div class="card shadow slip-card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <div class="h5 mb-0">Slip Gaji</div>
        <div class="text-muted small">Periode <?= esc($row['month']) ?>/<?= esc($row['year']) ?></div>
      </div>
      <span class="badge bg-secondary"><?= esc(strtoupper((string) ($row['status'] ?? 'draft'))) ?></span>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-8">
          <div class="text-muted small">Identitas Pegawai</div>
          <div class="fw-semibold mb-1"><?= esc(($user['name'] ?? '') !== '' ? $user['name'] : ($row['nin'] ?? '')) ?></div>
          <div class="row g-2">
            <div class="col-6"><span class="text-muted small">NIK</span><div><?= esc($row['nin']) ?></div></div>
            <div class="col-6"><span class="text-muted small">Tanggal Masuk</span><div><?= esc($user['hire_date'] ?? '-') ?></div></div>
          </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
          <div class="text-muted small">Ringkasan Absensi</div>
          <div>Sakit: <?= esc((int) ($att['sick_days'] ?? 0)) ?> | Izin: <?= esc((int) ($att['leave_days'] ?? 0)) ?> | Alfa: <?= esc((int) ($att['absent_days'] ?? 0)) ?></div>
        </div>
      </div>

      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <td>Gaji Pokok</td>
            <td class="text-end"><?= number_format($base, 2, ',', '.') ?></td>
          </tr>
          <tr>
            <td>Tunjangan Transport</td>
            <td class="text-end"><?= number_format($trans, 2, ',', '.') ?></td>
          </tr>
          <tr>
            <td>Tunjangan Makan</td>
            <td class="text-end"><?= number_format($meal, 2, ',', '.') ?></td>
          </tr>
          <tr>
            <td class="text-muted">Potongan</td>
            <td class="text-end amount-negative">-<?= number_format($ded, 2, ',', '.') ?></td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-sm mb-0">
                    <tbody>
                      <tr>
                        <td>Sakit (<?= esc((int) ($att['sick_days'] ?? 0)) ?> × <?= number_format($deductionDetail['sakit']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                        <td class="text-end amount-negative">-<?= number_format($deductionDetail['sakit']['amount'] ?? 0, 2, ',', '.') ?></td>
                      </tr>
                      <tr>
                        <td>Izin (<?= esc((int) ($att['leave_days'] ?? 0)) ?> × <?= number_format($deductionDetail['izin']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                        <td class="text-end amount-negative">-<?= number_format($deductionDetail['izin']['amount'] ?? 0, 2, ',', '.') ?></td>
                      </tr>
                      <tr>
                        <td>Alfa (<?= esc((int) ($att['absent_days'] ?? 0)) ?> × <?= number_format($deductionDetail['alfa']['nominal'] ?? 0, 2, ',', '.') ?>)</td>
                        <td class="text-end amount-negative">-<?= number_format($deductionDetail['alfa']['amount'] ?? 0, 2, ',', '.') ?></td>
                      </tr>
                      <tr class="table-light">
                        <td class="fw-semibold">Total Potongan</td>
                        <td class="text-end fw-semibold amount-negative">-<?= number_format($deductionDetail['total'] ?? 0, 2, ',', '.') ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </td>
          </tr>
          <tr class="table-light">
            <td class="fw-semibold">Subtotal</td>
            <td class="text-end fw-semibold"><?= number_format($subtotal, 2, ',', '.') ?></td>
          </tr>
          <tr class="table-primary">
            <td class="fw-bold">Total Dibayarkan</td>
            <td class="text-end fw-bold"><?= number_format($row['total_salary'], 2, ',', '.') ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-outline-primary btn-print" onclick="window.print()">Cetak</button>
    </div>
  </div>
</body>
</html>
