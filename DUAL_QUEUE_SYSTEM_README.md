# Sistem Antrian Dual Source - QueueBank ProMax

Sistem antrian yang bekerja untuk dua sumber sekaligus: **Desktop (Mesin Antrian)** dan **Mobile (Web HP)** dengan satu jalur antrian terpusat.

## 🎯 Fitur Utama

### Desktop (Mesin Antrian)
- ✅ Setiap klik tombol selalu menghasilkan nomor baru
- ✅ Interface khusus untuk mesin antrian
- ✅ Tidak menyimpan session device
- ✅ Statistik real-time
- ✅ Fitur cetak nomor antrian

### Mobile (Web HP)
- ✅ Satu device hanya boleh punya satu nomor aktif
- ✅ Nomor tetap ada meski halaman di-refresh
- ✅ Deteksi otomatis device mobile
- ✅ Cek status antrian real-time
- ✅ Interface responsive untuk mobile

### Sistem Terpusat
- ✅ Semua nomor antrian dalam satu jalur
- ✅ Database terpusat
- ✅ Nomor berurutan otomatis
- ✅ Statistik real-time

## 🏗️ Struktur Database

### Tabel `antrians` (Updated)
```sql
-- Field baru yang ditambahkan:
device_type ENUM('desktop', 'mobile') DEFAULT 'desktop'
device_id VARCHAR(255) NULL
user_agent TEXT NULL
ip_address VARCHAR(45) NULL
```

### Migration
```bash
# Jalankan migration untuk menambah field baru
php spark migrate
```

## 📁 Struktur File

```
app/
├── Controllers/
│   ├── AntrianController.php      # Controller utama (mobile + desktop)
│   └── DesktopController.php      # Controller khusus desktop
├── Models/
│   └── AntrianModel.php           # Model dengan method baru
├── Views/
│   ├── antrian/
│   │   └── index.php              # View mobile (updated)
│   └── desktop/
│       └── index.php              # View desktop baru
├── Helpers/
│   └── DeviceHelper.php           # Helper deteksi device
└── Config/
    ├── Routes.php                  # Routes baru
    └── Autoload.php               # Helper autoload
```

## 🚀 Cara Penggunaan

### 1. Desktop (Mesin Antrian)
```
URL: /desktop
- Pilih kategori layanan
- Klik "Ambil Nomor Antrian"
- Setiap klik = nomor baru
- Fitur cetak tersedia
```

### 2. Mobile (Web HP)
```
URL: / (atau /antrian)
- Deteksi otomatis device mobile
- Pilih kategori layanan
- Jika sudah punya nomor aktif = tampilkan nomor lama
- Jika belum = buat nomor baru
- Refresh halaman untuk cek status
```

## 🔧 Konfigurasi

### 1. Jalankan Migration
```bash
php spark migrate
```

### 2. Pastikan Helper Ter-load
File `app/Config/Autoload.php` sudah otomatis menambahkan:
```php
public $helpers = ['DeviceHelper'];
```

### 3. Routes Otomatis Terdaftar
```php
// Desktop Routes
$routes->get('desktop', 'DesktopController::index');
$routes->post('desktop/ambilNomorDesktop', 'DesktopController::ambilNomorDesktop');
$routes->get('desktop/getStatistikHarian', 'DesktopController::getStatistikHarian');

// Mobile Routes
$routes->get('cek-status-mobile', 'AntrianController::cekStatusMobile');
$routes->get('statistik-antrian', 'AntrianController::getStatistikAntrian');
```

## 📱 Deteksi Device

### Helper Functions
```php
// Deteksi tipe device
$device_type = detect_device_type(); // 'mobile' atau 'desktop'

// Generate device ID untuk mobile
$device_id = generate_device_id(); // null untuk desktop

// Get client IP
$ip_address = get_client_ip();
```

### Logic Deteksi
- **Mobile**: Android, iPhone, iPad, Windows Phone, BlackBerry, Opera Mini, IEMobile, Mobile Safari
- **Desktop**: Semua device lain (PC, laptop, tablet landscape)

## 🔄 Flow Sistem

### Desktop Flow
```
1. User buka /desktop
2. Pilih kategori
3. Klik "Ambil Nomor"
4. Generate nomor baru (selalu)
5. Simpan ke database (device_type: desktop)
6. Tampilkan modal hasil
7. Fitur cetak tersedia
```

### Mobile Flow
```
1. User buka / (mobile)
2. Deteksi device = mobile
3. Generate device_id (session-based)
4. Cek apakah sudah punya nomor aktif
5. Jika YA = tampilkan nomor lama
6. Jika TIDAK = buat nomor baru
7. Simpan ke database (device_type: mobile, device_id: xxx)
8. Tampilkan status real-time
```

## 📊 API Endpoints

### Desktop
- `GET /desktop` - Interface mesin antrian
- `POST /desktop/ambilNomorDesktop` - Ambil nomor baru
- `GET /desktop/getStatistikHarian` - Statistik real-time

### Mobile
- `GET /` - Interface mobile
- `POST /ambil-nomor` - Ambil/cek nomor antrian
- `GET /cek-status-mobile` - Cek status antrian mobile
- `GET /cek-status/{nomor}` - Cek status nomor tertentu
- `GET /statistik-antrian` - Statistik antrian

## 🎨 Interface

### Desktop Interface
- Design khusus mesin antrian
- Tombol besar dan jelas
- Statistik real-time
- Modal hasil dengan fitur cetak
- Responsive untuk touch screen

### Mobile Interface
- Design mobile-first
- Tampilan nomor antrian aktif
- Refresh status real-time
- Interface yang user-friendly
- Fitur cetak untuk mobile

## 🔒 Keamanan

- Device ID unik untuk mobile
- Session-based tracking
- IP address logging
- User agent logging
- Validasi input kategori

## 📈 Monitoring

### Logs
- Semua aktivitas di-log
- Device type tracking
- Error handling
- Performance monitoring

### Statistics
- Total antrian per kategori
- Antrian sedang dipanggil
- Real-time updates
- Historical data

## 🚨 Troubleshooting

### Common Issues

1. **Helper tidak ter-load**
   - Pastikan `DeviceHelper` ada di `app/Helpers/`
   - Cek `app/Config/Autoload.php`

2. **Migration error**
   - Pastikan database connection
   - Cek struktur tabel existing

3. **Device detection tidak akurat**
   - Test dengan berbagai user agent
   - Cek helper function

4. **Session mobile tidak persist**
   - Cek session configuration
   - Pastikan cookies enabled

### Debug Mode
```php
// Enable debug di .env
CI_ENVIRONMENT = development

// Cek logs di writable/logs/
```

## 🔄 Update & Maintenance

### Regular Tasks
- Monitor log files
- Check database performance
- Update device detection patterns
- Backup session data

### Version Updates
- Backup database
- Test migration
- Update helper functions
- Verify device detection

## 📞 Support

Untuk bantuan teknis atau pertanyaan:
- Cek log files
- Review database queries
- Test device detection
- Verify session handling

---

**QueueBank ProMax** - Sistem Antrian Modern & Profesional
*Dual Source Queue System v1.0*
