# QueueBank ProMax - Sistem Antrian Digital untuk Bank

## 🏦 Deskripsi Sistem

QueueBank ProMax adalah sistem antrian digital modern yang dirancang khusus untuk institusi perbankan. Sistem ini mendukung dual-source antrian: mesin antrian desktop di lokasi bank dan aplikasi mobile untuk pengguna yang ingin mengambil antrian dari smartphone mereka.

## ✨ Fitur Utama

### 🔄 Dual-Source Queue System
- **Desktop Machine**: Mesin antrian fisik dengan interface touch-friendly
- **Mobile App**: Aplikasi web responsif untuk smartphone pengguna

### 📱 Mobile Queue Features
- Ambil nomor antrian dari mana saja
- Nomor antrian tersimpan otomatis (persistent)
- Tidak hilang saat browser ditutup atau halaman di-refresh
- Cek status antrian real-time
- Tidak memerlukan login/registrasi

### 🖥️ Desktop Machine Features
- Interface khusus untuk mesin antrian
- Setiap klik menghasilkan nomor baru
- Statistik real-time
- Kategori layanan lengkap

### 🎯 Single Queue Line
- Semua nomor antrian dalam satu jalur berurutan
- Database terpusat untuk konsistensi data
- Deteksi otomatis device type (mobile vs desktop)

## 🏗️ Arsitektur Sistem

### Framework & Technology
- **Backend**: CodeIgniter 4 (PHP)
- **Frontend**: Bootstrap 5, Font Awesome, JavaScript
- **Database**: MySQL/MariaDB
- **Styling**: Custom CSS dengan gradient modern

### Struktur Database
```sql
-- Tabel utama antrian dengan device tracking
antrians:
- id, nomor_antrian, kategori_id, status
- device_type (mobile/desktop)
- device_id (untuk mobile persistence)
- user_agent, ip_address
- waktu_ambil, created_at, updated_at

-- Kategori layanan
kategori_antrians:
- id, nama_kategori, prefix, deskripsi, status

-- Users dan loket untuk admin
users, lokets, pengaturan_displays
```

## 📁 Struktur File

```
app/
├── Controllers/
│   ├── HomeController.php          # Homepage utama
│   ├── AntrianController.php       # Controller antrian mobile
│   ├── DesktopController.php       # Controller mesin antrian
│   ├── AdminController.php         # Admin dashboard
│   └── AuthController.php          # Authentication
├── Models/
│   ├── AntrianModel.php            # Model antrian dengan device logic
│   ├── KategoriAntrianModel.php    # Model kategori
│   └── UserModel.php               # Model user
├── Views/
│   ├── home.php                    # Homepage elegan
│   ├── antrian/index.php           # Interface mobile
│   ├── desktop/index.php           # Interface mesin antrian
│   └── layouts/main.css            # CSS utama
└── Database/Migrations/
    └── AddDeviceInfoToAntrians.php # Migration device fields
```

## 🚀 Cara Penggunaan

### 1. Homepage (`/`)
- Landing page elegan dengan gradient modern
- Pilihan akses mobile atau desktop
- Statistik real-time antrian

### 2. Mobile Queue (`/antrian`)
- Pilih kategori layanan
- Ambil nomor antrian
- Cek status antrian
- Nomor tersimpan otomatis

### 3. Desktop Machine (`/desktop`)
- Interface touch-friendly
- Pilih kategori
- Generate nomor baru
- Statistik real-time

### 4. Admin Panel (`/admin`)
- Dashboard dengan statistik
- Manajemen users, loket, kategori
- Laporan dan pengaturan

## 🔧 Instalasi & Setup

### Prerequisites
- PHP 7.4+ atau 8.0+
- MySQL 5.7+ atau MariaDB 10.2+
- Composer
- Web server (Apache/Nginx)

### Installation Steps
1. Clone repository
```bash
git clone [repository-url]
cd QueueBank-ProMax
```

2. Install dependencies
```bash
composer install
```

3. Setup database
```bash
# Copy .env.example to .env
# Update database configuration
php spark migrate
php spark db:seed DatabaseSeeder
```

4. Run development server
```bash
php spark serve
```

## 🎨 Design System

### Color Palette
- **Primary**: #1e40af (Blue)
- **Secondary**: #3b82f6 (Light Blue)
- **Accent**: #06b6d4 (Cyan)
- **Success**: #10b981 (Green)
- **Warning**: #f59e0b (Orange)
- **Danger**: #ef4444 (Red)

### Typography
- **Font Family**: Inter (Google Fonts)
- **Weights**: 300, 400, 500, 600, 700

### Components
- **Cards**: Rounded corners (20px), subtle shadows
- **Buttons**: Gradient backgrounds, hover effects
- **Forms**: Modern styling dengan focus states
- **Alerts**: Gradient backgrounds, rounded corners

## 📱 Responsive Design

- **Mobile First**: Optimized untuk smartphone
- **Tablet**: Layout adaptif untuk tablet
- **Desktop**: Full-featured interface
- **Touch Friendly**: Optimized untuk touch devices

## 🔒 Security Features

- Session management untuk mobile persistence
- Device ID generation yang aman
- Input validation dan sanitization
- CSRF protection
- SQL injection prevention

## 📊 Monitoring & Analytics

- Real-time queue statistics
- Device type tracking
- User behavior analytics
- Performance monitoring

## 🚀 Performance Optimization

- CSS dan JavaScript minification
- Image optimization
- Database query optimization
- Caching strategies

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**QueueBank ProMax** - Modern Digital Queue System for Banking Industry 🏦✨
