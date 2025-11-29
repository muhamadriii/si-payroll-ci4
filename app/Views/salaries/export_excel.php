<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Data Gaji Bulanan</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    body { font-family: Arial, Helvetica, sans-serif; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 6px; }
    th { background: #f2f2f2; text-align: center; }
    .text-end { text-align: right; }
    .nowrap { white-space: nowrap; }
    .num { mso-number-format:"#,##0.00"; }
  </style>
</head>
<body>
  <?php
    $bulanMap = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    $bm = $bulanMap[$month] ?? $month;
    $sumBase = 0.0; $sumTrans = 0.0; $sumMeal = 0.0; $sumDeduct = 0.0; $sumTotal = 0.0;
  ?>
  <h3 style="margin:0">Laporan Data Gaji Bulanan</h3>
  <div style="margin:0 0 6px">Periode: <?= esc($bm) ?> <?= esc($year) ?></div>
  <div style="margin:0 0 10px">Dicetak: <?= date('d/m/Y H:i') ?> &middot; Jumlah Data: <?= count($rows ?? []) ?></div>
  <table>
    <thead>
      <tr>
        <th class="nowrap">NIK</th>
        <th>Jabatan</th>
        <th class="nowrap">Gaji Pokok</th>
        <th class="nowrap">Tunjangan Transport</th>
        <th class="nowrap">Tunjangan Makan</th>
        <th>Potongan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach (($rows ?? []) as $r): ?>
        <?php
          $b = (float) ($r['base_salary'] ?? 0);
          $t = (float) ($r['transport_allowance'] ?? 0);
          $m = (float) ($r['meal_allowance'] ?? 0);
          $d = (float) ($r['deduction_amount'] ?? 0);
          $tt = (float) ($r['total_salary'] ?? 0);
          $sumBase += $b; $sumTrans += $t; $sumMeal += $m; $sumDeduct += $d; $sumTotal += $tt;
        ?>
        <tr>
          <td><?= esc($r['nin'] ?? '') ?></td>
          <td><?= esc($r['position_name'] ?? '') ?></td>
          <td class="text-end num"><?= number_format($b, 2, '.', '') ?></td>
          <td class="text-end num"><?= number_format($t, 2, '.', '') ?></td>
          <td class="text-end num"><?= number_format($m, 2, '.', '') ?></td>
          <td class="text-end num"><?= number_format($d, 2, '.', '') ?></td>
          <td class="text-end num"><?= number_format($tt, 2, '.', '') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2" class="text-end">Total</th>
        <th class="text-end num"><?= number_format($sumBase, 2, '.', '') ?></th>
        <th class="text-end num"><?= number_format($sumTrans, 2, '.', '') ?></th>
        <th class="text-end num"><?= number_format($sumMeal, 2, '.', '') ?></th>
        <th class="text-end num"><?= number_format($sumDeduct, 2, '.', '') ?></th>
        <th class="text-end num"><?= number_format($sumTotal, 2, '.', '') ?></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
