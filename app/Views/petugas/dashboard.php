<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard Petugas</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Antrian Aktif</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($antrian_aktif)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nomor Antrian</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Waktu Ambil</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($antrian_aktif as $antrian): ?>
                                        <tr>
                                            <td><?= $antrian['nomor_antrian'] ?></td>
                                            <td><?= $antrian['nama_kategori'] ?></td>
                                            <td>
                                                <span class="badge bg-<?= $antrian['status'] == 'menunggu' ? 'warning' : ($antrian['status'] == 'dipanggil' ? 'info' : 'success') ?>">
                                                    <?= ucfirst($antrian['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('H:i', strtotime($antrian['waktu_ambil'])) ?></td>
                                            <td>
                                                <?php if($antrian['status'] == 'menunggu'): ?>
                                                    <button class="btn btn-sm btn-primary" onclick="panggilAntrian(<?= $antrian['id'] ?>)">
                                                        <i class="fas fa-bullhorn"></i> Panggil
                                                    </button>
                                                <?php elseif($antrian['status'] == 'dipanggil'): ?>
                                                    <button class="btn btn-sm btn-success" onclick="selesaiAntrian(<?= $antrian['id'] ?>)">
                                                        <i class="fas fa-check"></i> Selesai
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" onclick="lewatiAntrian(<?= $antrian['id'] ?>)">
                                                        <i class="fas fa-forward"></i> Lewati
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada antrian aktif saat ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sisa Antrian</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-primary"><?= $sisa_antrian ?></h2>
                    <p class="text-muted">Antrian menunggu</p>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Antrian Dipanggil</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($antrian_dipanggil)): ?>
                        <?php foreach($antrian_dipanggil as $antrian): ?>
                            <div class="alert alert-info">
                                <strong><?= $antrian['nomor_antrian'] ?></strong> - <?= $antrian['nama_loket'] ?? 'Loket ' . $antrian['loket_id'] ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada antrian yang sedang dipanggil.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function panggilAntrian(id) {
    if (confirm('Panggil antrian ini?')) {
        $.post('/petugas/panggil-antrian', {antrian_id: id}, function(response) {
            if(response.success) {
                location.reload();
            }
        });
    }
}

function selesaiAntrian(id) {
    if (confirm('Tandai antrian ini selesai?')) {
        $.post('/petugas/selesai-antrian', {antrian_id: id}, function(response) {
            if(response.success) {
                location.reload();
            }
        });
    }
}

function lewatiAntrian(id) {
    if (confirm('Lewati antrian ini?')) {
        $.post('/petugas/lewati-antrian', {antrian_id: id}, function(response) {
            if(response.success) {
                location.reload();
            }
        });
    }
}
</script>
<?= $this->endSection() ?>
