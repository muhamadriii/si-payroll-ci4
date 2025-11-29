<?php $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember']; ?>
<html>
<head>
  <meta charset="utf-8">
  <title>Absensi <?= sprintf('%02d/%04d', (int) $month, (int) $year) ?></title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
    th { background: #eee; }
  </style>
</head>
<body>
  <h3>Rekap Absensi Bulan <?= esc($months[$month] ?? $month) ?> <?= esc($year) ?></h3>
  <table>
    <thead>
      <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Sakit</th>
        <th>Izin</th>
        <th>Alfa</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= esc($r['nin']) ?></td>
          <td><?= esc($r['name']) ?></td>
          <td><?= esc($r['position_name']) ?></td>
          <td><?= esc($r['sick_days']) ?></td>
          <td><?= esc($r['leave_days']) ?></td>
          <td><?= esc($r['absent_days']) ?></td>
          <td><?= esc(($r['sick_days'] + $r['leave_days'] + $r['absent_days'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>

