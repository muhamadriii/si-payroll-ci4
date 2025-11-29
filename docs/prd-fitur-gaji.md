# PRD — Fitur Gaji (Payroll Bulanan)

## Ringkasan
- Tujuan: Menghitung, menyimpan, dan menyajikan slip gaji bulanan untuk seluruh pegawai.
- Hasil utama: Hasil gaji bulanan, slip gaji, dan laporan agregat bulanan.

## Ruang Lingkup
- In-scope:
  - Kalkulasi gaji berbasis jabatan dan absensi bulanan.
  - Potongan berbasis jenis absensi (Sakit, Izin, Alfa).
  - Penyimpanan hasil gaji bulanan.
  - Slip gaji per pegawai (printable).
  - Guard hak akses (superadmin/employee).
- Out-of-scope (fase ini):
  - Pajak detail, lembur, tunjangan dinamis, integrasi bank/pembayaran.
  - Multi perusahaan atau multi mata uang.

## Peran & Hak Akses
- `superadmin`: kalkulasi massal, melihat semua slip, mengubah master potongan.
- `employee`: melihat slip dirinya sendiri; tidak dapat kalkulasi.

## Sumber Data & Dependensi
- Pegawai: tabel `users` (kolom kunci: `id`, `nin`, `position_id`, `role`, `hire_date`).
- Jabatan: tabel `positions` (`base_salary`, `transport_allowance`, `meal_allowance`).
- Absensi: tabel `attendance` (`user_id`, `month`, `year`, `sick_days`, `leave_days`, `absent_days`).
- Potongan: `salary_deductions` (master nominal untuk `Sakit`, `Izin`, `Alfa`).
- Hasil gaji: `salaries` (output per pegawai/bulan/tahun).

## Formula Perhitungan
- Pendapatan:
  - `base = positions.base_salary`
  - `transport = positions.transport_allowance`
  - `meal = positions.meal_allowance`
- Potongan absensi:
  - Ambil master nominal dari `salary_deductions` untuk `Sakit`, `Izin`, `Alfa`.
  - `pot_absen = (sick_days * nominal_sakit) + (leave_days * nominal_izin) + (absent_days * nominal_alfa)`
- Total:
  - `gross = base + transport + meal`
  - `deduction_amount = pot_absen + pot_lain (jika ada)`
  - `total_salary = gross - deduction_amount`

## Perilaku Perhitungan
- Hasil gaji dapat dihitung ulang untuk periode yang sama tanpa proses approve atau lock.

## Alur Pengguna
- `superadmin`:
  - Pilih bulan/tahun → klik “Hitung” → sistem upsert `salaries` hasil perhitungan.
  - Cetak/unduh slip gaji.
- `employee`:
  - Lihat slip gaji milik sendiri untuk periode tersedia.

## Kebutuhan Fungsional
- Kalkulasi massal untuk seluruh pegawai pada periode.
- Upsert `salaries` (hindari duplikasi per user/bulan/tahun).
- Slip gaji dengan ringkas komponen dan potongan.
- Filter dan daftar gaji per periode dengan DataTables client-side.

## Kebutuhan Non-Fungsional
- Performa: kalkulasi harus efisien untuk ratusan–ribuan pegawai.
- Keamanan: guard berdasarkan `role`; validasi input.
- Audit: log aktivitas kalkulasi dan akses slip.

## Perubahan Data Model
- Pastikan `salaries` memakai `nin` (bukan `employee_number`) di `validationRules`.
- Enum `users.role`: gunakan `employee` dan `superadmin` (lowercase), default `employee`.

## Desain UI/UX
- Halaman Gaji:
  - Filter `month`/`year`, tombol “Hitung” (POST), tabel hasil.
  - Kolom: `nin`, `position_name`, `gross`, `deduction_amount`, `total_salary`, aksi `Slip`.
- Slip gaji:
  - Ringkas komponen pendapatan, potongan, total, dan status.

## Controller & Routes (Implementasi)
- `Salaries` Controller:
  - `index(month, year)`: tampilkan daftar gaji.
  - `calculate(month, year)`: kalkulasi massal, upsert `draft`.
  - `slip(id)`: render view slip.
- Routes:
  - `GET /salaries`
  - `POST /salaries/calculate`
  - `GET /salaries/slip/(:segment)`

## Logging & Audit
- Log aksi: kalkulasi (periode, jumlah baris), akses/cetak slip.

## Testing & Kriteria Penerimaan
- Unit:
  - Tanpa absensi → total = base+transport+meal.
  - Absensi campuran → potongan sesuai nominal master.
  - Master potongan kosong → potongan = 0.
- Integrasi:
  - `calculate` menghasilkan draft tanpa duplikasi.
  - Slip menampilkan angka yang tepat.
- UAT:
  - Periode dengan ratusan pegawai selesai < 5 detik.
  - Perhitungan ulang periode yang sama akan menimpa hasil sebelumnya.

## Rencana Rollout
- Tambah controller/routes.
- Sinkron master potongan (Seeder: Sakit, Alfa, Izin).
- Migrasi enum roles ke `employee/superadmin` (lowercase).
- Pastikan `users` memiliki `position_id` valid.
- Uji di staging → deploy.

## Risiko & Mitigasi
- Data absensi tidak lengkap → anggap 0; berikan indikator di UI.
- Performa rendah untuk jumlah besar → batch processing & indeks DB.
- Inkonsistensi master potongan → validasi nama wajib (`Sakit`, `Izin`, `Alfa`).

## Catatan Implementasi
- DataTables client-side di halaman gaji; gunakan render angka terformat.
- Gunakan transaksi saat upsert massal ke `salaries`.
- Guard aksi berdasarkan `role` di controller (middleware `auth` + pemeriksaan role).
