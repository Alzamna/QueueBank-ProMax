<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-desktop me-2 text-primary"></i>Daftar Loket</h5>
            <a href="<?= base_url('admin/lokets/create') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Loket</a>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Loket</th>
                        <th>Kode Loket</th>
                        <th>Warna</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lokets as $loket): ?>
                        <tr>
                            <td><?= esc($loket['nama_loket']) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($loket['kode_loket']) ?></span></td>
                            <td>
                                <span style="background-color: <?= esc($loket['warna']) ?>; color:#fff; padding:4px 8px; border-radius:6px; display:inline-block; min-width:78px; text-align:center;">
                                    <?= esc($loket['warna']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if(($loket['status'] ?? '') === 'aktif'): ?>
                                    <span class="badge bg-success">aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('admin/lokets/edit/' . $loket['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
                                    <form action="<?= base_url('admin/lokets/delete/' . $loket['id']) ?>" method="post" onsubmit="return confirm('Hapus loket ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
