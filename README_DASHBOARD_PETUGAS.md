# Dashboard Petugas Berdasarkan Kategori - QueueBank ProMax

## Overview
Sistem QueueBank ProMax menyediakan dashboard petugas yang dapat disesuaikan berdasarkan kategori layanan. Setiap kategori memiliki tampilan dan fitur yang spesifik sesuai dengan kebutuhan layanan tersebut.

## Kategori Layanan yang Tersedia

### 1. Dashboard Teller
- **File**: `app/Views/petugas/dashboard_teller.php`
- **Route**: `/petugas/dashboard/{kategori_id}` (untuk kategori yang mengandung kata "teller")
- **Fitur**:
  - Statistik antrian (menunggu, dipanggil, selesai, lewati)
  - Daftar antrian aktif dengan estimasi waktu
  - Modal panggil antrian dengan pilihan jenis transaksi
  - Aksi cepat: panggil berikutnya, laporan, set break
  - Info teller (status, loket, jam kerja, target)

### 2. Dashboard Customer Service
- **File**: `app/Views/petugas/dashboard_cs.php`
- **Route**: `/petugas/dashboard/{kategori_id}` (untuk kategori yang mengandung kata "cs" atau "customer")
- **Fitur**:
  - Statistik antrian
  - Daftar antrian aktif dengan estimasi waktu
  - Modal panggil antrian dengan pilihan jenis layanan
  - Aksi cepat: panggil berikutnya, laporan, set break
  - Info CS (status, loket, jam kerja, target)

### 3. Dashboard Layanan Prioritas
- **File**: `app/Views/petugas/dashboard_prioritas.php`
- **Route**: `/petugas/dashboard/{kategori_id}` (untuk kategori yang mengandung kata "prioritas")
- **Fitur**:
  - Statistik antrian
  - Daftar antrian prioritas dengan estimasi waktu cepat
  - Modal panggil antrian dengan level prioritas
  - Aksi cepat: panggil berikutnya, laporan, set level prioritas
  - Info layanan prioritas (status, loket, jam kerja, target, estimasi)

### 4. Dashboard Umum
- **File**: `app/Views/petugas/dashboard.php`
- **Route**: `/petugas/dashboard` (default) atau untuk kategori lain
- **Fitur**:
  - Pemilihan kategori layanan
  - Statistik berdasarkan kategori yang dipilih
  - Daftar antrian aktif dan sedang dipanggil
  - Modal panggil antrian standar

## Struktur File

```
app/
├── Controllers/
│   └── PetugasController.php          # Controller utama petugas
├── Models/
│   ├── AntrianModel.php               # Model antrian
│   └── KategoriAntrianModel.php      # Model kategori
├── Views/
│   └── petugas/
│       ├── dashboard.php              # Dashboard umum
│       ├── dashboard_teller.php       # Dashboard teller
│       ├── dashboard_cs.php           # Dashboard CS
│       └── dashboard_prioritas.php    # Dashboard prioritas
└── Config/
    └── Routes.php                     # Routing
```

## Cara Penggunaan

### 1. Akses Dashboard
- **Dashboard Umum**: `/petugas/dashboard`
- **Dashboard Kategori**: `/petugas/dashboard/{kategori_id}`

### 2. Pemilihan Kategori
Dashboard umum menampilkan kartu kategori yang dapat diklik untuk beralih ke dashboard spesifik.

### 3. Fitur Utama
- **Panggil Antrian**: Klik tombol "Panggil" pada antrian yang menunggu
- **Selesai Antrian**: Tandai antrian yang sedang dilayani sebagai selesai
- **Lewati Antrian**: Lewati antrian yang sedang dilayani
- **Refresh**: Update data secara manual atau otomatis setiap 30 detik

## API Endpoints

### 1. Get Antrian by Kategori
```
GET /petugas/get-antrian-by-kategori/{kategori_id}
```
Response:
```json
{
  "success": true,
  "antrian_aktif": [...],
  "antrian_dipanggil": [...],
  "stats": {...}
}
```

### 2. Get Dashboard Summary
```
GET /petugas/get-dashboard-summary
```
Response:
```json
{
  "success": true,
  "summary": [
    {
      "kategori": {...},
      "stats": {...},
      "total": 0
    }
  ]
}
```

### 3. Get Kategori Info
```
GET /petugas/get-kategori-info
```
Response:
```json
{
  "success": true,
  "kategori": [...]
}
```

## Fitur Khusus Setiap Dashboard

### Dashboard Teller
- Estimasi waktu: 5 menit per antrian
- Jenis transaksi: setoran, penarikan, transfer, lainnya
- Target: 50 transaksi per hari
- Warna tema: hijau

### Dashboard Customer Service
- Estimasi waktu: 10 menit per antrian
- Jenis layanan: konsultasi, keluhan, informasi, lainnya
- Target: 30 layanan per hari
- Warna tema: biru

### Dashboard Prioritas
- Estimasi waktu: 3-5 menit per antrian
- Level prioritas: Level 1 (sangat prioritas), Level 2 (prioritas), Level 3 (standar)
- Target: 20 layanan per hari
- Warna tema: kuning/orange

## Auto-Refresh
Semua dashboard memiliki fitur auto-refresh setiap 30 detik untuk memastikan data selalu up-to-date.

## Notifikasi
Menggunakan SweetAlert2 untuk notifikasi yang lebih user-friendly dan menarik.

## Responsive Design
Semua dashboard responsive dan dapat diakses dari berbagai ukuran layar (desktop, tablet, mobile).

## Customization
Dashboard dapat dengan mudah dikustomisasi dengan:
- Mengubah warna tema
- Menambah fitur baru
- Mengubah layout
- Menambah validasi
- Mengintegrasikan dengan sistem lain

## Troubleshooting

### 1. Dashboard tidak muncul
- Pastikan user sudah login
- Periksa role user (harus petugas)
- Periksa route yang diakses

### 2. Data tidak ter-update
- Periksa koneksi database
- Periksa method di controller
- Periksa JavaScript console untuk error

### 3. Modal tidak muncul
- Pastikan Bootstrap JS sudah dimuat
- Periksa ID modal
- Periksa JavaScript function

## Future Enhancement
- [ ] Integrasi dengan sistem notifikasi real-time
- [ ] Dashboard analytics yang lebih detail
- [ ] Export laporan ke PDF/Excel
- [ ] Integrasi dengan sistem absensi
- [ ] Dashboard mobile app
- [ ] Multi-language support
- [ ] Dark mode theme
- [ ] Customizable dashboard layout
