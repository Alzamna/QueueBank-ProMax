<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Kelola Kategori Pengguna</h1>
            <p class="text-muted">Atur kategori layanan yang dapat diakses oleh setiap petugas</p>
        </div>
    </div>

    <!-- User Category Management -->
    <div class="row">
        <!-- Left Column - User List -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-blue-600 mr-2"></i>
                        Daftar Petugas
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach($users as $user): ?>
                            <div class="list-group-item border-0 py-3 px-4 user-item" 
                                 data-user-id="<?= $user['id'] ?>" 
                                 onclick="selectUser(<?= $user['id'] ?>, '<?= $user['nama_lengkap'] ?>')">
                                <div class="d-flex align-items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user-tie text-white text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-1 text-gray-800"><?= $user['nama_lengkap'] ?></h6>
                                        <small class="text-muted">@<?= $user['username'] ?></small>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="badge bg-primary"><?= ucfirst($user['role']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Category Assignment -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags text-green-600 mr-2"></i>
                        <span id="selected-user-text">Pilih Petugas</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div id="category-assignment-form" style="display: none;">
                        <form id="assignKategoriForm">
                            <input type="hidden" id="selected-user-id" name="user_id">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Kategori Layanan:</label>
                                <div class="row">
                                    <?php foreach($kategori as $kat): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input kategori-checkbox" 
                                                       type="checkbox" 
                                                       name="kategori_ids[]" 
                                                       value="<?= $kat['id'] ?>" 
                                                       id="kategori_<?= $kat['id'] ?>">
                                                <label class="form-check-label" for="kategori_<?= $kat['id'] ?>">
                                                    <div class="d-flex align-items-center">
                                                        <div class="w-8 h-8 bg-light rounded-full flex items-center justify-center mr-2">
                                                            <?php
                                                            $icon = 'fa-users';
                                                            if (strpos(strtolower($kat['nama_kategori']), 'teller') !== false) $icon = 'fa-cash-register';
                                                            elseif (strpos(strtolower($kat['nama_kategori']), 'cs') !== false || strpos(strtolower($kat['nama_kategori']), 'customer') !== false) $icon = 'fa-headset';
                                                            elseif (strpos(strtolower($kat['nama_kategori']), 'prioritas') !== false) $icon = 'fa-star';
                                                            ?>
                                                            <i class="fas <?= $icon ?> text-gray-600"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold"><?= $kat['nama_kategori'] ?></div>
                                                            <small class="text-muted"><?= $kat['prefix'] ?></small>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end space-x-3">
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo mr-2"></i>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Penugasan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="no-user-selected" class="text-center py-5">
                        <i class="fas fa-hand-pointer text-gray-300 fa-3x mb-3"></i>
                        <h5 class="text-gray-500">Pilih petugas untuk mengatur kategori layanan</h5>
                        <p class="text-muted">Klik pada nama petugas di sebelah kiri untuk memulai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Assignments Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list text-purple-600 mr-2"></i>
                        Penugasan Saat Ini
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">Petugas</th>
                                    <th class="border-0 px-4 py-3">Username</th>
                                    <th class="border-0 px-4 py-3">Kategori</th>
                                    <th class="border-0 px-4 py-3">Prefix</th>
                                    <th class="border-0 px-4 py-3">Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($userKategori)): ?>
                                    <?php foreach($userKategori as $uk): ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-user-tie text-white text-xs"></i>
                                                    </div>
                                                    <span class="fw-semibold"><?= $uk['nama_lengkap'] ?></span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-muted">@<?= $uk['username'] ?></span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="fw-semibold"><?= $uk['nama_kategori'] ?></span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-light text-dark"><?= $uk['prefix'] ?></span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($uk['created_at'])) ?></small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-inbox text-gray-300 fa-2x mb-3"></i>
                                            <p class="text-muted">Belum ada penugasan kategori</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedUserId = null;

function selectUser(userId, userName) {
    selectedUserId = userId;
    
    // Update UI
    $('.user-item').removeClass('active');
    $(`.user-item[data-user-id="${userId}"]`).addClass('active');
    
    $('#selected-user-text').text(`Kategori untuk ${userName}`);
    $('#selected-user-id').val(userId);
    
    // Show form, hide no-user message
    $('#category-assignment-form').show();
    $('#no-user-selected').hide();
    
    // Load current user categories
    loadUserCategories(userId);
}

function loadUserCategories(userId) {
    $.ajax({
        url: `<?= base_url('admin/getUserKategori') ?>/${userId}`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Reset all checkboxes
                $('.kategori-checkbox').prop('checked', false);
                
                // Check categories assigned to this user
                response.userKategori.forEach(function(uk) {
                    $(`#kategori_${uk.kategori_id}`).prop('checked', true);
                });
            }
        },
        error: function() {
            console.error('Failed to load user categories');
        }
    });
}

function resetForm() {
    if (selectedUserId) {
        loadUserCategories(selectedUserId);
    }
}

$(document).ready(function() {
    $('#assignKategoriForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!selectedUserId) {
            alert('Pilih petugas terlebih dahulu');
            return;
        }
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url('admin/assignKategori') ?>',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    // Reload the page to show updated assignments
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan data');
            }
        });
    });
});
</script>

<style>
.user-item {
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-item:hover {
    background-color: #f8f9fa;
}

.user-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.kategori-checkbox:checked + label {
    color: #2196f3;
    font-weight: 600;
}

.form-check-input:checked {
    background-color: #2196f3;
    border-color: #2196f3;
}
</style>
<?= $this->endSection() ?>
