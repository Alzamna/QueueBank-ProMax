# Sistem Cleanup Antrian Otomatis

Sistem ini menyediakan fitur untuk menghapus semua antrian dari database secara otomatis setiap hari jam 00:00.

## 🚀 Fitur yang Tersedia

### 1. **Cleanup Manual via Dashboard Admin**
- Tombol "Hapus Semua Antrian" - Menghapus semua antrian dari database
- Tombol "Hapus Antrian Kemarin" - Menghapus antrian untuk tanggal kemarin saja

### 2. **Cleanup via Command Line**
```bash
# Menghapus semua antrian
php spark cleanup:antrian

# Menghapus antrian untuk tanggal tertentu
php spark cleanup:antrian --date=2024-01-15
```

### 3. **Cleanup via API**
```bash
# Menghapus semua antrian (POST request)
curl -X POST http://localhost:8080/cleanup/antrian

# Menghapus antrian untuk tanggal tertentu
curl -X POST http://localhost:8080/cleanup/antrian/2024-01-15
```

### 4. **Cleanup Otomatis via Cron Job**
```bash
# Tambahkan ke crontab untuk menjalankan setiap hari jam 00:00
0 0 * * * /usr/bin/php /path/to/your/project/cleanup_antrian.php
```

## 📁 File yang Dibuat

### 1. **Command**
- `app/Commands/CleanupAntrian.php` - Command untuk cleanup via CLI

### 2. **Controller**
- `app/Controllers/CleanupController.php` - Controller untuk cleanup via API

### 3. **Model (Updated)**
- `app/Models/AntrianModel.php` - Ditambahkan method `cleanupAntrian()` dan `cleanupAntrianByDate()`

### 4. **Routes (Updated)**
- `app/Config/Routes.php` - Ditambahkan routes untuk cleanup

### 5. **View (Updated)**
- `app/Views/admin/dashboard.php` - Ditambahkan tombol cleanup

### 6. **Script Standalone**
- `cleanup_antrian.php` - Script untuk cron job

## 🔧 Cara Penggunaan

### **A. Cleanup Manual (Dashboard Admin)**

1. Login sebagai admin
2. Buka dashboard admin
3. Klik tombol "Hapus Semua Antrian" atau "Hapus Antrian Kemarin"
4. Konfirmasi tindakan

### **B. Cleanup via Command Line**

```bash
# Masuk ke direktori project
cd /path/to/your/project

# Menghapus semua antrian
php spark cleanup:antrian

# Menghapus antrian untuk tanggal tertentu
php spark cleanup:antrian --date=2024-01-15
```

### **C. Cleanup via API**

```bash
# Menghapus semua antrian
curl -X POST http://localhost:8080/cleanup/antrian \
  -H "Content-Type: application/json" \
  -H "X-Requested-With: XMLHttpRequest"

# Menghapus antrian untuk tanggal tertentu
curl -X POST http://localhost:8080/cleanup/antrian/2024-01-15 \
  -H "Content-Type: application/json" \
  -H "X-Requested-With: XMLHttpRequest"
```

### **D. Setup Cron Job Otomatis**

1. **Edit crontab:**
```bash
crontab -e
```

2. **Tambahkan baris berikut:**
```bash
# Cleanup antrian setiap hari jam 00:00
0 0 * * * /usr/bin/php /path/to/your/project/cleanup_antrian.php >> /var/log/cleanup_antrian.log 2>&1
```

3. **Pastikan file script memiliki permission yang benar:**
```bash
chmod +x /path/to/your/project/cleanup_antrian.php
```

## 🔒 Keamanan

- **Hanya admin** yang dapat melakukan cleanup manual
- Semua aktivitas cleanup dicatat dalam log
- Konfirmasi diperlukan sebelum melakukan cleanup manual
- Backup database disarankan sebelum melakukan cleanup

## 📊 Monitoring

### **Log Files**
- Cleanup activity dicatat di `writable/logs/`
- Cron job output dicatat di `/var/log/cleanup_antrian.log` (jika menggunakan cron)

### **Response Format**
```json
{
    "success": true,
    "message": "Semua antrian berhasil dihapus dari database",
    "timestamp": "2024-01-15 00:00:00"
}
```

## ⚠️ Peringatan

1. **Backup Database** - Selalu backup database sebelum melakukan cleanup
2. **Konfirmasi** - Pastikan benar-benar ingin menghapus data antrian
3. **Testing** - Test di environment development terlebih dahulu
4. **Monitoring** - Monitor log untuk memastikan cleanup berjalan dengan baik

## 🛠️ Troubleshooting

### **Masalah Umum:**

1. **Permission Denied**
   ```bash
   chmod +x cleanup_antrian.php
   ```

2. **Path tidak ditemukan**
   - Pastikan path ke PHP dan project benar
   - Gunakan absolute path di cron job

3. **Database connection error**
   - Periksa konfigurasi database
   - Pastikan database server berjalan

4. **Log tidak muncul**
   - Periksa permission folder `writable/logs/`
   - Pastikan CodeIgniter dapat menulis ke folder log

## 📞 Support

Jika ada masalah atau pertanyaan, silakan hubungi administrator sistem.
