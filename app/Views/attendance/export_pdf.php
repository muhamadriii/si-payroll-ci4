<?php $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Absensi</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h3 { margin: 0 0 12px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #555; padding: 6px; }
    th { background: #f0f0f0; }
    .text-right { text-align: right; }
    .header-center { text-align: center; margin-bottom: 12px; }
    .company { font-size: 18px; font-weight: 700; }
    .doc-title { font-size: 14px; font-weight: 600; margin-top: 2px; }
    .subtitle { font-size: 12px; margin-top: 4px; }
  </style>
</head>
<body>
  <div class="header-center">
    <div class="company">PT SINAR ABADI JAYA</div>
    <div class="doc-title">LAPORAN ABSENSI</div>
    <div class="subtitle">Rekap Absensi Bulan <?= esc($months[$month] ?? $month) ?> <?= esc($year) ?></div>
  </div>
  <table>
    <thead>
      <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th class="text-right">Sakit</th>
        <th class="text-right">Izin</th>
        <th class="text-right">Alfa</th>
        <th class="text-right">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['nin']) ?></td>
          <td><?= esc($r['name']) ?></td>
          <td><?= esc($r['position_name']) ?></td>
          <td class="text-right"><?= esc($r['sick_days']) ?></td>
          <td class="text-right"><?= esc($r['leave_days']) ?></td>
          <td class="text-right"><?= esc($r['absent_days']) ?></td>
          <td class="text-right"><?= esc(($r['sick_days'] + $r['leave_days'] + $r['absent_days'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
