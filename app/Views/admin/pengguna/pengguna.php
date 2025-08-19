<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('message'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Total Pengguna</div>
                            <div class="h4 mb-0"><?= $total_users ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Administrator</div>
                            <div class="h4 mb-0"><?= $admin_count ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Petugas</div>
                            <div class="h4 mb-0"><?= $petugas_count ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    Daftar Pengguna
                </div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-1"></i>Tambah Pengguna
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= esc($user['nama_lengkap'] ?? ($user['nama'] ?? '')); ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['role']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/pengguna/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/pengguna/add') ?>" method="post" id="addUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                               value="<?= old('nama_lengkap') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= old('username') ?>" minlength="3" maxlength="50" required>
                        <div class="form-text">Minimal 3 karakter, maksimal 50 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               minlength="6" required>
                        <div class="form-text">Minimal 6 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               minlength="6" required>
                        <div class="form-text">Masukkan ulang password</div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= old('role') == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Script -->
<script>
function deleteUser(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        window.location.href = `<?= base_url('admin/pengguna/delete/') ?>${id}`;
    }
}



// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const addUserForm = document.getElementById('addUserForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const addUserModal = document.getElementById('addUserModal');

    addUserForm.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            confirmPassword.focus();
            return false;
        }
    });

    // Real-time password confirmation check
    confirmPassword.addEventListener('input', function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak cocok');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });

    // Reset form when modal is closed
    addUserModal.addEventListener('hidden.bs.modal', function() {
        addUserForm.reset();
        confirmPassword.setCustomValidity('');
    });

    // Show success message and close modal if there's a success message
    <?php if (session()->getFlashdata('message')) : ?>
        const modal = bootstrap.Modal.getInstance(addUserModal);
        if (modal) {
            modal.hide();
        }
    <?php endif; ?>
});
</script>
<?= $this->endSection(); ?>