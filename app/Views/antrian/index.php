<?= $this->extend('layouts/main') ?>

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
</style>

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


<?= $this->endSection() ?>
