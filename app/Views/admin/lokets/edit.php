<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Loket</h5>
            <a href="<?= base_url('admin/lokets') ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
        </div>

        <form action="<?= base_url('admin/lokets/update/' . $loket['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Loket</label>
                    <input type="text" name="nama_loket" class="form-control" value="<?= old('nama_loket', $loket['nama_loket']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kode Loket</label>
                    <input type="text" name="kode_loket" class="form-control" value="<?= old('kode_loket', $loket['kode_loket']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Warna</label>
                    <div class="input-group">
                        <input type="color" id="warnaPicker" class="form-control form-control-color" style="max-width: 60px; padding: 0;" value="<?= old('warna', $loket['warna']) ?>" title="Pilih warna">
                        <input type="text" id="warnaHex" name="warna" class="form-control" value="<?= old('warna', $loket['warna']) ?>" placeholder="#007bff" required>
                    </div>
                    <small class="text-muted">Pilih warna lalu sesuaikan hex code jika perlu.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" <?= ($loket['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= ($loket['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Update</button>
                <a href="<?= base_url('admin/lokets') ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    (function(){
        const picker = document.getElementById('warnaPicker');
        const hex = document.getElementById('warnaHex');
        if(picker && hex){
            picker.addEventListener('input', () => { hex.value = picker.value; });
            hex.addEventListener('input', () => {
                const val = hex.value.trim();
                if(/^#([0-9A-Fa-f]{6})$/.test(val)) picker.value = val;
            });
        }
    })();
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
