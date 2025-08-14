<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Nomor Antrian - QueueBank ProMax</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Professional Queue Number Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .queue-number-display {
            position: relative;
        }

        .queue-number {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 6rem;
            font-weight: 700;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            letter-spacing: 2px;
            margin: 0;
            line-height: 1;
        }

        .number-label {
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .category-info .badge {
            font-weight: 500;
            border-radius: 25px;
        }

        .status-item {
            padding: 1rem;
        }

        .status-icon {
            opacity: 0.8;
        }

        .status-label {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-value {
            font-size: 1.5rem;
        }

        .instruction-box {
            border-left: 4px solid #007bff;
        }

        .company-branding {
            opacity: 0.8;
        }

        .company-logo {
            color: #667eea;
        }

        /* Print-specific styles */
        @media print {
            .queue-number {
                font-size: 4rem;
                color: #000;
                text-shadow: none;
            }
            
            .status-value {
                font-size: 1.25rem;
            }
            
            .badge {
                background-color: #000 !important;
                color: #fff !important;
            }
        }

        /* Custom styles for standalone page */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .queue-machine {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1200px;
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid #667eea;
        }
        
        .header h1 {
            color: #667eea;
            font-weight: bold;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            color: #374151;
            font-size: 1.1rem;
            margin: 0;
            font-weight: 500;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 50px;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .btn-primary:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .loading {
            display: none;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.4);
        }
        
        .form-select {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
        }
        
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .mobile-mode-alert {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04);
            border: none;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .card.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .card.selected .card-title,
        .card.selected .card-text {
            color: white !important;
        }
        
        .card.selected .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .card.selected .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        /* Category Card Styling - Same as Desktop */
        .category-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .category-card.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }
        
        .category-card.selected .category-name {
            color: white;
        }
        
        .category-card.selected .category-description {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }
        
        .category-card.selected .text-dark {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .category-card.selected .text-primary {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .category-card.selected small {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .category-card.selected strong {
            color: rgba(255, 255, 255, 1) !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .category-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .category-description {
            color: #374151;
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.5;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Mobile-specific styles */
        .mobile-header {
            display: none;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
        }
        
        .mobile-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        .mobile-header p {
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.9;
        }
        
        .mobile-info-cards {
            display: none;
            margin-bottom: 1.5rem;
        }
        
        .mobile-info-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .mobile-info-card .card-title {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .mobile-info-card .card-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            margin: 0;
        }
        
        .mobile-service-cards {
            display: none;
            margin-bottom: 1.5rem;
        }
        
        .mobile-service-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .mobile-service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .mobile-service-card.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
        }
        
        .mobile-service-card .service-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .mobile-service-card .service-description {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            opacity: 0.8;
        }
        
        .mobile-service-card .service-prefix {
            font-size: 0.8rem;
            font-weight: 600;
            opacity: 0.9;
        }
        
        .mobile-bottom-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 1rem;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
            border-radius: 20px 20px 0 0;
            z-index: 1000;
        }
        
        .mobile-bottom-bar .btn {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 12px;
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .queue-machine {
                max-width: 95%;
                margin: 1rem auto;
            }
        }
        
        @media (max-width: 768px) {
            .queue-machine {
                max-width: 98%;
                padding: 1rem;
                margin: 1rem auto;
            }
            
            .category-card {
                height: 180px;
                padding: 1.5rem;
            }
            
            .category-name {
                font-size: 1.3rem;
            }
            
            .category-description {
                font-size: 0.9rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .header p {
                font-size: 1rem;
            }
        }
        
        /* Mobile-first responsive design */
        @media (max-width: 480px) {
            .header, .main-content, .running-text {
                display: none;
            }
            
            .mobile-header {
                display: block;
            }
            
            .mobile-info-cards {
                display: block;
            }
            
            .mobile-service-cards {
                display: block;
            }
            
            .mobile-bottom-bar {
                display: block;
            }
            
            .queue-machine {
                padding: 0.5rem;
                margin: 0.5rem auto;
                border-radius: 15px;
            }
            
            .queue-machine {
                margin-bottom: 100px; /* Space for bottom bar */
            }
            
            /* Optimize for touch devices */
            .mobile-service-card {
                padding: 1.25rem;
                margin-bottom: 0.75rem;
            }
            
            .mobile-service-card .service-name {
                font-size: 1.1rem;
            }
            
            .mobile-service-card .service-description {
                font-size: 0.85rem;
            }
            
            .mobile-bottom-bar .btn {
                padding: 0.875rem;
                font-size: 1rem;
            }
        }
        
        /* Landscape orientation adjustments */
        @media (max-width: 480px) and (orientation: landscape) {
            .mobile-header h1 {
                font-size: 1.5rem;
            }
            
            .mobile-header p {
                font-size: 0.8rem;
            }
            
            .mobile-info-cards {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
            
            .mobile-info-card {
                margin-bottom: 0;
                padding: 0.75rem;
            }
            
            .mobile-info-card .card-title {
                font-size: 0.7rem;
            }
            
            .mobile-info-card .card-value {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
            <div class="container">
            <div class="queue-machine">
            <!-- Desktop Header -->
                <div class="header">
                    <h1><i class="fas fa-ticket-alt"></i> MESIN ANTRIAN</h1>
                    <p>Silakan pilih kategori layanan dan ambil nomor antrian</p>
                <div class="text-muted mb-3">
                    <small><i class="fas fa-mobile-alt"></i> Tersedia dalam 2 tampilan</small>
                </div>
                <!-- Switch to Mobile View Button -->
                <div class="d-flex gap-2 justify-content-center">
                    <a href="/antrian/desktop" class="btn btn-light btn-sm active">
                        <i class="fas fa-desktop"></i> Desktop
                    </a>
                    <a href="/antrian/mobile" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-mobile-alt"></i> Mobile
                    </a>
                </div>
            </div>
            

        
        <!-- Current Queue Status (Mobile) -->
        <div class="row justify-content-center mb-4" id="currentQueueStatus" style="display: none;">
            <div class="col-md-8">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-ticket-alt"></i> Nomor Antrian Aktif Anda
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="queue-number-display mb-3">
                            <div class="number-label text-uppercase text-muted mb-2">Nomor Antrian</div>
                            <div class="queue-number" id="currentNomorAntrian">-</div>
                            <div class="category-info mt-3">
                                <span class="badge bg-success fs-6 px-3 py-2" id="currentKategoriAntrian">-</span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="status-item">
                                    <div class="status-icon text-info mb-2">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <div class="status-label text-muted">Posisi Antrian</div>
                                    <div class="status-value fw-bold text-info" id="currentPosisiAntrian">-</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="status-item">
                                    <div class="status-icon text-success mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <div class="status-label text-muted">Estimasi Waktu</div>
                                    <div class="status-value fw-bold text-success" id="currentEstimasiWaktu">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-success me-2" onclick="refreshQueueStatus()">
                                <i class="fas fa-sync-alt"></i> Refresh Status
                            </button>
                            <button class="btn btn-success" onclick="printCurrentQueue()">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Debug information -->
        <?php if(empty($kategori)): ?>
            <div class="alert alert-warning">
                <strong>Debug Info:</strong> Tidak ada kategori yang ditemukan. 
                <br>Total kategori: <?= count($kategori ?? []) ?>
                <br>Kategori data: <?= json_encode($kategori ?? []) ?>
            </div>
        <?php endif; ?>
        
            <!-- Desktop Categories -->
        <div class="row" id="categories">
            <?php foreach ($kategori as $kat): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="category-card" data-kategori-id="<?= $kat['id'] ?>">
                    <div class="category-name"><?= $kat['nama_kategori'] ?></div>
                    <div class="category-description"><?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?></div>
                    <div class="text-dark text-center">
                        <small class="fw-semibold">Prefix: <strong class="text-primary"><?= $kat['prefix'] ?></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
        </div>
        

            
            <!-- Desktop Action Button -->
            <div class="row mt-4" id="desktopActionButton">
            <div class="col-12">
                <button class="btn btn-primary" id="btnAmbil" disabled>
                    <span class="btn-text">Pilih kategori terlebih dahulu</span>
                    <span class="loading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Memproses...
                    </span>
                </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal untuk menampilkan nomor antrian -->
    <div class="modal fade" id="nomorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h4 class="modal-title mb-0">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Nomor Antrian Anda
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <div class="company-branding mb-4">
                        <div class="company-logo mb-3">
                            <i class="fas fa-building fa-3x text-primary"></i>
                        </div>
                        <h5 class="text-muted mb-0">QueueBank ProMax</h5>
                        <small class="text-muted">Sistem Antrian Modern</small>
                    </div>
                    
                    <div class="queue-number-display mb-4">
                        <div class="number-label text-uppercase text-muted mb-2">Nomor Antrian</div>
                        <div class="queue-number" id="nomorAntrian">-</div>
                        <div class="category-info mt-3">
                            <span class="badge bg-primary fs-6 px-3 py-2" id="kategoriAntrian">-</span>
                        </div>
                    </div>
                    
                    <div class="queue-status mb-4">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="status-item">
                                    <div class="status-icon text-info mb-2">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <div class="status-label text-muted">Antrian di Depan</div>
                                    <div class="status-value fw-bold text-info" id="posisiAntrian">-</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="status-item">
                                    <div class="status-icon text-success mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <div class="status-label text-muted">Estimasi Waktu</div>
                                    <div class="status-value fw-bold text-success" id="estimasiWaktu">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="instruction-box bg-light rounded p-3">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <span id="waktuTunggu" class="text-muted">Silakan tunggu panggilan di display</span>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printAntrian()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Check current queue status on page load
    document.addEventListener('DOMContentLoaded', function() {
        checkCurrentQueueStatus();
        setupCardSelection();
        setupActionButton();
    });
    
    function setupActionButton() {
        // Desktop action button event listener
        document.getElementById('btnAmbil').addEventListener('click', function() {
            const selectedCard = document.querySelector('.category-card.selected');
            if (selectedCard) {
                const kategoriId = selectedCard.dataset.kategoriId;
                const kategoriNama = selectedCard.querySelector('.category-name').textContent;
                ambilNomor(kategoriId, kategoriNama, {target: this});
            }
        });
    }
    

    
    function setupCardSelection() {
        // Add click event to desktop category cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selection from all cards
                document.querySelectorAll('.category-card').forEach(c => {
                    c.classList.remove('selected');
                });
                
                // Add selection to clicked card
                this.classList.add('selected');
                
                // Enable action button
                const btn = document.getElementById('btnAmbil');
                btn.disabled = false;
                btn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
                
                // Auto-remove selection after 3 seconds
                setTimeout(() => {
                    this.classList.remove('selected');
                    btn.disabled = true;
                    btn.querySelector('.btn-text').textContent = 'Pilih kategori terlebih dahulu';
                }, 3000);
            });
        });
    }



    function checkCurrentQueueStatus() {
        $.ajax({
            url: '/cek-status-mobile',
            type: 'GET',
            success: function(response) {
                if (response.success && response.antrian) {
                    showCurrentQueueStatus(response);
                } else {
                    hideCurrentQueueStatus();
                }
            },
            error: function() {
                hideCurrentQueueStatus();
            }
        });
    }

    function showCurrentQueueStatus(data) {
        const antrian = data.antrian;
        
        $('#currentNomorAntrian').text(antrian.nomor_antrian);
        $('#currentKategoriAntrian').text(antrian.nama_kategori);
        $('#currentPosisiAntrian').text(data.posisi_antrian + 1);
        
        // Calculate estimated wait time
        const estimatedMinutes = data.posisi_antrian * 5;
        if (estimatedMinutes > 0) {
            $('#currentEstimasiWaktu').text(estimatedMinutes + ' menit');
        } else {
            $('#currentEstimasiWaktu').text('Segera dipanggil');
        }
        
        $('#currentQueueStatus').show();
    }

    function hideCurrentQueueStatus() {
        $('#currentQueueStatus').hide();
    }

    function refreshQueueStatus() {
        checkCurrentQueueStatus();
    }

    function printCurrentQueue() {
        const nomor = $('#currentNomorAntrian').text();
        const kategori = $('#currentKategoriAntrian').text();
        const posisi = $('#currentPosisiAntrian').text();
        const estimasi = $('#currentEstimasiWaktu').text();
        
        printQueue(nomor, kategori, posisi, estimasi);
    }

    function ambilNomor(kategoriId, kategoriNama, event) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        button.disabled = true;
        
        // Debug: log data being sent
        console.log('Sending data:', {kategori_id: parseInt(kategoriId)});
        console.log('KategoriId type:', typeof kategoriId);
        console.log('KategoriId value:', kategoriId);
        
        // Validate input
        if (!kategoriId || isNaN(parseInt(kategoriId))) {
            alert('Error: Invalid kategori ID: ' + kategoriId);
            button.innerHTML = originalText;
            button.disabled = false;
            return;
        }
        
        $.ajax({
            url: '/ambil-nomor',
            type: 'POST',
            data: {kategori_id: parseInt(kategoriId)},
            success: function(response) {
                console.log('Response received:', response);
            if(response.success) {
                    // Check if this is an existing queue number
                    if (response.existing) {
                        alert('Anda sudah memiliki nomor antrian aktif: ' + response.nomor_antrian);
                        checkCurrentQueueStatus(); // Refresh status
                        return;
                    }

                $('#nomorAntrian').text(response.nomor_antrian);
                $('#kategoriAntrian').text(kategoriNama);
                
                // Display queue position
                if(response.posisi_antrian > 0) {
                    $('#posisiAntrian').text(response.posisi_antrian);
                } else {
                    $('#posisiAntrian').text('0');
                }
                
                // Calculate estimated wait time (assuming 5 minutes per person)
                const estimatedMinutes = response.posisi_antrian * 5;
                if(estimatedMinutes > 0) {
                    $('#estimasiWaktu').text(estimatedMinutes + ' menit');
                } else {
                    $('#estimasiWaktu').text('Segera dipanggil');
                }
                
                $('#waktuTunggu').text('Silakan tunggu panggilan di display. Jaga jarak dan patuhi protokol kesehatan.');
                
                $('#nomorModal').modal('show');
                    
                    // Refresh current queue status
                    checkCurrentQueueStatus();
            } else {
                // Show error message
                alert('Gagal mengambil nomor antrian: ' + (response.message || 'Terjadi kesalahan'));
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors
                console.error('AJAX Error:', {xhr, status, error});
                console.error('Response Text:', xhr.responseText);
                
                let errorMessage = 'Terjadi kesalahan pada server';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 0) {
                    errorMessage = 'Tidak dapat terhubung ke server';
                } else if (xhr.status === 500) {
                    errorMessage = 'Kesalahan internal server';
                }
                
                alert('Error: ' + errorMessage);
        },
        complete: function() {
            // Reset button state
            button.innerHTML = originalText;
            button.disabled = false;
        }
        });
    }

    function printAntrian() {
        const nomor = $('#nomorAntrian').text();
        const kategori = $('#kategoriAntrian').text();
        const posisi = $('#posisiAntrian').text();
        const estimasi = $('#estimasiWaktu').text();
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Nomor Antrian - QueueBank ProMax</title>
                    <style>
                        /* Print styles optimized for queue ticket paper (A6 size: 105mm x 148mm) */
                        @media print {
                            @page {
                                size: A6;
                                margin: 5mm;
                            }
                            body { 
                                margin: 0; 
                                padding: 0;
                                width: 105mm;
                                height: 148mm;
                            }
                            .print-container { 
                                page-break-inside: avoid;
                                width: 100%;
                                height: 100%;
                            }
                            * {
                                -webkit-print-color-adjust: exact;
                                color-adjust: exact;
                            }
                        }
                        
                        body { 
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                            text-align: center; 
                            margin: 0; 
                            padding: 0;
                            background: #fff;
                            width: 105mm;
                            height: 148mm;
                            overflow: hidden;
                        }
                        
                        .print-container {
                            width: 100%;
                            height: 100%;
                            padding: 8mm;
                            box-sizing: border-box;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                        }
                        
                        .company-header {
                            border-bottom: 2px solid #667eea;
                            padding-bottom: 8mm;
                            margin-bottom: 6mm;
                        }
                        
                        .company-logo {
                            font-size: 24px;
                            color: #667eea;
                            margin-bottom: 3mm;
                        }
                        
                        .company-name {
                            font-size: 16px;
                            font-weight: 700;
                            color: #2c3e50;
                            margin: 0;
                            letter-spacing: 0.5px;
                        }
                        
                        .company-tagline {
                            font-size: 10px;
                            color: #7f8c8d;
                            margin: 2mm 0 0 0;
                            font-weight: 300;
                        }
                        
                        .queue-number-section {
                            margin: 8mm 0;
                            padding: 6mm;
                            border: 2px solid #667eea;
                            border-radius: 8px;
                            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                            flex-grow: 1;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                        }
                        
                        .number-label {
                            font-size: 10px;
                            font-weight: 600;
                            color: #495057;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            margin-bottom: 4mm;
                        }
                        
                        .queue-number {
                            font-size: 36px;
                            font-weight: 800;
                            color: #2c3e50;
                            margin: 4mm 0;
                            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
                            letter-spacing: 1px;
                            line-height: 1;
                        }
                        
                        .category-badge {
                            display: inline-block;
                            background: #667eea;
                            color: white;
                            padding: 3mm 6mm;
                            border-radius: 12px;
                            font-size: 10px;
                            font-weight: 600;
                            margin: 4mm 0;
                        }
                        
                        .queue-info {
                            margin: 6mm 0;
                            padding: 4mm;
                            background: #fff;
                            border-radius: 6px;
                            border: 1px solid #dee2e6;
                            font-size: 9px;
                        }
                        
                        .info-row {
                            display: flex;
                            justify-content: space-between;
                            margin: 2mm 0;
                            padding: 1mm 0;
                            border-bottom: 0.5px solid #f1f3f4;
                        }
                        
                        .info-label {
                            font-weight: 600;
                            color: #495057;
                            font-size: 9px;
                        }
                        
                        .info-value {
                            font-weight: 700;
                            color: #2c3e50;
                            font-size: 9px;
                        }
                        
                        .footer {
                            margin-top: 6mm;
                            padding-top: 4mm;
                            border-top: 1px solid #dee2e6;
                            color: #6c757d;
                            font-size: 8px;
                            line-height: 1.3;
                        }
                        
                        /* Additional print optimizations */
                        .print-container * {
                            box-sizing: border-box;
                        }
                        
                        /* Ensure text is readable on small paper */
                        .queue-number {
                            -webkit-text-stroke: 0.5px #2c3e50;
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        <div class="company-header">
                            <div class="company-logo">🏢</div>
                            <h1 class="company-name">QueueBank ProMax</h1>
                            <p class="company-tagline">Sistem Antrian Modern & Profesional</p>
                        </div>
                        
                        <div class="queue-number-section">
                            <div class="number-label">Nomor Antrian</div>
                            <div class="queue-number">${nomor}</div>
                            <div class="category-badge">${kategori}</div>
                        </div>
                        
                        <div class="queue-info">
                            <div class="info-row">
                                <span class="info-label">Tanggal:</span>
                                <span class="info-value">${new Date().toLocaleDateString('id-ID', { 
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                })}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Waktu:</span>
                                <span class="info-value">${new Date().toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                })}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Antrian di Depan:</span>
                                <span class="info-value">${posisi}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Estimasi Waktu:</span>
                                <span class="info-value">${estimasi}</span>
                            </div>
                        </div>
                        
                        <div class="footer">
                            <p><strong>Petunjuk:</strong> Silakan tunggu panggilan di display</p>
                            <p>Terima kasih atas kunjungan Anda</p>
                        </div>
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
        
        // Wait for content to load then print
        printWindow.onload = function() {
            // Set print options for better quality
            printWindow.focus();
            
            // Small delay to ensure content is fully rendered
            setTimeout(function() {
                printWindow.print();
            }, 500);
        };
    }
    </script>
</body>
</html>