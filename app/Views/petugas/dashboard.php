<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Dashboard Petugas</h1>
            <p class="text-muted">Kelola antrian sesuai kategori layanan Anda</p>
        </div>
        <div class="d-flex align-items-center space-x-3">
            <div class="text-end">
                <p class="text-sm text-gray-600 mb-0">Hari ini</p>
                <p class="text-lg font-semibold text-gray-800"><?= date('d F Y') ?></p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tie text-white text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Kategori Selection -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-tags text-blue-600 mr-2"></i>
                        Pilih Kategori Layanan
                    </h5>
                    <div class="row">
                        <?php foreach($kategori as $kat): ?>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="kategori-card <?= ($selected_kategori && $selected_kategori['id'] == $kat['id']) ? 'active' : '' ?>" 
                                     onclick="selectKategori(<?= $kat['id'] ?>, '<?= $kat['nama_kategori'] ?>')">
                                    <div class="text-center p-3">
                                        <div class="kategori-icon mb-2">
                                            <?php
                                            $icon = 'fa-users';
                                            if (strpos(strtolower($kat['nama_kategori']), 'teller') !== false) $icon = 'fa-cash-register';
                                            elseif (strpos(strtolower($kat['nama_kategori']), 'cs') !== false || strpos(strtolower($kat['nama_kategori']), 'customer') !== false) $icon = 'fa-headset';
                                            elseif (strpos(strtolower($kat['nama_kategori']), 'prioritas') !== false) $icon = 'fa-star';
                                            elseif (strpos(strtolower($kat['nama_kategori']), 'kredit') !== false) $icon = 'fa-credit-card';
                                            elseif (strpos(strtolower($kat['nama_kategori']), 'deposito') !== false) $icon = 'fa-piggy-bank';
                                            ?>
                                            <i class="fas <?= $icon ?> fa-2x"></i>
                                        </div>
                                        <h6 class="kategori-title mb-1"><?= $kat['nama_kategori'] ?></h6>
                                        <small class="text-muted"><?= $kat['prefix'] ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($selected_kategori)): ?>
    <!-- Selected Kategori Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle text-info mr-3 fa-lg"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Kategori Aktif: <?= $selected_kategori['nama_kategori'] ?></h6>
                        <p class="mb-0">Prefix: <?= $selected_kategori['prefix'] ?> | Deskripsi: <?= $selected_kategori['deskripsi'] ?? 'Tidak ada deskripsi' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="row">
        <!-- Left Column - Antrian Aktif -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-ol text-blue-600 mr-2"></i>
                            Antrian - <?= $selected_kategori['nama_kategori'] ?>
                        </h5>
                        <span class="badge bg-primary fs-6"><?= count($antrian_aktif) ?> Antrian</span>
                    </div>
                    
                    <!-- Navigation Tabs -->
                    <div class="mt-3">
                        <ul class="nav nav-tabs nav-tabs-custom" id="antrianTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button" role="tab" aria-controls="aktif" aria-selected="true">
                                    <i class="fas fa-clock mr-2"></i>
                                    Aktif <span class="badge bg-warning text-dark ms-1"><?= count($antrian_aktif) ?></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dipanggil-tab" data-bs-toggle="tab" data-bs-target="#dipanggil" type="button" role="tab" aria-controls="dipanggil" aria-selected="false">
                                    <i class="fas fa-bullhorn mr-2"></i>
                                    Dipanggil <span class="badge bg-info ms-1"><?= count($antrian_dipanggil) ?></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Selesai <span class="badge bg-success ms-1"><?= count($antrian_selesai) ?></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="lewati-tab" data-bs-toggle="tab" data-bs-target="#lewati" type="button" role="tab" aria-controls="lewati" aria-selected="false">
                                    <i class="fas fa-forward mr-2"></i>
                                    Dilewati <span class="badge bg-secondary ms-1"><?= count($antrian_dilewati) ?></span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="antrianTabsContent">
                        <!-- Tab 1: Antrian Aktif -->
                        <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                            <?php if(!empty($antrian_aktif)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">No. Antrian</th>
                                                <th class="border-0 px-4 py-3">Waktu Ambil</th>
                                                <th class="border-0 px-4 py-3">Status</th>
                                                <th class="border-0 px-4 py-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($antrian_aktif as $antrian): ?>
                                                <tr class="antrian-row">
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="antrian-number-display me-3">
                                                                <?= $antrian['nomor_antrian'] ?>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><?= $antrian['prefix'] ?></small>
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
                                                        <span class="badge bg-warning text-dark px-3 py-2">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Menunggu
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-primary btn-sm" onclick="panggilAntrian(<?= $antrian['id'] ?>)">
                                                                <i class="fas fa-bullhorn mr-1"></i>
                                                                Panggil
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
                                        <p class="text-muted">Semua antrian telah dilayani atau belum ada yang mengambil nomor</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tab 2: Antrian Dipanggil -->
                        <div class="tab-pane fade" id="dipanggil" role="tabpanel" aria-labelledby="dipanggil-tab">
                            <?php if(!empty($antrian_dipanggil)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">No. Antrian</th>
                                                <th class="border-0 px-4 py-3">Waktu Panggil</th>
                                                <th class="border-0 px-4 py-3">Loket</th>
                                                <th class="border-0 px-4 py-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($antrian_dipanggil as $antrian): ?>
                                                <tr class="antrian-row">
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="antrian-number-display me-3">
                                                                <?= $antrian['nomor_antrian'] ?>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><?= $antrian['prefix'] ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="text-muted">
                                                            <i class="far fa-clock mr-1"></i>
                                                            <?= date('H:i', strtotime($antrian['waktu_panggil'])) ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="badge bg-info px-3 py-2">
                                                            <i class="fas fa-desktop mr-1"></i>
                                                            <?= $antrian['nama_loket'] ?? 'Tidak ada loket' ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success btn-sm" onclick="selesaiAntrian(<?= $antrian['id'] ?>)">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Selesai
                                                            </button>
                                                            <button class="btn btn-warning btn-sm" onclick="lewatiAntrian(<?= $antrian['id'] ?>)">
                                                                <i class="fas fa-forward mr-1"></i>
                                                                Lewati
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
                                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Tidak ada antrian dipanggil</h6>
                                        <p class="text-muted">Belum ada antrian yang sedang dipanggil</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tab 3: Antrian Selesai -->
                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                            <?php if(!empty($antrian_selesai)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">No. Antrian</th>
                                                <th class="border-0 px-4 py-3">Waktu Selesai</th>
                                                <th class="border-0 px-4 py-3">Loket</th>
                                                <th class="border-0 px-4 py-3">Petugas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($antrian_selesai as $antrian): ?>
                                                <tr class="antrian-row">
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="antrian-number-display me-3">
                                                                <?= $antrian['nomor_antrian'] ?>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><?= $antrian['prefix'] ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="text-muted">
                                                            <i class="far fa-clock mr-1"></i>
                                                            <?= date('H:i', strtotime($antrian['waktu_selesai'])) ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="badge bg-success px-3 py-2">
                                                            <i class="fas fa-desktop mr-1"></i>
                                                            <?= $antrian['nama_loket'] ?? 'Tidak ada loket' ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <small class="text-muted">
                                                            <?= $antrian['nama_petugas'] ?? 'Tidak ada petugas' ?>
                                                        </small>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Tidak ada antrian selesai</h6>
                                        <p class="text-muted">Belum ada antrian yang selesai dilayani hari ini</p>
                                    </div>
                                    </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tab 4: Antrian Dilewati -->
                        <div class="tab-pane fade" id="lewati" role="tabpanel" aria-labelledby="lewati-tab">
                            <?php if(!empty($antrian_dilewati)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-0 px-4 py-3">No. Antrian</th>
                                                <th class="border-0 px-4 py-3">Waktu Dilewati</th>
                                                <th class="border-0 px-4 py-3">Loket</th>
                                                <th class="border-0 px-4 py-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($antrian_dilewati as $antrian): ?>
                                                <tr class="antrian-row">
                                                    <td class="px-4 py-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="antrian-number-display me-3">
                                                                <?= $antrian['nomor_antrian'] ?>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><?= $antrian['prefix'] ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="text-muted">
                                                            <i class="far fa-clock mr-1"></i>
                                                            <?= date('H:i', strtotime($antrian['waktu_selesai'])) ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="badge bg-secondary px-3 py-2">
                                                            <i class="fas fa-desktop mr-1"></i>
                                                            <?= $antrian['nama_loket'] ?? 'Tidak ada loket' ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-primary btn-sm" onclick="panggilUlangAntrian(<?= $antrian['id'] ?>)">
                                                                <i class="fas fa-redo mr-1"></i>
                                                                Panggil Ulang
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
                                        <i class="fas fa-forward fa-3x text-muted mb-3"></i>
                                        <h6 class="text-muted">Tidak ada antrian dilewati</h6>
                                        <p class="text-muted">Belum ada antrian yang dilewati hari ini</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Stats & Actions -->
        <div class="col-lg-4">
            <!-- Petugas Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="card-title text-muted mb-3">Informasi Petugas</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0"><?= session()->get('nama_lengkap') ?></h6>
                            <small class="text-muted"><?= session()->get('role') ?></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-desktop text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Loket</h6>
                            <small class="text-muted">
                                <?php 
                                $userModel = new \App\Models\UserModel();
                                $user = $userModel->find(session()->get('user_id'));
                                if ($user && !empty($user['loket_id'])) {
                                    $loketModel = new \App\Models\LoketModel();
                                    $loket = $loketModel->find($user['loket_id']);
                                    if ($loket) {
                                        echo '<span class="badge bg-success">' . esc($loket['nama_loket']) . ' (' . esc($loket['kode_loket']) . ')</span>';
                                    }
                                } else {
                                    echo '<span class="text-danger">Belum ditugaskan ke loket</span>';
                                }
                                ?>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-tags text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Kategori</h6>
                            <small class="text-muted">
                                <?php 
                                $userKategoriModel = new \App\Models\UserKategoriModel();
                                $userKategori = $userKategoriModel->getCategoriesByUserId(session()->get('user_id'));
                                if (!empty($userKategori)) {
                                    foreach ($userKategori as $uk) {
                                        echo '<span class="badge bg-info me-1">' . esc($uk['nama_kategori']) . '</span>';
                                    }
                                } else {
                                    echo 'Belum ada kategori';
                                }
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title text-muted mb-0">Statistik Hari Ini</h6>
                        <small class="text-muted" id="lastUpdate">Terakhir update: -</small>
                    </div>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-item">
                                <div class="stat-number text-primary" id="statMenunggu"><?= $stats['menunggu'] ?? 0 ?></div>
                                <div class="stat-label text-muted">Menunggu</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-item">
                                <div class="stat-number text-info" id="statDipanggil"><?= $stats['dipanggil'] ?? 0 ?></div>
                                <div class="stat-label text-muted">Dipanggil</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number text-success" id="statSelesai"><?= $stats['selesai'] ?? 0 ?></div>
                                <div class="stat-label text-muted">Selesai</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-number text-warning" id="statLewati"><?= $stats['lewati'] ?? 0 ?></div>
                                <div class="stat-label text-muted">Lewati</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Antrian Dipanggil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bullhorn text-info mr-2"></i>
                        Sedang Dipanggil
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
                                        <small class="text-muted">Dipanggil <?= date('H:i', strtotime($antrian['waktu_panggil'])) ?></small>
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
                            <p class="text-muted mb-0">Tidak ada antrian yang sedang dipanggil</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>



            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="card-title text-muted mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="refreshDashboard()">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>



<style>
.kategori-card {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.kategori-card:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
}

.kategori-card.active {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
}

.kategori-icon {
    color: #3b82f6;
}

.kategori-title {
    color: #1f2937;
    font-weight: 600;
}

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

.stat-item {
    padding: 16px 8px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    display: block;
}

.stat-label {
    font-size: 0.875rem;
    margin-top: 4px;
}

.empty-state {
    padding: 40px 20px;
}

.antrian-row:hover {
    background-color: #f8fafc;
}

.btn-group-vertical .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
    font-size: 1rem;
}
</style>

<script>
let selectedAntrianId = null;

function selectKategori(kategoriId, namaKategori) {
    // Remove active class from all cards
    document.querySelectorAll('.kategori-card').forEach(card => {
        card.classList.remove('active');
    });
    
    // Add active class to selected card
    event.currentTarget.classList.add('active');
    
    // Redirect to dashboard with selected kategori
    window.location.href = `<?= site_url('petugas/dashboard') ?>?kategori_id=${kategoriId}`;
}

function panggilAntrian(antrianId) {
    selectedAntrianId = antrianId;
    
    // Langsung panggil antrian tanpa modal popup
    console.log('Memanggil antrian ID:', antrianId);
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, using fetch instead');
        // Fallback to fetch API
        fetch('<?= site_url('petugas/panggil-antrian') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                antrian_id: selectedAntrianId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Fetch response:', data);
            if (data.success) {
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
                    title: 'Gagal!',
                    text: 'Gagal memanggil antrian: ' + data.message
                });
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan sistem: ' + error.message
            });
        });
        return;
    }
    
    // Use jQuery if available
    console.log('Using jQuery for AJAX call');
    $.post('<?= site_url('petugas/panggil-antrian') ?>', {
        antrian_id: selectedAntrianId
    })
    .done(function(response) {
        console.log('jQuery response:', response);
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
                title: 'Gagal!',
                text: 'Gagal memanggil antrian: ' + response.message
            });
        }
    })
    .fail(function(xhr, status, error) {
        console.error('jQuery AJAX failed:', {xhr, status, error});
        console.error('Response text:', xhr.responseText);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan sistem: ' + error
        });
    });
}



function selesaiAntrian(antrianId) {
    console.log('selesaiAntrian called with ID:', antrianId);
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, using fetch instead');
        // Fallback to fetch API
        fetch('<?= site_url('petugas/selesai-antrian') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                antrian_id: antrianId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Fetch response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menyelesaikan antrian: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan sistem: ' + error.message);
        });
        return;
    }
    
    // Use jQuery if available
    console.log('Using jQuery for AJAX call');
    $.post('<?= site_url('petugas/selesai-antrian') ?>', {
        antrian_id: antrianId
    })
    .done(function(response) {
        console.log('jQuery response:', response);
        if (response.success) {
            location.reload();
        } else {
            alert('Gagal menyelesaikan antrian: ' + response.message);
        }
    })
    .fail(function(xhr, status, error) {
        console.error('jQuery AJAX failed:', {xhr, status, error});
        console.error('Response text:', xhr.responseText);
        alert('Terjadi kesalahan sistem: ' + error);
    });
}

function lewatiAntrian(antrianId) {
    console.log('lewatiAntrian called with ID:', antrianId);
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, using fetch instead');
        // Fallback to fetch API
        fetch('<?= site_url('petugas/lewati-antrian') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                antrian_id: antrianId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Fetch response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal melewati antrian: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan sistem: ' + error.message);
        });
        return;
    }
    
    // Use jQuery if available
    console.log('Using jQuery for AJAX call');
    $.post('<?= site_url('petugas/lewati-antrian') ?>', {
        antrian_id: antrianId
    })
    .done(function(response) {
        console.log('jQuery response:', response);
        if (response.success) {
            location.reload();
        } else {
            alert('Gagal melewati antrian: ' + response.message);
        }
    })
    .fail(function(xhr, status, error) {
        console.error('jQuery AJAX failed:', {xhr, status, error});
        console.error('Response text:', xhr.responseText);
        alert('Terjadi kesalahan sistem: ' + error);
    });
}

function panggilUlangAntrian(antrianId) {
    console.log('panggilUlangAntrian called with ID:', antrianId);
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, using fetch instead');
        // Fallback to fetch API
        fetch('<?= site_url('petugas/panggil-ulang-antrian') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                antrian_id: antrianId
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Fetch response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal memanggil ulang antrian: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan sistem: ' + error.message);
        });
        return;
    }
    
    // Use jQuery if available
    console.log('Using jQuery for AJAX call');
    $.post('<?= site_url('petugas/panggil-ulang-antrian') ?>', {
        antrian_id: antrianId
    })
    .done(function(response) {
        console.log('jQuery response:', response);
        if (response.success) {
            location.reload();
        } else {
            alert('Gagal memanggil ulang antrian: ' + response.message);
        }
    })
    .fail(function(xhr, status, error) {
        console.error('jQuery AJAX failed:', {xhr, status, error});
        console.error('Response text:', xhr.responseText);
        alert('Terjadi kesalahan sistem: ' + error);
    });
}

function refreshDashboard() {
    location.reload();
}



// Function to refresh statistics
function refreshStatistik() {
    const kategoriId = <?= $selected_kategori['id'] ?? 'null' ?>;
    if (!kategoriId) return;
    
    fetch(`<?= site_url('petugas/get-statistik-real-time') ?>?kategori_id=${kategoriId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('statMenunggu').textContent = data.stats.menunggu;
                document.getElementById('statDipanggil').textContent = data.stats.dipanggil;
                document.getElementById('statSelesai').textContent = data.stats.selesai;
                document.getElementById('statLewati').textContent = data.stats.lewati;
                document.getElementById('lastUpdate').textContent = `Terakhir update: ${data.timestamp}`;
            }
        })
        .catch(error => {
            console.error('Error refreshing statistics:', error);
        });
}

// Auto refresh statistics every 10 seconds
setInterval(function() {
    // Only refresh if no modal is open and kategori is selected
    if (!document.querySelector('.modal.show') && <?= $selected_kategori ? 'true' : 'false' ?>) {
        refreshStatistik();
    }
}, 10000);

// Auto refresh page every 60 seconds (less frequent)
setInterval(function() {
    // Only refresh if no modal is open
    if (!document.querySelector('.modal.show')) {
        location.reload();
    }
}, 60000);
</script>

<!-- SweetAlert2 for better notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>
/* Custom Navigation Tabs Styling */
.nav-tabs-custom {
    border-bottom: 2px solid #e5e7eb;
}

.nav-tabs-custom .nav-link {
    border: none;
    border-radius: 0;
    color: #6b7280;
    font-weight: 500;
    padding: 12px 20px;
    margin-right: 5px;
    transition: all 0.3s ease;
    position: relative;
    background: transparent;
}

.nav-tabs-custom .nav-link:hover {
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.05);
    border-color: transparent;
}

.nav-tabs-custom .nav-link.active {
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
    border-color: transparent;
    border-bottom: 3px solid #3b82f6;
}

.nav-tabs-custom .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: #3b82f6;
    border-radius: 2px 2px 0 0;
}

/* Badge styling in nav tabs */
.nav-tabs-custom .nav-link .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
}

/* Tab content transitions */
.tab-content {
    background: white;
}

.tab-pane {
    transition: opacity 0.3s ease;
}

.tab-pane.fade {
    opacity: 0;
}

.tab-pane.fade.show {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .nav-tabs-custom .nav-link {
        padding: 10px 15px;
        font-size: 0.9rem;
    }
    
    .nav-tabs-custom .nav-link .badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }
}
</style>

<?= $this->endSection() ?>
