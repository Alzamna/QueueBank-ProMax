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
                        <th>Loket</th>
                        <th>Kategori Antrian</th>
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
                                <?php if ($user['role'] === 'petugas' && !empty($user['loket'])): ?>
                                    <span class="badge bg-success">
                                        <?= esc($user['loket']['nama_loket']); ?> (<?= esc($user['loket']['kode_loket']); ?>)
                                    </span>
                                <?php elseif ($user['role'] === 'petugas'): ?>
                                    <span class="text-muted">Belum ada loket</span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['role'] === 'petugas' && !empty($user['kategori'])): ?>
                                    <?php foreach ($user['kategori'] as $kategori): ?>
                                        <span class="badge bg-info me-1"><?= esc($kategori['nama_kategori']); ?></span>
                                    <?php endforeach; ?>
                                <?php elseif ($user['role'] === 'petugas'): ?>
                                    <span class="text-muted">Belum ada kategori</span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser(<?= $user['id']; ?>, '<?= esc($user['nama_lengkap'] ?? ($user['nama'] ?? '')); ?>', '<?= $user['username']; ?>', '<?= $user['email']; ?>', '<?= $user['role']; ?>', <?= htmlspecialchars(json_encode($user['kategori'] ?? []), ENT_QUOTES, 'UTF-8'); ?>, <?= $user['loket_id'] ?? 'null'; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
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
                    <div class="mb-3" id="loketSection" style="display: none;">
                        <label for="loket_id" class="form-label">Loket yang Dikelola</label>
                        <div class="form-text mb-2">Pilih loket yang akan dikelola oleh petugas ini</div>
                        <select class="form-select" id="loket_id" name="loket_id" required>
                            <option value="">Pilih Loket</option>
                            <?php if (isset($loket_list) && !empty($loket_list)): ?>
                                <?php foreach ($loket_list as $loket): ?>
                                    <option value="<?= $loket['id']; ?>">
                                        <?= esc($loket['nama_loket']); ?> (<?= esc($loket['kode_loket']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Belum ada loket tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3" id="kategoriSection" style="display: none;">
                        <label for="kategori_ids" class="form-label">Kategori Antrian yang Dikelola</label>
                        <div class="form-text mb-2">Pilih kategori antrian yang akan dikelola oleh petugas ini</div>
                        <?php if (isset($kategori_list) && !empty($kategori_list)): ?>
                            <?php foreach ($kategori_list as $kategori): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kategori_ids[]" 
                                           value="<?= $kategori['id']; ?>" id="kategori_<?= $kategori['id']; ?>">
                                    <label class="form-check-label" for="kategori_<?= $kategori['id']; ?>">
                                        <?= esc($kategori['nama_kategori']); ?> (<?= $kategori['prefix']; ?>)
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Belum ada kategori antrian yang tersedia. 
                                <a href="<?= base_url('admin/kategori') ?>" class="alert-link">Buat kategori terlebih dahulu</a>
                            </div>
                        <?php endif; ?>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="post" id="editUserForm">
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" minlength="3" maxlength="50" required>
                        <div class="form-text">Minimal 3 karakter, maksimal 50 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" minlength="6">
                        <div class="form-text">Minimal 6 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                    <div class="mb-3" id="editLoketSection" style="display: none;">
                        <label for="edit_loket_id" class="form-label">Loket yang Dikelola</label>
                        <div class="form-text mb-2">Pilih loket yang akan dikelola oleh petugas ini</div>
                        <select class="form-select" id="edit_loket_id" name="loket_id" required>
                            <option value="">Pilih Loket</option>
                            <?php if (isset($loket_list) && !empty($loket_list)): ?>
                                <?php foreach ($loket_list as $loket): ?>
                                    <option value="<?= $loket['id']; ?>">
                                        <?= esc($loket['nama_loket']); ?> (<?= esc($loket['kode_loket']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Belum ada loket tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3" id="editKategoriSection" style="display: none;">
                        <label for="edit_kategori_ids" class="form-label">Kategori Antrian yang Dikelola</label>
                        <div class="form-text mb-2">Pilih kategori antrian yang akan dikelola oleh petugas ini</div>
                        <?php if (isset($kategori_list) && !empty($kategori_list)): ?>
                            <?php foreach ($kategori_list as $kategori): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kategori_ids[]" 
                                           value="<?= $kategori['id']; ?>" id="edit_kategori_<?= $kategori['id']; ?>">
                                    <label class="form-check-label" for="edit_kategori_<?= $kategori['id']; ?>">
                                        <?= esc($kategori['nama_kategori']); ?> (<?= $kategori['prefix']; ?>)
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Belum ada kategori antrian yang tersedia. 
                                <a href="<?= base_url('admin/kategori') ?>" class="alert-link">Buat kategori terlebih dahulu</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Pengguna</button>
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

function editUser(id, namaLengkap, username, email, role, kategori, loketId) {
    try {
        // Set form values
        document.getElementById('edit_user_id').value = id;
        document.getElementById('edit_nama_lengkap').value = namaLengkap;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        
        // Clear password field
        document.getElementById('edit_password').value = '';
        
        // Handle loket section visibility and selection
        const editLoketSection = document.getElementById('editLoketSection');
        if (role === 'petugas') {
            editLoketSection.style.display = 'block';
            if (loketId) {
                document.getElementById('edit_loket_id').value = loketId;
            } else {
                document.getElementById('edit_loket_id').value = '';
            }
        } else {
            editLoketSection.style.display = 'none';
            document.getElementById('edit_loket_id').value = '';
        }
        
        // Handle kategori section visibility and checkboxes
        const editKategoriSection = document.getElementById('editKategoriSection');
        const checkboxes = editKategoriSection.querySelectorAll('input[type="checkbox"]');
        
        // Reset all checkboxes
        checkboxes.forEach(checkbox => checkbox.checked = false);
        
        // Show/hide kategori section based on role
        if (role === 'petugas') {
            editKategoriSection.style.display = 'block';
            
            // Check appropriate kategori checkboxes
            if (kategori && kategori.length > 0) {
                kategori.forEach(kat => {
                    const checkbox = document.getElementById(`edit_kategori_${kat.id}`);
                    if (checkbox) {
                        checkbox.checked = true;
                }
                });
            }
        } else {
            editKategoriSection.style.display = 'none';
        }
        
        // Show the modal using Bootstrap 5
        const editModalElement = document.getElementById('editUserModal');
        if (editModalElement && typeof bootstrap !== 'undefined') {
            const editModal = new bootstrap.Modal(editModalElement);
            editModal.show();
        } else {
            // Fallback: show modal manually
            editModalElement.style.display = 'block';
            editModalElement.classList.add('show');
            document.body.classList.add('modal-open');
            
            // Add backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
    } catch (error) {
        console.error('Error in editUser function:', error);
        alert('Terjadi kesalahan saat membuka modal edit: ' + error.message);
    }
}



// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const addUserForm = document.getElementById('addUserForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const addUserModal = document.getElementById('addUserModal');
    const roleSelect = document.getElementById('role');
    const kategoriSection = document.getElementById('kategoriSection');
    
    // Edit modal elements
    const editUserModal = document.getElementById('editUserModal');
    const editUserForm = document.getElementById('editUserForm');
    const editRoleSelect = document.getElementById('edit_role');
    const editKategoriSection = document.getElementById('editKategoriSection');

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

    // Show/hide kategori section based on role selection
    roleSelect.addEventListener('change', function() {
        if (this.value === 'petugas') {
            loketSection.style.display = 'block';
            kategoriSection.style.display = 'block';
        } else {
            loketSection.style.display = 'none';
            kategoriSection.style.display = 'none';
            // Uncheck all kategori checkboxes when role is not petugas
            const checkboxes = kategoriSection.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            // Reset loket selection
            document.getElementById('loket_id').value = '';
        }
    });

    // Show/hide kategori section for edit modal based on role selection
    editRoleSelect.addEventListener('change', function() {
        if (this.value === 'petugas') {
            editLoketSection.style.display = 'block';
            editKategoriSection.style.display = 'block';
        } else {
            editLoketSection.style.display = 'none';
            editKategoriSection.style.display = 'none';
            // Uncheck all kategori checkboxes when role is not petugas
            const checkboxes = editKategoriSection.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            // Reset loket selection
            document.getElementById('edit_loket_id').value = '';
        }
    });

    // Reset form when modal is closed
    addUserModal.addEventListener('hidden.bs.modal', function() {
        addUserForm.reset();
        confirmPassword.setCustomValidity('');
        loketSection.style.display = 'none';
        kategoriSection.style.display = 'none';
    });

    // Reset edit form when modal is closed
    editUserModal.addEventListener('hidden.bs.modal', function() {
        editUserForm.reset();
        editLoketSection.style.display = 'none';
        editKategoriSection.style.display = 'none';
        // Reset form action
        editUserForm.action = '';
    });

    // Show success message and close modal if there's a success message
    <?php if (session()->getFlashdata('message')) : ?>
        const modal = bootstrap.Modal.getInstance(addUserModal);
        if (modal) {
            modal.hide();
        }
    <?php endif; ?>

    // Handle edit form submission
    editUserForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const userId = document.getElementById('edit_user_id').value;
        
        // Send AJAX request to update user
        fetch(`<?= base_url('admin/pengguna/update/') ?>${userId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            // Try to parse JSON
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Response text:', text);
                    // Check if response contains HTML error page
                    if (text.includes('<!DOCTYPE html>') || text.includes('<html')) {
                        throw new Error('Server returned HTML error page instead of JSON response. Please check server logs.');
                    }
                    throw new Error('Invalid JSON response from server: ' + text.substring(0, 100));
                }
            });
        })
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row'));
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(editUserModal);
                if (modal) {
                    modal.hide();
                }
                
                // Reload page after a short delay to show updated data
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                // Show error message
                alert('Gagal memperbarui pengguna: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui pengguna: ' + error.message);
        });
    });
});
</script>
<?= $this->endSection(); ?>