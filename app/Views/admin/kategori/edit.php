<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>

<form action="/admin/kategori/update/<?= $kategori['id'] ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" value="<?= old('nama_kategori', $kategori['nama_kategori']) ?>" required>
    </div>
    <div class="form-group">
        <label>Prefix</label>
        <input type="text" name="prefix" class="form-control" value="<?= old('prefix', $kategori['prefix']) ?>" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control"><?= old('deskripsi', $kategori['deskripsi']) ?></textarea>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="aktif" <?= $kategori['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= $kategori['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?= $this->endSection() ?>
