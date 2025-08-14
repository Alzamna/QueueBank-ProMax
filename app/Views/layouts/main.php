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
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#64748b',
                        accent: '#1d4ed8',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                        dark: '#1e293b',
                        'primary-light': '#dbeafe',
                        'primary-dark': '#1e40af',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'elevated': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .sidebar-link {
                @apply flex items-center px-4 py-3 text-blue-100 hover:text-white hover:bg-white/15 rounded-lg transition-all duration-200 ease-in-out transform hover:translate-x-1;
            }
            .sidebar-link.active {
                @apply bg-gradient-to-r from-white/20 to-white/10 text-white shadow-lg shadow-blue-500/20 border border-white/20;
            }
            .sidebar-link:hover .sidebar-icon {
                @apply transform scale-110;
            }
            .sidebar-icon {
                @apply transition-transform duration-200 ease-in-out;
            }
            .sidebar-logout {
                @apply flex items-center px-4 py-3 text-blue-100 hover:text-white hover:bg-red-500/20 rounded-lg transition-all duration-200 ease-in-out border border-red-300/30 hover:border-red-400/50;
            }
            .btn-primary {
                @apply bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-all duration-200 ease-in-out shadow-md hover:shadow-lg transform hover:-translate-y-0.5;
            }
            .btn-outline {
                @apply border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-2.5 px-5 rounded-lg transition-all duration-200 ease-in-out hover:shadow-md;
            }
            .card {
                @apply bg-white rounded-xl shadow-soft border border-gray-100 p-6 transition-all duration-200 hover:shadow-elevated;
            }
            .form-input {
                @apply w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200;
            }
            .form-label {
                @apply block text-sm font-medium text-gray-700 mb-2;
            }
            .alert-danger {
                @apply bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-4;
            }
            .display-number {
                @apply text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-indigo-600;
            }
            .queue-card {
                @apply bg-white rounded-xl shadow-soft border border-gray-100 p-6 m-2 transition-all duration-200 hover:shadow-elevated;
            }
            .loket-card {
                @apply bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 text-white rounded-2xl p-8 m-2 text-center shadow-elevated;
            }
            .loket-number {
                @apply text-6xl font-bold;
            }
            .antrian-number {
                @apply text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-indigo-600;
            }
            .sidebar-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .sidebar-scrollbar::-webkit-scrollbar-track {
                @apply bg-transparent;
            }
            .sidebar-scrollbar::-webkit-scrollbar-thumb {
                @apply bg-blue-300/50 rounded-full;
            }
            .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
                @apply bg-blue-300/70;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <?php if (session()->get('logged_in')): ?>
        <!-- Fixed Top Navbar -->
        <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="<?= site_url() ?>" class="flex items-center text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            <i class="fas fa-building mr-2 text-blue-600"></i>
                            <span class="font-bold">QueueBank ProMax</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?= session()->get('nama_lengkap') ?></p>
                                <p class="text-xs text-gray-500 capitalize"><?= session()->get('role') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex pt-16">
            <!-- Fixed Sidebar -->
            <div class="w-64 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 fixed top-16 left-0 h-[calc(100vh-4rem)] shadow-xl z-40">
                <div class="h-full flex flex-col">
                    <!-- Logo/Brand -->
                    <div class="p-6 border-b border-blue-500/30">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-white/20 to-white/10 rounded-lg flex items-center justify-center border border-white/20">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-white font-bold text-lg">QueueBank</h1>
                                <p class="text-blue-100 text-xs">ProMax System</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-4 sidebar-scrollbar overflow-y-auto">
                        <div class="space-y-2">
                            <?php if (session()->get('role') === 'admin'): ?>
                                <a href="<?= site_url('admin/dashboard') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/dashboard') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-tachometer-alt sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="<?= site_url('admin/users') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/users') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-users sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Kelola Pengguna</span>
                                </a>
                                <a href="<?= site_url('admin/lokets') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/lokets') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-desktop sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Kelola Loket</span>
                                </a>
                                <a href="<?= site_url('admin/kategori') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/kategori') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-tags sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Kategori Antrian</span>
                                </a>
                                <a href="<?= site_url('admin/pengaturan') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/pengaturan') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-cog sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Pengaturan Display</span>
                                </a>
                                <a href="<?= site_url('admin/laporan') ?>" class="sidebar-link <?= strpos(current_url(), 'admin/laporan') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-chart-bar sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Laporan</span>
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('petugas/dashboard') ?>" class="sidebar-link <?= strpos(current_url(), 'petugas/dashboard') !== false ? 'active' : '' ?>">
                                    <i class="fas fa-tachometer-alt sidebar-icon w-5 mr-3"></i>
                                    <span class="font-medium">Dashboard Petugas</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </nav>

                    <!-- Logout Button at Bottom -->
                    <div class="p-4 border-t border-blue-500/30">
                        <a href="<?= site_url('logout') ?>" class="sidebar-logout">
                            <i class="fas fa-sign-out-alt sidebar-icon w-5 mr-3"></i>
                            <span class="font-medium">Logout</span>
                        </a>
                        <p class="text-blue-200 text-xs text-center mt-3">© 2024 QueueBank ProMax</p>
                    </div>
                </div>
            </div>

            <!-- Main Content with Scroll -->
            <div class="ml-64 pt-16 flex-1 overflow-y-auto">
                <main class="p-6">
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    <?php else: ?>
        <!-- Login/Public Pages -->
        <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100">
            <?= $this->renderSection('content') ?>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
