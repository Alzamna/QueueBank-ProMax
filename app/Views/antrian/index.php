<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Nomor Antrian - QueueBank ProMax</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        secondary: {
                            500: '#64748b',
                            600: '#475569',
                        },
                        success: {
                            500: '#10b981',
                            600: '#059669',
                        },
                        dark: {
                            500: '#1e293b',
                            600: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        display: ['Poppins', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap');
        
        .bg-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover-effect:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .category-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(245, 245, 245, 0.9) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: 0.5s;
        }
        
        .category-card:hover::before {
            left: 100%;
        }
        
        .category-card.selected {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        }
        
        .queue-number {
            font-family: 'Poppins', sans-serif;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            box-shadow: 0 4px 6px -1px rgba(124, 58, 237, 0.3), 0 2px 4px -1px rgba(124, 58, 237, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.4), 0 4px 6px -2px rgba(124, 58, 237, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(100, 116, 139, 0.4), 0 4px 6px -2px rgba(100, 116, 139, 0.3);
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
<body class="min-h-screen bg-gradient-to-br from-primary-600 to-primary-700 font-sans antialiased text-gray-800">
    <!-- Main Container -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Glass Panel -->
        <div class="bg-glass rounded-3xl shadow-xl overflow-hidden backdrop-blur-lg border border-white/10">
            <!-- Header Section -->
            <div class="text-center py-10 px-6 border-b border-white/10">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-white font-display mb-3">
                    MESIN ANTRIAN DIGITAL
                </h1>
                <p class="text-lg text-white/90 font-medium max-w-2xl mx-auto">
                    Silakan pilih kategori layanan dan ambil nomor antrian Anda
                </p>
                
                <div class="flex justify-center gap-3 mt-6">
                    <a href="/antrian/desktop" class="px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-medium transition-colors">
                        <i class="fas fa-desktop mr-2"></i> Mode Desktop
                    </a>
                    <a href="/antrian/mobile" class="px-5 py-2 border border-white/30 hover:bg-white/10 text-white rounded-full text-sm font-medium transition-colors">
                        <i class="fas fa-mobile-alt mr-2"></i> Mode Mobile
                    </a>
                </div>
            </div>

            <!-- Current Queue Status -->
            <div id="currentQueueStatus" class="hidden px-6 py-8">
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-2 border-success-500">
                    <div class="bg-success-600 px-6 py-5 text-white">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white/20 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-ticket-alt text-white text-lg"></i>
                                </div>
                                <h2 class="text-xl font-bold font-display">Nomor Antrian Aktif Anda</h2>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 text-center">
                        <div class="mb-8">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3 font-medium">NOMOR ANDA</div>
                            <div class="queue-number text-7xl font-bold text-gray-800 animate-float" id="currentNomorAntrian">-</div>
                            <div class="mt-5">
                                <span class="inline-block bg-success-600 text-white text-sm font-bold px-5 py-2 rounded-full" id="currentKategoriAntrian">-</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 text-center mb-8">
                            <div class="p-5 bg-gray-50 rounded-xl">
                                <div class="text-primary-600 mb-3">
                                    <i class="fas fa-users text-3xl"></i>
                                </div>
                                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Posisi Antrian</div>
                                <div class="text-2xl font-bold text-primary-600 mt-1" id="currentPosisiAntrian">-</div>
                            </div>
                            <div class="p-5 bg-gray-50 rounded-xl">
                                <div class="text-success-600 mb-3">
                                    <i class="fas fa-clock text-3xl"></i>
                                </div>
                                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Estimasi Waktu</div>
                                <div class="text-2xl font-bold text-success-600 mt-1" id="currentEstimasiWaktu">-</div>
                            </div>
                        </div>
                        <div class="flex justify-center space-x-4">
                            <button onclick="refreshQueueStatus()" class="btn-secondary px-6 py-3 text-white rounded-lg font-bold transition-all">
                                <i class="fas fa-sync-alt mr-2"></i> Refresh Status
                            </button>
                            <button onclick="printCurrentQueue()" class="btn-primary px-6 py-3 text-white rounded-lg font-bold transition-all">
                                <i class="fas fa-print mr-2"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Debug Information -->
            <?php if(empty($kategori)): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mx-6 my-6 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-xl mr-3 mt-0.5"></i>
                        <div>
                            <strong class="font-bold">Debug Info:</strong> Tidak ada kategori yang ditemukan. 
                            <div class="text-sm mt-1">
                                Total kategori: <?= count($kategori ?? []) ?><br>
                                Kategori data: <?= json_encode($kategori ?? []) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-8" id="categories">
                <?php foreach ($kategori as $kat): ?>
                <div class="category-card card-hover-effect rounded-2xl p-8 cursor-pointer flex flex-col items-center justify-between h-60 border border-white/20 shadow-sm" data-kategori-id="<?= $kat['id'] ?>">
                    <div class="text-2xl font-bold text-gray-800 text-center font-display"><?= $kat['nama_kategori'] ?></div>
                    <div class="text-gray-600 text-center font-medium flex-grow flex items-center justify-center">
                        <?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?>
                    </div>
                    <div class="text-gray-700 text-center text-sm mt-4">
                        <span class="font-semibold">Prefix: </span>
                        <span class="font-bold text-primary-600"><?= $kat['prefix'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Action Button -->
            <div class="px-8 pb-10">
                <button id="btnAmbil" disabled class="w-full py-5 px-6 btn-primary text-white font-bold rounded-xl transition-all duration-300 disabled:bg-gray-500 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
                    <span class="btn-text">Pilih kategori terlebih dahulu</span>
                    <span class="loading hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Queue Number Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" id="nomorModal">
        <div class="bg-white rounded-2xl shadow-3xl w-full max-w-2xl overflow-hidden transform transition-all duration-300 scale-95">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-8 py-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-ticket-alt text-2xl"></i>
                        <h3 class="text-2xl font-bold font-display">Nomor Antrian Anda</h3>
                    </div>
                    <button onclick="document.getElementById('nomorModal').classList.add('hidden')" class="text-white hover:text-white/80 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-10 text-center">
                <div class="mb-10">
                    <div class="mb-6">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-building text-primary-600 text-3xl"></i>
                        </div>
                        <h4 class="text-gray-500 mt-3 font-medium">QueueBank ProMax</h4>
                        <p class="text-gray-400 text-sm">Sistem Antrian Modern</p>
                    </div>
                    
                    <div class="mb-8">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-3 font-medium">NOMOR ANTRIAN</div>
                        <div class="queue-number text-8xl font-bold text-gray-800 animate-float" id="nomorAntrian">-</div>
                        <div class="mt-6">
                            <span class="inline-block bg-primary-600 text-white text-sm font-bold px-6 py-3 rounded-full" id="kategoriAntrian">-</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="p-5 bg-gray-50 rounded-xl">
                            <div class="text-primary-600 mb-3">
                                <i class="fas fa-users text-3xl"></i>
                            </div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Antrian di Depan</div>
                            <div class="text-2xl font-bold text-primary-600 mt-1" id="posisiAntrian">-</div>
                        </div>
                        <div class="p-5 bg-gray-50 rounded-xl">
                            <div class="text-success-600 mb-3">
                                <i class="fas fa-clock text-3xl"></i>
                            </div>
                            <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Estimasi Waktu</div>
                            <div class="text-2xl font-bold text-success-600 mt-1" id="estimasiWaktu">-</div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 text-left max-w-md mx-auto">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-0.5"></i>
                            <span id="waktuTunggu" class="text-gray-700">Silakan tunggu panggilan di display. Jaga jarak dan patuhi protokol kesehatan.</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center space-x-4">
                    <button onclick="document.getElementById('nomorModal').classList.add('hidden')" class="btn-secondary px-6 py-3 text-white rounded-lg font-bold transition-all">
                        <i class="fas fa-times mr-2"></i> Tutup
                    </button>
                    <button onclick="printAntrian()" class="btn-primary px-6 py-3 text-white rounded-lg font-bold transition-all">
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
                            font-family: 'Poppins', sans-serif; 
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
                            border-bottom: 2px solid #7c3aed;
                            padding-bottom: 8mm;
                            margin-bottom: 6mm;
                        }
                        
                        .company-logo {
                            font-size: 24px;
                            color: #7c3aed;
                            margin-bottom: 3mm;
                        }
                        
                        .company-name {
                            font-size: 16px;
                            font-weight: 700;
                            color: #1e293b;
                            margin: 0;
                            letter-spacing: 0.5px;
                        }
                        
                        .company-tagline {
                            font-size: 10px;
                            color: #64748b;
                            margin: 2mm 0 0 0;
                            font-weight: 300;
                        }
                        
                        .queue-number-section {
                            margin: 8mm 0;
                            padding: 6mm;
                            border: 2px solid #7c3aed;
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
                            color: #475569;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            margin-bottom: 4mm;
                        }
                        
                        .queue-number {
                            font-size: 36px;
                            font-weight: 800;
                            color: #1e293b;
                            margin: 4mm 0;
                            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
                            letter-spacing: 1px;
                            line-height: 1;
                        }
                        
                        .category-badge {
                            display: inline-block;
                            background: #7c3aed;
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
                            border: 1px solid #e2e8f0;
                            font-size: 9px;
                        }
                        
                        .info-row {
                            display: flex;
                            justify-content: space-between;
                            margin: 2mm 0;
                            padding: 1mm 0;
                            border-bottom: 0.5px solid #f1f5f9;
                        }
                        
                        .info-label {
                            font-weight: 600;
                            color: #475569;
                            font-size: 9px;
                        }
                        
                        .info-value {
                            font-weight: 700;
                            color: #1e293b;
                            font-size: 9px;
                        }
                        
                        .footer {
                            margin-top: 6mm;
                            padding-top: 4mm;
                            border-top: 1px solid #e2e8f0;
                            color: #64748b;
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