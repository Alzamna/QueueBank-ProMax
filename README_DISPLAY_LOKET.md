# Menambahkan Informasi Loket di Display

## Tujuan
Menampilkan informasi loket pada nomor antrian yang dipanggil di display publik, sehingga pengunjung tahu harus pergi ke loket mana.

## Perubahan yang Dilakukan

### 1. DisplayController.php
**Method `getAntrian()`** - Menambahkan format informasi loket:
```php
// Format loket information
if (!empty($antrian[0]['nama_loket'])) {
    $antrian[0]['loket'] = $antrian[0]['nama_loket'];
} else {
    $antrian[0]['loket'] = null;
}
```

### 2. app/Views/display/index.php
**JavaScript `loadCurrentAntrian()`** - Memperbaiki logika tampilan loket:
```javascript
// Show loket information if available
if (antrian.loket && antrian.loket.trim() !== '') {
    document.getElementById("currentLoket").style.display = 'block';
    document.getElementById("loketText").innerText = antrian.loket;
} else {
    document.getElementById("currentLoket").style.display = 'none';
}
```

### 3. PetugasController.php
**Method `panggilAntrian()`** - Sudah menyimpan loket_id dengan benar:
```php
$updateData = [
    'loket_id' => $loket_id,
    'petugas_id' => $petugas_id,
    'status' => 'dipanggil',
    'waktu_panggil' => date('Y-m-d H:i:s'),
];
```

### 4. AntrianModel.php
**Method `getAntrianDipanggil()`** - Sudah mengambil data loket:
```php
->select('a.*, k.nama_kategori, k.prefix, l.nama_loket, u.nama_lengkap as petugas')
->join('lokets l', 'l.id = a.loket_id', 'left')
```

## Flow Sistem

### 1. Petugas Memanggil Antrian
1. Petugas login dengan akun yang sudah ditugaskan ke loket tertentu
2. Petugas klik "Panggil" pada antrian
3. Sistem menyimpan `loket_id` dan `petugas_id` ke database
4. Status antrian berubah menjadi "dipanggil"

### 2. Display Menampilkan Informasi
1. Display mengambil data antrian yang dipanggil
2. Sistem mengambil nama loket dari tabel `lokets`
3. Display menampilkan:
   - Nomor antrian (contoh: C005)
   - Nama loket (contoh: Loket 1)
   - Kategori layanan (contoh: Teller)

## Tampilan di Display

### Sebelum:
```
Nomor Antrian yang Dipanggil
C005
```

### Sesudah:
```
Nomor Antrian yang Dipanggil
C005
📍 Loket 1
🏢 Teller
```

## Validasi

### 1. Petugas Harus Ditugaskan ke Loket
- Sistem memvalidasi bahwa petugas memiliki `loket_id`
- Jika tidak, akan muncul pesan error

### 2. Loket Harus Aktif
- Sistem memvalidasi bahwa loket status = 'aktif'
- Jika tidak, akan muncul pesan error

### 3. Kategori Harus Sesuai
- Petugas hanya bisa memanggil antrian dari kategori yang ditugaskan
- Validasi melalui tabel `user_kategori`

## Testing

### 1. Test Petugas Login
- Login sebagai petugas yang sudah ditugaskan ke loket
- Pastikan bisa memanggil antrian

### 2. Test Display
- Buka `http://localhost:8080/display`
- Pastikan informasi loket muncul saat antrian dipanggil

### 3. Test Validasi
- Coba login sebagai petugas tanpa loket
- Pastikan muncul pesan error yang sesuai

## Data yang Ditampilkan

| Field | Sumber | Contoh |
|-------|--------|--------|
| Nomor Antrian | `antrians.nomor_antrian` | C005 |
| Nama Loket | `lokets.nama_loket` | Loket 1 |
| Kategori | `kategori_antrians.nama_kategori` | Teller |
| Petugas | `users.nama_lengkap` | John Doe |

## Error Handling

### 1. Loket Tidak Ditemukan
- Display akan menyembunyikan informasi loket
- Tidak akan crash atau error

### 2. Data Kosong
- Validasi `trim()` untuk memastikan data tidak kosong
- Fallback ke tampilan default

### 3. Database Error
- Try-catch untuk menangani error database
- Log error untuk debugging
