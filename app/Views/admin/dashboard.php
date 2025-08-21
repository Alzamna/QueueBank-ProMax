<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard Admin</h1>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <h2 class="text-primary"><?= $totalUsers ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Loket</h5>
                    <h2 class="text-success"><?= $totalLokets ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <h2 class="text-info"><?= $totalKategori ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Antrian Hari Ini</h5>
                    <h2 class="text-warning"><?= $totalAntrianHariIni ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manajemen Antrian</h5>
                    <div>
                        <button type="button" class="btn btn-danger btn-sm" onclick="cleanupAntrian()">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Semua Antrian
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="cleanupAntrianByDate()">
                            <i class="fas fa-calendar-times me-1"></i>
                            Hapus Antrian Kemarin
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Tombol "Hapus Semua Antrian" akan menghapus semua data antrian dari database. 
                        Tombol "Hapus Antrian Kemarin" akan menghapus antrian untuk tanggal kemarin saja.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Antrian Hari Ini</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($statistik)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Total Antrian</th>
                                        <th>Rata-rata Waktu (menit)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($statistik as $item): ?>
                                        <tr>
                                            <td><?= $item['nama_kategori'] ?? 'Tidak ada nama' ?></td>
                                            <td><?= $item['total_antrian'] ?? 0 ?></td>
                                            <td><?= $item['rata_rata_waktu'] ? round($item['rata_rata_waktu'] / 60, 2) : 0 ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada data antrian hari ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cleanupAntrian() {
    if (confirm('⚠️ PERINGATAN!\n\nAnda yakin ingin menghapus SEMUA antrian dari database?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data antrian yang ada.')) {
        fetch('<?= base_url('cleanup/antrian') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message + '\n\nTimestamp: ' + data.timestamp);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat melakukan cleanup');
        });
    }
}

function cleanupAntrianByDate() {
    if (confirm('⚠️ PERINGATAN!\n\nAnda yakin ingin menghapus semua antrian untuk tanggal kemarin?\n\nTindakan ini tidak dapat dibatalkan.')) {
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        const dateStr = yesterday.toISOString().split('T')[0]; // Format: YYYY-MM-DD
        
        fetch('<?= base_url('cleanup/antrian/') ?>' + dateStr, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message + '\n\nTanggal: ' + data.tanggal + '\nTimestamp: ' + data.timestamp);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat melakukan cleanup');
        });
    }
}
</script>

<?= $this->endSection() ?>
