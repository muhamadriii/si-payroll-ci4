<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Data Gaji Bulanan</title>
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #000; }
    .header { text-align: center; margin-bottom: 12px; }
    .company { font-size: 18px; font-weight: 700; }
    .title { font-size: 18px; font-weight: 600; }
    .subtitle { font-size: 12px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background: #f2f2f2; text-align: center; }
    .text-end { text-align: right; }
    .text-center { text-align: center; }
    .footer { margin-top: 24px; display: flex; justify-content: space-between; }
    .sign { width: 40%; text-align: center; }
    .sign-line { margin-top: 64px; }
  </style>
</head>
<body>
  <?php
    $bulanMap = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    $bm = $bulanMap[$month] ?? $month;
    $sumBase = 0.0; $sumTrans = 0.0; $sumMeal = 0.0; $sumDeduct = 0.0; $sumTotal = 0.0;
  ?>
  <div class="header">
    <div class="company">PT SINAR ABADI JAYA</div>
    <div class="title">LAPORAN GAJI BULANAN</div>
    <div class="subtitle">Periode: <?= esc($bm) ?> <?= esc($year) ?> &middot; Dicetak: <?= date('d/m/Y H:i') ?> &middot; Jumlah Data: <?= count($rows ?? []) ?></div>
  </div>
  <table>
    <thead>
      <tr>
        <th style="width:14%">NIK</th>
        <th style="width:20%">Jabatan</th>
        <th style="width:12%">Gaji Pokok</th>
        <th style="width:14%">Tunjangan Transport</th>
        <th style="width:12%">Tunjangan Makan</th>
        <th style="width:12%">Potongan</th>
        <th style="width:16%">Total</th>
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
          <td class="text-end"><?= number_format($b, 2, ',', '.') ?></td>
          <td class="text-end"><?= number_format($t, 2, ',', '.') ?></td>
          <td class="text-end"><?= number_format($m, 2, ',', '.') ?></td>
          <td class="text-end"><?= number_format($d, 2, ',', '.') ?></td>
          <td class="text-end"><?= number_format($tt, 2, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2" class="text-end">Total</th>
        <th class="text-end"><?= number_format($sumBase, 2, ',', '.') ?></th>
        <th class="text-end"><?= number_format($sumTrans, 2, ',', '.') ?></th>
        <th class="text-end"><?= number_format($sumMeal, 2, ',', '.') ?></th>
        <th class="text-end"><?= number_format($sumDeduct, 2, ',', '.') ?></th>
        <th class="text-end"><?= number_format($sumTotal, 2, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>

  <div class="footer">
    <div class="sign">
      <div>Disetujui</div>
      <div class="sign-line">__________________________</div>
    </div>
    <div class="sign">
      <div>Dibuat oleh</div>
      <div class="sign-line">__________________________</div>
    </div>
  </div>
</body>
</html>
