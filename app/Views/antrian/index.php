<?= $this->extend('layouts/main') ?>

<style>
/* Professional Queue Number Styles */
.queue-number-container {
    margin: 2rem 0;
}

.queue-number-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}

.queue-number-badge::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: rotate(45deg);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.queue-number-label {
    color: rgba(255,255,255,0.9);
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 1rem;
}

.queue-number-display {
    color: white;
    font-size: 4rem;
    font-weight: 900;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    font-family: 'Arial Black', sans-serif;
}

.info-card {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.info-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: #495057;
}

.decorative-line {
    height: 2px;
    background: linear-gradient(90deg, transparent, #007bff, transparent);
    border-radius: 1px;
}

/* Print Styles */
@media print {
    .modal-header, .modal-footer, .btn-close {
        display: none !important;
    }
    
    .modal {
        position: static !important;
        display: block !important;
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
    }
    
    .modal-dialog {
        max-width: none !important;
        margin: 0 !important;
    }
    
    .modal-content {
        border: none !important;
        box-shadow: none !important;
    }
    
    .queue-number-badge {
        background: #f8f9fa !important;
        border: 3px solid #333 !important;
        box-shadow: none !important;
    }
    
    .queue-number-label {
        color: #333 !important;
    }
    
    .queue-number-display {
        color: #333 !important;
        text-shadow: none !important;
    }
    
    .info-card {
        background: white !important;
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
    
    .info-text {
        color: #333 !important;
    }
    
    .decorative-line {
        background: #333 !important;
    }
    
    body {
        margin: 0 !important;
        padding: 20px !important;
    }
}
</style>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-center">Ambil Nomor Antrian</h1>
    
    <!-- Debug information -->
    <?php if(empty($kategori)): ?>
        <div class="alert alert-warning">
            <strong>Debug Info:</strong> Tidak ada kategori yang ditemukan. 
            <br>Total kategori: <?= count($kategori ?? []) ?>
            <br>Kategori data: <?= json_encode($kategori ?? []) ?>
        </div>
    <?php endif; ?>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pilih Kategori Layanan</h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($kategori)): ?>
                        <div class="row">
                            <?php foreach($kategori as $kat): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?= $kat['nama_kategori'] ?></h5>
                                            <p class="card-text"><?= $kat['deskripsi'] ?></p>
                                            <button class="btn btn-primary btn-lg" onclick="ambilNomor(<?= $kat['id'] ?>, '<?= $kat['nama_kategori'] ?>', event)">
                                                Ambil Nomor
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <p>Tidak ada kategori layanan yang tersedia saat ini.</p>
                            <p>Silakan hubungi administrator untuk mengatur kategori layanan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cek Status Antrian</h5>
                </div>
                <div class="card-body">
                    <form id="cekStatusForm">
                        <div class="mb-3">
                            <label for="nomor_antrian" class="form-label">Nomor Antrian</label>
                            <input type="text" class="form-control" id="nomor_antrian" placeholder="Masukkan nomor antrian">
                        </div>
                        <button type="submit" class="btn btn-info">Cek Status</button>
                    </form>
                    <div id="statusResult" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan nomor antrian -->
<div class="modal fade" id="nomorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Nomor Antrian Anda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <!-- Queue Number Display -->
                <div class="queue-number-container mb-4">
                    <div class="queue-number-badge">
                        <span class="queue-number-label">NOMOR ANTRIAN</span>
                        <h1 id="nomorAntrian" class="queue-number-display"></h1>
                    </div>
                </div>
                
                <!-- Queue Information -->
                <div class="queue-info-container">
                    <div class="info-card mb-3">
                        <i class="fas fa-tag text-primary me-2"></i>
                        <span id="kategoriAntrian" class="info-text"></span>
                    </div>
                    
                    <div class="info-card mb-3">
                        <i class="fas fa-users text-info me-2"></i>
                        <span id="posisiAntrian" class="info-text"></span>
                    </div>
                    
                    <div class="info-card">
                        <i class="fas fa-clock text-warning me-2"></i>
                        <span id="waktuTunggu" class="info-text"></span>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="decorative-line mt-4 mb-3"></div>
                <p class="text-muted small">QueueBank ProMax - Sistem Antrian Digital</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="printAntrian()">
                    <i class="fas fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function ambilNomor(kategoriId, kategoriNama, event) {
    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    button.disabled = true;
    
    // Get CSRF token from cookie
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    
    const csrfToken = getCookie('csrf_cookie_name');
    
    $.ajax({
        url: '/ambil-nomor',
        type: 'POST',
        data: {kategori_id: kategoriId},
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
        if(response.success) {
            $('#nomorAntrian').text(response.nomor_antrian);
            $('#kategoriAntrian').text('Kategori: ' + kategoriNama);
            
            // Display queue position
            if(response.posisi_antrian > 0) {
                $('#posisiAntrian').text('Jumlah Antrian di Depan: ' + response.posisi_antrian);
            } else {
                $('#posisiAntrian').text('Jumlah Antrian di Depan: 0');
            }
            
            $('#waktuTunggu').text('Silakan tunggu panggilan di display');
            
            $('#nomorModal').modal('show');
        } else {
            // Show error message
            alert('Gagal mengambil nomor antrian: ' + (response.message || 'Terjadi kesalahan'));
        }
    },
    error: function(xhr, status, error) {
        // Handle AJAX errors
        alert('Terjadi kesalahan: ' + error);
    },
    complete: function() {
        // Reset button state
        button.innerHTML = originalText;
        button.disabled = false;
    }
    });
}

$('#cekStatusForm').on('submit', function(e) {
    e.preventDefault();
    const nomor = $('#nomor_antrian').val();
    
    $.get('/cek-status/' + nomor, function(response) {
        let html = '';
        if(response.success === false) {
            html = '<div class="alert alert-danger">Nomor antrian tidak ditemukan</div>';
        } else {
            html = `
                <div class="alert alert-info">
                    <h6>Nomor Antrian: ${response.nomor_antrian}</h6>
                    <p>Status: ${response.status}</p>
                    <p>Kategori: ${response.nama_kategori}</p>
                    ${response.sisa_antrian ? `<p>Sisa antrian di depan: ${response.sisa_antrian}</p>` : ''}
                </div>
            `;
        }
        $('#statusResult').html(html);
    });
});

function printAntrian() {
    const nomor = $('#nomorAntrian').text();
    const kategori = $('#kategoriAntrian').text();
    const posisi = $('#posisiAntrian').text();
    const waktu = new Date().toLocaleString('id-ID');
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Nomor Antrian - ${nomor}</title>
                <style>
                    @page {
                        size: A4;
                        margin: 1cm;
                    }
                    
                    body { 
                        font-family: 'Arial', sans-serif; 
                        text-align: center; 
                        margin: 0;
                        padding: 20px;
                        background: white;
                    }
                    
                    .header {
                        border-bottom: 3px solid #333;
                        padding-bottom: 20px;
                        margin-bottom: 30px;
                    }
                    
                    .company-name {
                        font-size: 28px;
                        font-weight: bold;
                        color: #333;
                        margin: 0;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                    }
                    
                    .company-tagline {
                        font-size: 14px;
                        color: #666;
                        margin: 5px 0 0 0;
                        font-style: italic;
                    }
                    
                    .queue-number-section {
                        background: #f8f9fa;
                        border: 3px solid #333;
                        border-radius: 15px;
                        padding: 30px;
                        margin: 30px 0;
                        position: relative;
                    }
                    
                    .queue-number-label {
                        font-size: 16px;
                        font-weight: 600;
                        color: #333;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        margin-bottom: 15px;
                        display: block;
                    }
                    
                    .queue-number-display {
                        font-size: 72px;
                        font-weight: 900;
                        color: #333;
                        margin: 0;
                        font-family: 'Arial Black', sans-serif;
                        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
                    }
                    
                    .info-section {
                        margin: 30px 0;
                    }
                    
                    .info-row {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 12px 0;
                        border-bottom: 1px solid #ddd;
                        margin: 0 20px;
                    }
                    
                    .info-label {
                        font-weight: 600;
                        color: #333;
                        font-size: 16px;
                    }
                    
                    .info-value {
                        color: #666;
                        font-size: 16px;
                    }
                    
                    .footer {
                        margin-top: 40px;
                        padding-top: 20px;
                        border-top: 2px solid #ddd;
                        color: #666;
                        font-size: 12px;
                    }
                    
                    .timestamp {
                        font-size: 14px;
                        color: #888;
                        margin-top: 20px;
                    }
                    
                    .qr-placeholder {
                        width: 100px;
                        height: 100px;
                        border: 2px dashed #ccc;
                        margin: 20px auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #999;
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1 class="company-name">QueueBank ProMax</h1>
                    <p class="company-tagline">Sistem Antrian Digital Terdepan</p>
                </div>
                
                <div class="queue-number-section">
                    <span class="queue-number-label">Nomor Antrian</span>
                    <div class="queue-number-display">${nomor}</div>
                </div>
                
                <div class="info-section">
                    <div class="info-row">
                        <span class="info-label">Kategori Layanan:</span>
                        <span class="info-value">${kategori}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Antrian:</span>
                        <span class="info-value">${posisi}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Waktu Ambil:</span>
                        <span class="info-value">${waktu}</span>
                    </div>
                </div>
                
                <div class="qr-placeholder">
                    QR Code<br>${nomor}
                </div>
                
                <div class="footer">
                    <p>Simpan tiket ini dengan baik dan tunggu panggilan di display</p>
                    <p class="timestamp">Dicetak pada: ${waktu}</p>
                </div>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>


<?= $this->endSection() ?>
