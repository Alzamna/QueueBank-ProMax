<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning fa-4x"></i>
                    </div>
                    <h3 class="text-gray-800 mb-3"><?= $title ?? 'Akses Dibatasi' ?></h3>
                    <p class="text-muted mb-4"><?= $message ?? 'Anda tidak memiliki akses ke halaman ini.' ?></p>
                    
                    <div class="d-flex justify-content-center space-x-3">
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-secondary">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </a>
                        <a href="<?= base_url('petugas/dashboard') ?>" class="btn btn-primary">
                            <i class="fas fa-refresh mr-2"></i>
                            Coba Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
