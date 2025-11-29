# Web Payroll (CodeIgniter 4) — Panduan Setup & Instalasi

## Prasyarat
- PHP `>= 8.1` dan Composer
- MySQL/MariaDB
- Ekstensi PHP: `intl`, `mbstring`, `json`, `curl`, `mysqlnd`

## Instalasi
- Jalankan `composer install`
- Salin file `env` menjadi `.env`
- Atur konfigurasi dasar di `.env`:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = web_payroll
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
database.default.port = 3306

encryption.key = base64:GENERATE_WITH_SPARK
```

- Generate encryption key: `php spark key:generate` lalu salin nilainya ke `encryption.key`
- Buat database sesuai nama di `.env`
- Jika tersedia migrasi: jalankan `php spark migrate`

## Menjalankan
- Jalankan server pengembangan: `php spark serve`
- Buka `http://localhost:8080/`

## Dependensi PDF
- Library PDF sudah ditambahkan: `dompdf/dompdf` (lihat `composer.json:12-16`)
- Pastikan `composer install` selesai tanpa error

## Fitur & Rute Utama
- Landing: `/` (redirect ke dashboard bila sudah login)
- Autentikasi: `/login`, `/logout`
- Dashboard: `/dashboard`
- Master: `/users`, `/positions`, `/deductions`
- Absensi: `/attendance`
- Laporan Absensi: `/attendance/report`, ekspor: `/attendance/export?format=excel|pdf`
- Data Gaji: `/salaries`
- Laporan Gaji: `/salaries/report`, ekspor: `/salaries/export?format=excel|pdf`
- Laporan Slip Gaji: `/salaries/slip-report` (pilih pegawai/bulan/tahun/tanggal), ekspor: `/salaries/slip-export?format=excel|pdf&user_id=...&month=...&year=...&date=...`
- Slip Gaji per entri: `/salaries/slip/{id}`

Rujukan rute: `app/Config/Routes.php:8`–`51`.

## Header Perusahaan pada PDF
- Nama perusahaan ditampilkan di header PDF: `PT SINAR ABADI JAYA`
- Ubah pada:
  - Laporan Absensi: `app/Views/attendance/export_pdf.php:17`–`21`
  - Laporan Gaji: `app/Views/salaries/export_pdf.php:27`–`30`
  - Slip Gaji: `app/Views/salaries/slip_export_pdf.php:27`–`31`

## Kebijakan Akses
- Halaman berfilter membutuhkan login; jika belum login akan diarahkan ke landing
- Rujukan: `app/Filters/AuthFilter.php:11`–`21`

## Testing
- Jalankan unit test: `composer test` atau `vendor/bin/phpunit`

## Deployment (Produksi)
- Set `CI_ENVIRONMENT = production`
- Atur `app.baseURL` ke domain produksi
- Arahkan web server ke folder `public/`
- Pastikan `encryption.key` terisi dan rahasiakan konfigurasi `.env`

## Troubleshooting
- PDF kosong atau font tidak terlihat: pastikan `dompdf` terpasang dan gunakan font `DejaVu Sans`
- Akses ditolak: pastikan sudah login atau sesi masih aktif
