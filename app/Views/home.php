<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueueBank ProMax - Sistem Antrian Digital</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 2rem auto;
            max-width: 1200px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .hero-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .hero-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .main-content {
            padding: 3rem 2rem;
        }
        
        .service-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
            text-decoration: none;
            color: inherit;
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .service-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        .service-description {
            color: #374151;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .service-features {
            list-style: none;
            padding: 0;
        }
        
        .service-features li {
            padding: 0.5rem 0;
            color: #4b5563;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .service-features li i {
            color: var(--success-color);
            margin-right: 0.75rem;
            font-size: 0.875rem;
        }
        
        .stats-section {
            background: var(--light-color);
            padding: 2rem;
            border-radius: 16px;
            margin: 2rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #374151;
            font-weight: 600;
        }
        
        .footer {
            background: var(--dark-color);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
            border-radius: 20px 20px 0 0;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .main-content {
                padding: 2rem 1rem;
            }
            
            .service-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-header">
                <h1 class="hero-title">
                    <i class="fas fa-qrcode me-3"></i>
                    QueueBank ProMax
                </h1>
                <p class="hero-subtitle">
                    Sistem Antrian Digital Modern untuk Layanan Perbankan yang Lebih Efisien
                </p>
            </div>
            
            <div class="main-content">
                <!-- Service Cards -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <a href="<?= base_url('antrian') ?>" class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h3 class="service-title">Antrian Mobile</h3>
                            <p class="service-description">
                                Ambil nomor antrian langsung dari smartphone Anda. 
                                Sistem akan mengingat nomor antrian Anda bahkan setelah browser ditutup.
                            </p>
                            <ul class="service-features">
                                <li><i class="fas fa-check-circle"></i> Ambil antrian dari mana saja</li>
                                <li><i class="fas fa-check-circle"></i> Nomor tersimpan otomatis</li>
                                <li><i class="fas fa-check-circle"></i> Cek status real-time</li>
                                <li><i class="fas fa-check-circle"></i> Tidak perlu login</li>
                            </ul>
                            <div class="text-center mt-3">
                                <span class="btn btn-primary-custom">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    Ambil Antrian Mobile
                                </span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <a href="<?= base_url('desktop') ?>" class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h3 class="service-title">Mesin Antrian</h3>
                            <p class="service-description">
                                Interface khusus untuk mesin antrian di lokasi bank. 
                                Setiap klik menghasilkan nomor antrian baru secara otomatis.
                            </p>
                            <ul class="service-features">
                                <li><i class="fas fa-check-circle"></i> Interface touch-friendly</li>
                                <li><i class="fas fa-check-circle"></i> Generate nomor otomatis</li>
                                <li><i class="fas fa-check-circle"></i> Statistik real-time</li>
                                <li><i class="fas fa-check-circle"></i> Kategori layanan lengkap</li>
                            </ul>
                            <div class="text-center mt-3">
                                <span class="btn btn-primary-custom">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    Akses Mesin Antrian
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Statistics Section -->
                <div class="stats-section">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-chart-line me-2"></i>
                        Statistik Layanan
                    </h4>
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <div class="stat-number" id="totalAntrian">0</div>
                                <div class="stat-label">Total Antrian</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <div class="stat-number" id="antrianMenunggu">0</div>
                                <div class="stat-label">Sedang Menunggu</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <div class="stat-number" id="antrianDipanggil">0</div>
                                <div class="stat-label">Sedang Dipanggil</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <div class="stat-number" id="antrianSelesai">0</div>
                                <div class="stat-label">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="row mt-4">
                    <div class="col-md-8 mx-auto text-center">
                        <div class="alert alert-info border-0" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 12px;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Info:</strong> Sistem antrian ini mendukung dual-source untuk memberikan fleksibilitas maksimal. 
                            Pengguna dapat mengambil antrian melalui mobile atau mesin antrian desktop dengan nomor yang berurutan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-building me-2"></i>QueueBank ProMax</h5>
                    <p class="mb-0">Sistem Antrian Digital Terdepan</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Layanan 24/7 | 
                        <i class="fas fa-shield-alt me-2"></i>
                        Aman & Terpercaya
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Load statistics on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            
            // Refresh statistics every 30 seconds
            setInterval(loadStatistics, 30000);
        });
        
        function loadStatistics() {
            fetch('<?= base_url('statistik-antrian') ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStatistics(data.statistik);
                    }
                })
                .catch(error => {
                    console.log('Error loading statistics:', error);
                });
        }
        
        function updateStatistics(stats) {
            let totalAntrian = 0;
            let totalMenunggu = 0;
            let totalDipanggil = 0;
            let totalSelesai = 0;
            
            stats.forEach(stat => {
                totalAntrian += stat.total_antrian;
                totalMenunggu += stat.total_antrian;
                totalDipanggil += stat.antrian_dipanggil || 0;
            });
            
            // Get completed count from another endpoint or calculate
            totalSelesai = Math.max(0, totalAntrian - totalMenunggu - totalDipanggil);
            
            document.getElementById('totalAntrian').textContent = totalAntrian;
            document.getElementById('antrianMenunggu').textContent = totalMenunggu;
            document.getElementById('antrianDipanggil').textContent = totalDipanggil;
            document.getElementById('antrianSelesai').textContent = totalSelesai;
        }
    </script>
</body>
</html>
