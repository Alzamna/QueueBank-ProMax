# QueueBank ProMax - Dual Queue System

## Overview
QueueBank ProMax adalah sistem antrian digital yang mendukung dua jenis antarmuka: Desktop dan Mobile. Sistem ini dirancang untuk memberikan pengalaman yang optimal baik untuk pengguna desktop maupun mobile.

## Fitur Utama

### 1. Dual Interface System
- **Desktop Interface**: Antarmuka lengkap untuk komputer desktop
- **Mobile Interface**: Antarmuka responsif untuk perangkat mobile

### 2. Real-time Queue Management
- Pengambilan nomor antrian real-time
- Monitoring status antrian
- Statistik antrian live

### 3. Multi-category Queue System
- Mendukung multiple kategori antrian
- Prefix kustom untuk setiap kategori
- Status aktif/nonaktif per kategori

### 4. Device-based Queue Tracking
- Tracking berdasarkan device ID
- Mencegah pengambilan ganda dalam satu hari
- Reset otomatis setiap hari

## Reset Antrian Harian

### Logika Reset
Sistem secara otomatis mereset nomor antrian setiap hari dengan logika berikut:

1. **Nomor Antrian**: Reset ke 001 setiap hari baru
   - Format: `{PREFIX}001`, `{PREFIX}002`, dst
   - Contoh: `T001`, `T002`, `C001`, `C002`

2. **Pengecekan Antrian Aktif**: Hanya mengecek antrian hari ini
   - User tidak bisa mengambil antrian ganda dalam satu hari
   - Setiap hari baru, user bisa mengambil antrian baru

3. **Statistik**: Hanya menampilkan data hari ini
   - Total antrian hari ini
   - Antrian yang dipanggil hari ini
   - Antrian yang menunggu hari ini

### Method yang Diperbaiki

#### AntrianModel
- `getNextNomorAntrian()`: Sudah mendukung reset harian
- `getAntrianAktifMobile()`: Hanya mengecek antrian hari ini
- `getPosisiAntrian()`: Posisi berdasarkan antrian hari ini
- `getTotalAntrianAktif()`: Total antrian hari ini
- `getAntrianDipanggilHariIni()`: Antrian dipanggil hari ini
- `getTodaySummary()`: Summary lengkap hari ini
- `cleanupOldAntrian()`: Maintenance data lama

#### AntrianController
- `ambilNomor()`: Pengecekan antrian aktif hari ini
- `cekStatusMobile()`: Status antrian hari ini
- `getStatistikAntrian()`: Statistik hari ini
- `getTodaySummary()`: Summary hari ini
- `cleanupOldData()`: Maintenance endpoint

## API Endpoints

### Queue Management
- `POST /ambil-nomor` - Ambil nomor antrian
- `GET /cek-status/{id}` - Cek status antrian
- `GET /cek-status-mobile` - Cek status mobile
- `GET /statistik-antrian` - Statistik antrian hari ini
- `GET /today-summary` - Summary lengkap hari ini

### Maintenance
- `GET /cleanup-old-data?days=30` - Bersihkan data lama

## Database Structure

### Antrians Table
```sql
- id (Primary Key)
- nomor_antrian (VARCHAR, unique)
- kategori_id (Foreign Key)
- loket_id (Foreign Key, nullable)
- petugas_id (Foreign Key, nullable)
- status (ENUM: menunggu, dipanggil, selesai, lewati)
- waktu_ambil (DATETIME)
- waktu_panggil (DATETIME, nullable)
- waktu_selesai (DATETIME, nullable)
- device_type (ENUM: desktop, mobile)
- device_id (VARCHAR, nullable)
- user_agent (TEXT, nullable)
- ip_address (VARCHAR, nullable)
- created_at (DATETIME)
- updated_at (DATETIME)
```

## Mobile Interface Features

### Responsive Design
- Optimized untuk mobile devices
- Landscape dan portrait mode support
- Touch-friendly interface

### Persistent Storage
- Menyimpan nomor antrian di localStorage
- Auto-recovery jika halaman di-refresh
- Expired setelah 24 jam

### Real-time Updates
- Update statistik setiap 30 detik
- Update posisi antrian setiap 30 detik
- Timestamp update terakhir

## Desktop Interface Features

### Full-featured Interface
- Interface lengkap untuk desktop
- Multiple kategori support
- Advanced statistics

### Print Support
- Print nomor antrian
- Custom print layout
- Print preview

## Security Features

### Device Tracking
- Unique device ID generation
- IP address logging
- User agent tracking

### Session Management
- Session-based device ID
- Automatic cleanup
- Secure data handling

## Maintenance

### Data Cleanup
- Otomatis hapus data lama (30 hari default)
- Configurable retention period
- Safe deletion (hanya data selesai/lewati)

### Performance Optimization
- Indexed queries untuk performa
- Efficient date-based filtering
- Optimized joins

## Installation & Setup

1. Clone repository
2. Install dependencies: `composer install`
3. Configure database di `app/Config/Database.php`
4. Run migrations: `php spark migrate`
5. Run seeders: `php spark db:seed`
6. Configure web server

### Migration untuk Reset Antrian Harian

Setelah setup awal, jalankan migration tambahan untuk mendukung reset antrian harian:

```bash
# Jalankan migration untuk update constraint nomor antrian
php spark migrate --path app/Database/Migrations/2024_01_01_000007_update_nomor_antrian_constraint.php
```

Migration ini akan:
- Menghapus unique constraint global pada `nomor_antrian`
- Menambahkan unique constraint pada kombinasi `nomor_antrian` dan `DATE(waktu_ambil)`
- Memungkinkan nomor antrian yang sama di hari berbeda

## Usage

### Mobile Users
1. Akses `/antrian/mobile`
2. Pilih kategori layanan
3. Klik "Ambil Nomor Antrian"
4. Tunggu panggilan

### Desktop Users
1. Akses `/antrian/desktop`
2. Pilih kategori layanan
3. Klik "Ambil Nomor"
4. Print atau simpan nomor

### Petugas
1. Login ke `/petugas/dashboard`
2. Panggil antrian berikutnya
3. Update status antrian

### Admin
1. Login ke `/admin/dashboard`
2. Kelola kategori, loket, dan pengguna
3. Monitor statistik dan laporan

## Troubleshooting

### Common Issues
1. **Nomor antrian tidak reset**: Pastikan server timezone benar
2. **Mobile tidak bisa ambil antrian**: Cek device ID generation
3. **Statistik tidak update**: Cek real-time update interval

### Debug Mode
- Enable debug logging di `app/Config/Logger.php`
- Check log files di `writable/logs/`
- Use `/antrian/test` endpoint untuk testing

## Contributing

1. Fork repository
2. Create feature branch
3. Make changes
4. Test thoroughly
5. Submit pull request

## License

This project is licensed under the MIT License.
