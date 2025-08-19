<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-edit me-1"></i>
                            Edit Pengguna
                        </div>
                        <a href="<?= base_url('admin/pengguna/pengguna') ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/pengguna/update/' . $user['id']) ?>" method="post" id="editUserForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                           value="<?= esc($user['nama_lengkap']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?= esc($user['username']) ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= esc($user['email']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           minlength="6">
                                    <div class="form-text">Minimal 6 karakter</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('admin/pengguna/pengguna') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editUserForm');
    
    editForm.addEventListener('submit', function(e) {
        console.log('Edit form submitted!');
        console.log('Form action:', editForm.action);
        console.log('Form method:', editForm.method);
        
        // Log form data
        const formData = new FormData(editForm);
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
});
</script>

<?= $this->endSection(); ?>
