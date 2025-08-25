<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Daftar Kategori Antrian</h5>
            <a href="/admin/kategori/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Kategori</a>
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
                        <th>Nama Kategori</th>
                        <th>Kode Kategori</th>
                        <th>Warna</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($kategori as $row): ?>
                        <tr>
                            <td><?= esc($row['nama_kategori']) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($row['prefix']) ?></span></td>
                            <td>
                                <span style="background-color: <?= esc($row['warna'] ?? '#007bff') ?>; color:#fff; padding:4px 8px; border-radius:6px; display:inline-block; min-width:78px; text-align:center;">
                                    <?= esc($row['warna'] ?? '#007bff') ?>
                                </span>
                            </td>
                            <td>
                                <?php if(($row['status'] ?? '') === 'aktif'): ?>
                                    <span class="badge bg-success">aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/admin/kategori/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
                                    <form action="/admin/kategori/delete/<?= $row['id'] ?>" method="post" onsubmit="return confirm('Hapus kategori ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
