<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'QueueBank ProMax' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6c757d;
            --secondary-color: #f8f9fa;
            --accent-color: #007bff;
            --text-color: #212529;
            --border-color: #dee2e6;
        }

        body {
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .sidebar {
            background-color: #fff;
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 4px rgba(0,0,0,.1);
        }

        .sidebar .nav-link {
            color: var(--text-color);
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--secondary-color);
            color: var(--accent-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: #fff;
        }

        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .display-number {
            font-size: 4rem;
            font-weight: bold;
            color: var(--accent-color);
        }

        .queue-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }

        .running-text {
            background-color: var(--accent-color);
            color: #fff;
            padding: 10px 0;
            overflow: hidden;
        }

        .running-text p {
            white-space: nowrap;
            animation: scroll-left 20s linear infinite;
        }

        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .loket-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 15px;
            padding: 30px;
            margin: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,.2);
        }

        .loket-number {
            font-size: 3rem;
            font-weight: bold;
        }

        .antrian-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <?php if (session()->get('logged_in')): ?>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <i class="fas fa-building"></i> QueueBank ProMax
                </a>
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text me-3">
                        Selamat datang, <?= session()->get('nama_lengkap') ?>
                    </span>
                    <a class="btn btn-outline-danger btn-sm" href="/logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="sidebar">
                        <div class="d-flex flex-column p-3">
                            <?php if (session()->get('role') === 'admin'): ?>
                                <a href="/admin/dashboard" class="nav-link">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                                <a href="/admin/users" class="nav-link">
                                    <i class="fas fa-users"></i> Kelola Pengguna
                                </a>
                                <a href="/admin/lokets" class="nav-link">
                                    <i class="fas fa-desktop"></i> Kelola Loket
                                </a>
                                <a href="/admin/kategori" class="nav-link">
                                    <i class="fas fa-tags"></i> Kategori Antrian
                                </a>
                                <a href="/admin/pengaturan" class="nav-link">
                                    <i class="fas fa-cog"></i> Pengaturan Display
                                </a>
                                <a href="/admin/laporan" class="nav-link">
                                    <i class="fas fa-chart-bar"></i> Laporan
                                </a>
                            <?php else: ?>
                                <a href="/petugas/dashboard" class="nav-link">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard Petugas
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-lg-10">
                    <main class="p-4">
                        <?= $this->renderSection('content') ?>
                    </main>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
