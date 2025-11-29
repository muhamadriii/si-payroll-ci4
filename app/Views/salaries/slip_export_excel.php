<?php $bulanMap = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Slip Gaji</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 6px; }
    th { background: #f2f2f2; text-align: left; }
    .text-end { text-align: right; }
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
  <h3 style="margin:0">Slip Gaji</h3>
  <div style="margin:0 0 6px">Periode: <?= esc($bulanMap[$row['month']] ?? $row['month']) ?> <?= esc($row['year']) ?></div>
  <div style="margin:0 0 10px">Dicetak: <?= esc($printDate ?? date('Y-m-d')) ?></div>

  <table>
    <tbody>
      <tr><th style="width:25%">NIK</th><td><?= esc($row['nin']) ?></td></tr>
      <tr><th>Nama</th><td><?= esc($user['name'] ?? '-') ?></td></tr>
      <tr><th>Jabatan</th><td><?= esc($row['position_name'] ?? '-') ?></td></tr>
      <tr><th>Tanggal Masuk</th><td><?= esc($user['hire_date'] ?? '-') ?></td></tr>
      <tr><th>Ringkasan Absensi</th><td>Sakit: <?= esc((int) ($att['sick_days'] ?? 0)) ?>, Izin: <?= esc((int) ($att['leave_days'] ?? 0)) ?>, Alfa: <?= esc((int) ($att['absent_days'] ?? 0)) ?></td></tr>
    </tbody>
  </table>

  <br>

  <table>
    <tbody>
      <tr><th>Gaji Pokok</th><td class="text-end"><?= number_format($base, 2, ',', '.') ?></td></tr>
      <tr><th>Tunjangan Transport</th><td class="text-end"><?= number_format($trans, 2, ',', '.') ?></td></tr>
      <tr><th>Tunjangan Makan</th><td class="text-end"><?= number_format($meal, 2, ',', '.') ?></td></tr>
      <tr><th>Potongan</th><td class="text-end">-<?= number_format($ded, 2, ',', '.') ?></td></tr>
    </tbody>
  </table>

  <br>

  <table>
    <thead>
      <tr><th>Rincian Potongan</th><th class="text-end">Nominal</th></tr>
    </thead>
    <tbody>
      <tr><td>Sakit (<?= esc((int) ($att['sick_days'] ?? 0)) ?> × <?= number_format($deductionDetail['sakit']['nominal'] ?? 0, 2, ',', '.') ?>)</td><td class="text-end">-<?= number_format($deductionDetail['sakit']['amount'] ?? 0, 2, ',', '.') ?></td></tr>
      <tr><td>Izin (<?= esc((int) ($att['leave_days'] ?? 0)) ?> × <?= number_format($deductionDetail['izin']['nominal'] ?? 0, 2, ',', '.') ?>)</td><td class="text-end">-<?= number_format($deductionDetail['izin']['amount'] ?? 0, 2, ',', '.') ?></td></tr>
      <tr><td>Alfa (<?= esc((int) ($att['absent_days'] ?? 0)) ?> × <?= number_format($deductionDetail['alfa']['nominal'] ?? 0, 2, ',', '.') ?>)</td><td class="text-end">-<?= number_format($deductionDetail['alfa']['amount'] ?? 0, 2, ',', '.') ?></td></tr>
      <tr><th>Total Potongan</th><th class="text-end">-<?= number_format($deductionDetail['total'] ?? 0, 2, ',', '.') ?></th></tr>
    </tbody>
  </table>

  <br>

  <table>
    <tbody>
      <tr><th>Subtotal</th><td class="text-end"><?= number_format($subtotal, 2, ',', '.') ?></td></tr>
      <tr><th>Total Dibayarkan</th><td class="text-end"><?= number_format($row['total_salary'], 2, ',', '.') ?></td></tr>
    </tbody>
  </table>
</body>
</html>

