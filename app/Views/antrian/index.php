<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Nomor Antrian - QueueBank ProMax</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style type="text/css">
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        .category-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .category-card.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .queue-number {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            letter-spacing: 2px;
        }
        @media print {
            .queue-number {
                color: #000 !important;
                text-shadow: none !important;
            }
            .badge {
                background-color: #000 !important;
                color: #fff !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-primary font-sans antialiased">
    <!-- Desktop Container -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Desktop Header -->
            <div class="text-center py-8 px-4 border-b border-gray-200">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">
                    <i class="fas fa-ticket-alt mr-2"></i> MESIN ANTRIAN
                </h1>
                <p class="text-lg text-gray-700 font-medium">
                    Silakan pilih kategori layanan dan ambil nomor antrian
                </p>
                <div class="text-gray-500 text-sm mt-2">
                    <i class="fas fa-mobile-alt mr-1"></i> Tersedia dalam 2 tampilan
                </div>
                <div class="flex justify-center gap-2 mt-4">
                    <a href="/antrian/desktop" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium text-gray-700">
                        <i class="fas fa-desktop mr-1"></i> Desktop
                    </a>
                    <a href="/antrian/mobile" class="px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700">
                        <i class="fas fa-mobile-alt mr-1"></i> Mobile
                    </a>
                </div>
            </div>

            <!-- Current Queue Status (Mobile) -->
            <div id="currentQueueStatus" class="hidden px-6 py-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-green-500">
                    <div class="bg-green-600 px-6 py-4 text-white">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-full w-8 h-8 flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-white"></i>
                                </div>
                                <h2 class="text-lg font-semibold">Nomor Antrian Aktif Anda</h2>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <div class="mb-6">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">Nomor Antrian</div>
                            <div class="queue-number text-6xl font-bold text-gray-800" id="currentNomorAntrian">-</div>
                            <div class="mt-4">
                                <span class="inline-block bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-full" id="currentKategoriAntrian">-</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="p-4">
                                <div class="text-blue-500 mb-2">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <div class="text-xs text-gray-500">Posisi Antrian</div>
                                <div class="text-xl font-bold text-blue-500" id="currentPosisiAntrian">-</div>
                            </div>
                            <div class="p-4">
                                <div class="text-green-500 mb-2">
                                    <i class="fas fa-clock text-2xl"></i>
                                </div>
                                <div class="text-xs text-gray-500">Estimasi Waktu</div>
                                <div class="text-xl font-bold text-green-500" id="currentEstimasiWaktu">-</div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center space-x-3">
                            <button onclick="refreshQueueStatus()" class="px-5 py-2 border border-green-600 text-green-600 rounded-lg font-medium hover:bg-green-50 transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i> Refresh Status
                            </button>
                            <button onclick="printCurrentQueue()" class="px-5 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                                <i class="fas fa-print mr-2"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Debug information -->
            <?php if(empty($kategori)): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mx-6 my-4">
                    <strong>Debug Info:</strong> Tidak ada kategori yang ditemukan. 
                    <br>Total kategori: <?= count($kategori ?? []) ?>
                    <br>Kategori data: <?= json_encode($kategori ?? []) ?>
                </div>
            <?php endif; ?>

            <!-- Desktop Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6" id="categories">
                <?php foreach ($kategori as $kat): ?>
                <div class="category-card rounded-2xl p-6 cursor-pointer flex flex-col items-center justify-between h-48" data-kategori-id="<?= $kat['id'] ?>">
                    <div class="text-xl font-bold text-gray-800 text-center"><?= $kat['nama_kategori'] ?></div>
                    <div class="text-gray-600 text-center font-medium flex-grow flex items-center justify-center">
                        <?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?>
                    </div>
                    <div class="text-gray-700 text-center text-sm">
                        <span class="font-semibold">Prefix: </span>
                        <span class="font-bold text-indigo-600"><?= $kat['prefix'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Desktop Action Button -->
            <div class="px-6 pb-8">
                <button id="btnAmbil" disabled class="w-full py-4 px-6 bg-gradient-success hover:shadow-lg text-white font-bold rounded-full transition-all duration-300 disabled:bg-gray-500 disabled:cursor-not-allowed">
                    <span class="btn-text">Pilih kategori terlebih dahulu</span>
                    <span class="loading hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan nomor antrian -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="nomorModal">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="bg-gradient-primary text-white px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-ticket-alt text-xl"></i>
                        <h3 class="text-xl font-semibold">Nomor Antrian Anda</h3>
                    </div>
                    <button onclick="document.getElementById('nomorModal').classList.add('hidden')" class="text-white hover:text-white/80">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-8 text-center">
                <div class="mb-8">
                    <div class="mb-4">
                        <i class="fas fa-building text-indigo-500 text-4xl"></i>
                        <h4 class="text-gray-500 mt-2">QueueBank ProMax</h4>
                        <p class="text-gray-400 text-sm">Sistem Antrian Modern</p>
                    </div>
                    
                    <div class="mb-6">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">Nomor Antrian</div>
                        <div class="queue-number text-7xl font-bold text-gray-800 animate-float" id="nomorAntrian">-</div>
                        <div class="mt-4">
                            <span class="inline-block bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-full" id="kategoriAntrian">-</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4">
                            <div class="text-blue-500 mb-2">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div class="text-xs text-gray-500">Antrian di Depan</div>
                            <div class="text-xl font-bold text-blue-500" id="posisiAntrian">-</div>
                        </div>
                        <div class="p-4">
                            <div class="text-green-500 mb-2">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                            <div class="text-xs text-gray-500">Estimasi Waktu</div>
                            <div class="text-xl font-bold text-green-500" id="estimasiWaktu">-</div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-3 text-left">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span id="waktuTunggu" class="text-gray-700">Silakan tunggu panggilan di display</span>
                    </div>
                </div>
                <div class="flex justify-center space-x-3">
                    <button onclick="document.getElementById('nomorModal').classList.add('hidden')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i> Tutup
                    </button>
                    <button onclick="printAntrian()" class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-print mr-2"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
                const kategoriNama = selectedCard.querySelector('div:nth-child(1)').textContent;
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
                    c.querySelector('div:nth-child(1)').classList.remove('text-white');
                    c.querySelector('div:nth-child(2)').classList.remove('text-white');
                    c.querySelector('div:nth-child(3)').classList.remove('text-white');
                });
                
                // Add selection to clicked card
                this.classList.add('selected');
                this.querySelector('div:nth-child(1)').classList.add('text-white');
                this.querySelector('div:nth-child(2)').classList.add('text-white');
                this.querySelector('div:nth-child(3)').classList.add('text-white');
                
                // Enable action button
                const btn = document.getElementById('btnAmbil');
                btn.disabled = false;
                btn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
                
                // Auto-remove selection after 3 seconds
                setTimeout(() => {
                    this.classList.remove('selected');
                    this.querySelector('div:nth-child(1)').classList.remove('text-white');
                    this.querySelector('div:nth-child(2)').classList.remove('text-white');
                    this.querySelector('div:nth-child(3)').classList.remove('text-white');
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
        
        document.getElementById('currentQueueStatus').classList.remove('hidden');
    }

    function hideCurrentQueueStatus() {
        document.getElementById('currentQueueStatus').classList.add('hidden');
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
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
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
                    
                    document.getElementById('nomorModal').classList.remove('hidden');
                    
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
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
            }, 500);
        };
    }
    </script>
</body>
</html>