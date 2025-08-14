<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'QueueBank ProMax' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('app/Views/layouts/main.css') ?>" rel="stylesheet">
</head>
<body>
    <?php if (session()->get('logged_in')): ?>
        <!-- Fixed Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">
                    <i class="fas fa-qrcode me-2"></i>
                    QueueBank ProMax
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-1"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i>
                                Pengaturan
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('admin/pengguna/pengguna') ?>">Kelola Pengguna</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/lokets') ?>">Loket</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/kategori') ?>">Kategori</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Main Content with Sidebar -->
        <div class="d-flex" style="margin-top: 76px;">
            <!-- Sidebar -->
            <div class="bg-dark text-white" style="width: 250px; min-height: calc(100vh - 76px);">
                <div class="p-3">
                    <h6 class="text-white-50 text-uppercase small mb-3">Menu Utama</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/pengguna/pengguna') ?>">
                                <i class="fas fa-users me-2"></i>
                                Kelola Pengguna
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/lokets') ?>">
                                <i class="fas fa-door-open me-2"></i>
                                Loket
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/kategori') ?>">
                                <i class="fas fa-list me-2"></i>
                                Kategori Antrian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/pengaturan') ?>">
                                <i class="fas fa-cog me-2"></i>
                                Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white-50" href="<?= base_url('admin/laporan') ?>">
                                <i class="fas fa-chart-bar me-2"></i>
                                Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="flex-grow-1 p-4">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Public Content (No Sidebar) -->
        <div class="container-fluid">
            <?= $this->renderSection('content') ?>
        </div>
    <?php endif; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
