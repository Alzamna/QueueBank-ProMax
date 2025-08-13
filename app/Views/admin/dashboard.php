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
                                            <td><?= $item['nama_kategori'] ?></td>
                                            <td><?= $item['total_antrian'] ?></td>
                                            <td><?= round($item['rata_rata_waktu'] / 60, 2) ?></td>
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
<?= $this->endSection() ?>
