<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Loket</h2>
    <form action="<?= base_url('admin/lokets/update/' . $loket['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label>Nama Loket</label>
            <input type="text" name="nama_loket" class="form-control" value="<?= old('nama_loket', $loket['nama_loket']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Kode Loket</label>
            <input type="text" name="kode_loket" class="form-control" value="<?= old('kode_loket', $loket['kode_loket']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Warna</label>
            <input type="color" name="warna" class="form-control" value="<?= old('warna', $loket['warna']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" <?= $loket['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $loket['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="<?= base_url('admin/lokets') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
