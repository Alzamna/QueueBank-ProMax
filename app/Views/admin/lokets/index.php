<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Kelola Loket</h2>
    <a href="<?= base_url('admin/lokets/create') ?>" class="btn btn-primary mb-3">Tambah Loket</a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Loket</th>
                <th>Kode Loket</th>
                <th>Warna</th>
                <th>Status</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lokets as $loket): ?>
                <tr>
                    <td><?= esc($loket['nama_loket']) ?></td>
                    <td><?= esc($loket['kode_loket']) ?></td>
                    <td>
                        <span style="background-color: <?= esc($loket['warna']) ?>; color:#fff; padding:4px 8px; border-radius:4px;">
                            <?= esc($loket['warna']) ?>
                        </span>
                    </td>
                    <td><?= esc($loket['status']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/lokets/edit/' . $loket['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= base_url('admin/lokets/delete/' . $loket['id']) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus loket ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
