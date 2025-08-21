<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-headset text-blue-600 mr-2"></i>
                Dashboard Customer Service
            </h1>
            <p class="text-muted">Kelola antrian layanan customer service dan konsultasi</p>
        </div>
        <div class="d-flex align-items-center space-x-3">
            <div class="text-end">
                <p class="text-sm text-gray-600 mb-0">Hari ini</p>
                <p class="text-lg font-semibold text-gray-800"><?= date('d F Y') ?></p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                <i class="fas fa-headset text-white text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Menunggu</h6>
                            <h4 class="mb-0 text-blue-600"><?= $stats['menunggu'] ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bullhorn text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Dipanggil</h6>
                            <h4 class="mb-0 text-yellow-600"><?= $stats['dipanggil'] ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Selesai</h6>
                            <h4 class="mb-0 text-green-600"><?= $stats['selesai'] ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-forward text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Lewati</h6>
                            <h4 class="mb-0 text-red-600"><?= $stats['lewati'] ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - Antrian Aktif -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-ol text-blue-600 mr-2"></i>
                            Antrian Customer Service Aktif
                        </h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary fs-6 me-2"><?= count($antrian_aktif) ?> Antrian</span>
                            <button class="btn btn-outline-primary btn-sm" onclick="refreshAntrian()">
                                <i class="fas fa-sync-alt mr-1"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if(!empty($antrian_aktif)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">No. Antrian</th>
                                        <th class="border-0 px-4 py-3">Waktu Ambil</th>
                                        <th class="border-0 px-4 py-3">Estimasi Waktu</th>
                                        <th class="border-0 px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($antrian_aktif as $index => $antrian): ?>
                                        <tr class="antrian-row">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="antrian-number-display me-3">
                                                        <?= $antrian['nomor_antrian'] ?>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">CS</small>
                                                        <small class="text-primary fw-bold">#<?= $index + 1 ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-muted">
                                                    <i class="far fa-clock mr-1"></i>
                                                    <?= date('H:i', strtotime($antrian['waktu_ambil'])) ?>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-muted">
                                                    <i class="fas fa-hourglass-half mr-1"></i>
                                                    <?= $index + 1 * 10 ?> menit
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-primary btn-sm" onclick="panggilAntrian(<?= $antrian['id'] ?>)">
                                                        <i class="fas fa-bullhorn mr-1"></i>
                                                        Panggil
                                                    </button>
                                                    <button class="btn btn-outline-info btn-sm" onclick="lihatDetail(<?= $antrian['id'] ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Tidak ada antrian aktif</h6>
                                <p class="text-muted">Semua antrian customer service telah dilayani</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <!-- Antrian Dipanggil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bullhorn text-yellow-600 mr-2"></i>
                        Sedang Dilayani
                    </h6>
                </div>
                <div class="card-body p-0">
                    <?php if(!empty($antrian_dipanggil)): ?>
                        <?php foreach($antrian_dipanggil as $antrian): ?>
                            <div class="p-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="antrian-number-display me-3">
                                        <?= $antrian['nomor_antrian'] ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold"><?= $antrian['nama_loket'] ?? 'Loket ' . $antrian['loket_id'] ?></div>
                                        <small class="text-muted">Mulai <?= date('H:i', strtotime($antrian['waktu_panggil'])) ?></small>
                                    </div>
                                    <div class="btn-group-vertical">
                                        <button class="btn btn-success btn-sm mb-1" onclick="selesaiAntrian(<?= $antrian['id'] ?>)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" onclick="lewatiAntrian(<?= $antrian['id'] ?>)">
                                            <i class="fas fa-forward"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-volume-mute fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada antrian yang sedang dilayani</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="card-title text-muted mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="panggilBerikutnya()">
                            <i class="fas fa-forward mr-2"></i>
                            Panggil Berikutnya
                        </button>
                        <button class="btn btn-outline-info" onclick="lihatLaporanCS()">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Laporan CS
                        </button>
                        <button class="btn btn-outline-warning" onclick="setBreak()">
                            <i class="fas fa-coffee mr-2"></i>
                            Set Break
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Customer Service -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="card-title text-muted mb-3">Info Customer Service</h6>
                    <div class="space-y-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span class="badge bg-primary">Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Loket:</span>
                            <span class="fw-bold">CS 1</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Jam Kerja:</span>
                            <span class="fw-bold">08:00 - 16:00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Target:</span>
                            <span class="fw-bold">30 layanan/hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.antrian-number-display {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.1rem;
    min-width: 80px;
    text-align: center;
}

.antrian-row:hover {
    background-color: #eff6ff;
}

.btn-group-vertical .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-state {
    padding: 40px 20px;
}

.space-y-3 > * + * {
    margin-top: 0.75rem;
}
</style>

<script>
let selectedAntrianId = null;

function panggilAntrian(antrianId) {
    selectedAntrianId = antrianId;
    
    // Langsung panggil antrian tanpa modal popup
    console.log('Memanggil antrian ID:', antrianId);
    
    $.post('<?= site_url('petugas/panggil-antrian') ?>', {
        antrian_id: selectedAntrianId
    }, function(response) {
        if (response.success) {
            // Show success message with SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Antrian berhasil dipanggil!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            });
        }
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan sistem'
        });
    });
}



function selesaiAntrian(antrianId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Tandai layanan ini selesai?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Selesai',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url('petugas/selesai-antrian') ?>', {
                antrian_id: antrianId
            }, function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            });
        }
    });
}

function lewatiAntrian(antrianId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Lewati antrian ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lewati',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?= site_url('petugas/lewati-antrian') ?>', {
                antrian_id: antrianId
            }, function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            });
        }
    });
}

function refreshAntrian() {
    location.reload();
}

function panggilBerikutnya() {
    // Get first waiting antrian
    const firstAntrian = document.querySelector('.antrian-row');
    if (firstAntrian) {
        const panggilBtn = firstAntrian.querySelector('[onclick*="panggilAntrian"]');
        const antrianId = panggilBtn.getAttribute('onclick').match(/\d+/)[0];
        panggilAntrian(antrianId);
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: 'Tidak ada antrian yang menunggu'
        });
    }
}

function lihatLaporanCS() {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: 'Fitur laporan CS akan segera tersedia'
    });
}

function setBreak() {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: 'Fitur set break akan segera tersedia'
    });
}

function lihatDetail(antrianId) {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: 'Fitur detail antrian akan segera tersedia'
    });
}

// Auto refresh every 30 seconds
setInterval(function() {
    if (!document.querySelector('.modal.show')) {
        location.reload();
    }
}, 30000);
</script>

<!-- SweetAlert2 for better notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->endSection() ?>
