<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1><?= $title ?></h1>
<a href="/admin/kategori/create" class="btn btn-primary">Tambah Kategori</a>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Prefix</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($kategori as $i => $row): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= esc($row['nama_kategori']) ?></td>
            <td><?= esc($row['prefix']) ?></td>
            <td><?= esc($row['status']) ?></td>
            <td>
                <a href="/admin/kategori/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/kategori/delete/<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
