<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesin Antrian Mobile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
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
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 3s ease-in-out infinite',
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
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .bg-gradient-selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-button {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .bg-gradient-button-disabled {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        
        .service-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.7s ease;
        }
        
        .service-card:hover::before {
            left: 100%;
        }
        
        .service-card.disabled {
            opacity: 0.5;
            filter: grayscale(50%);
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .service-card.disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .service-card.disabled::before {
            display: none;
        }
        
        .bottom-bar {
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            padding-bottom: calc(env(safe-area-inset-bottom) + 1rem);
        }
        
        @media (max-width: 640px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-primary font-sans text-gray-100 antialiased pb-20">
    <!-- Header Section -->
    <header class="sticky top-0 z-10 bg-white/10 backdrop-blur-md border-b border-white/20 px-4 py-3">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-mobile-alt animate-pulse-slow"></i>
                MESIN ANTRIAN MOBILE
            </h1>
            <p class="text-sm opacity-90 mt-1">Pilih layanan & ambil nomor antrian</p>
        </div>
    </header>

    <!-- Info Cards -->
    <div class="grid info-grid grid-cols-4 gap-2 px-4 my-4">
        <div class="bg-white/20 rounded-lg p-3 text-center backdrop-blur-sm border border-white/10 shadow-sm hover:shadow-md transition-all">
            <div class="text-xs font-medium uppercase tracking-wider text-white/80">Total</div>
            <div class="text-xl font-bold mt-1" id="mobileTotalAntrian">0</div>
        </div>
        <div class="bg-white/20 rounded-lg p-3 text-center backdrop-blur-sm border border-white/10 shadow-sm hover:shadow-md transition-all">
            <div class="text-xs font-medium uppercase tracking-wider text-white/80">Dipanggil</div>
            <div class="text-xl font-bold mt-1" id="mobileSedangDipanggil">0</div>
        </div>
        <div class="bg-white/20 rounded-lg p-3 text-center backdrop-blur-sm border border-white/10 shadow-sm hover:shadow-md transition-all">
            <div class="text-xs font-medium uppercase tracking-wider text-white/80">Menunggu</div>
            <div class="text-xl font-bold mt-1" id="mobileSedangMenunggu">0</div>
        </div>
        <div class="bg-white/20 rounded-lg p-3 text-center backdrop-blur-sm border border-white/10 shadow-sm hover:shadow-md transition-all">
            <div class="text-xs font-medium uppercase tracking-wider text-white/80">Update</div>
            <div class="text-sm font-medium mt-1" id="mobileUpdateTerakhir">-</div>
        </div>
    </div>

    <!-- Current Queue Status Bar -->
    <div class="px-4 mb-4" id="currentQueueStatusBar" style="display: none;">
        <div class="bg-success-500/20 backdrop-blur-sm border border-success-500/30 rounded-xl p-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="bg-success-500 rounded-full w-6 h-6 flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
                <h3 class="text-lg font-semibold text-success-600">Anda Sudah Mengambil Antrian</h3>
            </div>
            <div class="text-sm text-success-700 mb-3">
                <span class="font-medium">Nomor:</span> 
                <span class="text-xl font-bold" id="statusBarNomorAntrian">-</span>
                <span class="mx-2">•</span>
                <span class="font-medium">Layanan:</span> 
                <span id="statusBarKategori">-</span>
            </div>
            <div class="flex justify-center gap-2">
                <button onclick="showQueueNumberFromStatusBar()" class="px-4 py-2 bg-success-600 hover:bg-success-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                </button>
                <button onclick="printAntrianFromStatusBar()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-print mr-1"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    <!-- Current Queue Status Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" id="currentQueueStatus">
        <div class="bg-white rounded-xl overflow-hidden w-full max-w-md mx-4 shadow-2xl transform transition-all duration-300 scale-95">
            <!-- Header -->
            <div class="bg-success-600 p-5 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Nomor Antrian Berhasil</h3>
                </div>
                <button onclick="hideQueueStatus()" class="text-white hover:bg-white/10 rounded-full p-1 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="text-5xl font-bold text-success-600 mb-2 animate-float" id="currentNomorAntrian">-</div>
                    <span class="inline-block bg-success-600 text-white text-sm font-medium px-4 py-1 rounded-full" id="currentKategoriAntrian">-</span>
                </div>
                
                <div class="text-gray-700 mb-1">
                    <span>Posisi antrian: </span>
                    <span class="font-medium" id="currentPosisiAntrian">-</span>
                </div>
                
                <div class="text-gray-500 text-sm">
                    <span>Waktu: </span>
                    <span id="currentTimestamp">-</span>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="border-t border-gray-200 p-4 flex justify-center space-x-3">
                <button onclick="hideQueueStatus()" class="px-5 py-2 bg-secondary-500 hover:bg-secondary-600 text-white rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
                <button onclick="printAntrian()" class="px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    <!-- Service Cards -->
    <div class="px-4 space-y-3 mt-4">
        <?php foreach ($kategori as $kat): ?>
        <div class="service-card bg-gradient-card rounded-xl p-4 cursor-pointer relative overflow-hidden border border-white/30 shadow-md hover:shadow-lg text-gray-800" data-kategori-id="<?= $kat['id'] ?>">
            <div class="relative z-10">
                <h3 class="font-bold text-lg text-dark-600"><?= $kat['nama_kategori'] ?></h3>
                <p class="text-sm text-gray-600 mt-1"><?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?></p>
                <div class="text-xs text-gray-500 mt-2">
                    <span class="font-medium">Prefix:</span> <?= $kat['prefix'] ?>
                </div>
            </div>
            <!-- Disabled Overlay -->
            <div class="disabled-overlay absolute inset-0 bg-black/20 rounded-xl flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
                <div class="bg-white/90 rounded-lg px-3 py-1 text-xs font-medium text-gray-700">
                    <i class="fas fa-lock mr-1"></i> Sudah Ambil Antrian
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bottom Action Bar -->
    <div class="bottom-bar fixed bottom-0 left-0 right-0 p-4 z-40">
        <div class="max-w-md mx-auto w-full">
            <button id="mobileBtnAmbil" disabled class="w-full py-3 px-4 rounded-full font-semibold text-white bg-gradient-button hover:shadow-lg transition-all disabled:bg-gradient-button-disabled disabled:cursor-not-allowed disabled:opacity-80">
                <span class="btn-text">Pilih layanan terlebih dahulu</span>
            </button>
        </div>
    </div>

    <script>
        // Persistent storage for queue number
        const STORAGE_KEY = 'queuebank_mobile_queue';
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupMobileServiceCards();
            updateMobileInfo();
            checkExistingQueue();
            startRealTimeUpdates();
        });
        
        function setupMobileServiceCards() {
            document.querySelectorAll('.service-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Check if card is disabled
                    if (this.classList.contains('disabled')) {
                        return; // Don't allow selection of disabled cards
                    }
                    
                    document.querySelectorAll('.service-card').forEach(c => {
                        c.classList.remove('bg-gradient-selected', 'text-white');
                        c.querySelector('h3').classList.remove('text-white');
                        c.querySelector('p').classList.remove('text-white');
                        c.querySelector('div').classList.remove('text-white');
                    });
                    
                    this.classList.add('bg-gradient-selected', 'text-white');
                    this.querySelector('h3').classList.add('text-white');
                    this.querySelector('p').classList.add('text-white');
                    this.querySelector('div').classList.add('text-white');
                    
                    const mobileBtn = document.getElementById('mobileBtnAmbil');
                    mobileBtn.disabled = false;
                    mobileBtn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
                });
            });
            
            document.getElementById('mobileBtnAmbil').addEventListener('click', function() {
                const selectedCard = document.querySelector('.service-card.bg-gradient-selected');
                if (selectedCard) {
                    const kategoriId = selectedCard.dataset.kategoriId;
                    const kategoriNama = selectedCard.querySelector('h3').textContent;
                    
                    // Show loading state
                    const btnText = this.querySelector('.btn-text');
                    const originalText = btnText.textContent;
                    btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
                    this.disabled = true;
                    
                    // Call the actual API to get queue number
                    fetch('/ambil-nomor', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'kategori_id=' + kategoriId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Save queue number to persistent storage
                            const queueData = {
                                nomor_antrian: data.nomor_antrian,
                                nomor_antrian_full: data.nomor_antrian_full,
                                kategori: data.kategori,
                                antrian_id: data.antrian_id,
                                waktu_ambil: new Date().toISOString(),
                                kategori_id: kategoriId
                            };
                            localStorage.setItem(STORAGE_KEY, JSON.stringify(queueData));
                            
                            // Show queue number
                            showQueueNumber(queueData);
                            
                            // Reset selection
                            selectedCard.classList.remove('bg-gradient-selected', 'text-white');
                            selectedCard.querySelector('h3').classList.remove('text-white');
                            selectedCard.querySelector('p').classList.remove('text-white');
                            selectedCard.querySelector('div').classList.remove('text-white');
                            
                            this.disabled = true;
                            btnText.textContent = 'Pilih layanan terlebih dahulu';
                            
                            // Update info cards
                            updateQueueInfo();
                        } else {
                            alert('Gagal mengambil nomor: ' + data.message);
                            btnText.textContent = originalText;
                            this.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil nomor antrian');
                        btnText.textContent = originalText;
                        this.disabled = false;
                    });
                }
            });
        }
        
        function checkExistingQueue() {
            const savedQueue = localStorage.getItem(STORAGE_KEY);
            if (savedQueue) {
                try {
                    const queueData = JSON.parse(savedQueue);
                    // Check if queue is still valid (not older than 24 hours)
                    const queueTime = new Date(queueData.waktu_ambil);
                    const now = new Date();
                    const hoursDiff = (now - queueTime) / (1000 * 60 * 60);
                    
                    if (hoursDiff < 24) {
                        // Show status bar and disable other services
                        showStatusBar(queueData);
                        disableOtherServices(queueData.kategori_id);
                        updateQueueInfo();
                    } else {
                        // Remove expired queue
                        localStorage.removeItem(STORAGE_KEY);
                        hideStatusBar();
                        enableAllServices();
                    }
                } catch (e) {
                    localStorage.removeItem(STORAGE_KEY);
                    hideStatusBar();
                    enableAllServices();
                }
            }
        }
        
        function showQueueNumber(queueData) {
            // Show modal
            const modal = document.getElementById('currentQueueStatus');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('#currentQueueStatus > div').classList.remove('scale-95');
            modal.querySelector('#currentQueueStatus > div').classList.add('scale-100');
            
            // Use display number for user-friendly view
            const displayNumber = queueData.nomor_antrian || queueData.nomor_antrian_full;
            document.getElementById('currentNomorAntrian').textContent = displayNumber;
            document.getElementById('currentKategoriAntrian').textContent = queueData.kategori;
            
            // Set current timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTimestamp').textContent = timestamp;
            
            // Calculate position and estimated time
            calculateQueuePosition(queueData.antrian_id, queueData.kategori_id);
            
            // Show status bar and disable other services
            showStatusBar(queueData);
            disableOtherServices(queueData.kategori_id);
        }
        
        function showStatusBar(queueData) {
            const statusBar = document.getElementById('currentQueueStatusBar');
            const displayNumber = queueData.nomor_antrian || queueData.nomor_antrian_full;
            
            document.getElementById('statusBarNomorAntrian').textContent = displayNumber;
            document.getElementById('statusBarKategori').textContent = queueData.kategori;
            
            statusBar.style.display = 'block';
            statusBar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        
        function hideStatusBar() {
            const statusBar = document.getElementById('currentQueueStatusBar');
            statusBar.style.display = 'none';
        }
        
        function disableOtherServices(selectedKategoriId) {
            document.querySelectorAll('.service-card').forEach(card => {
                const kategoriId = card.dataset.kategoriId;
                const overlay = card.querySelector('.disabled-overlay');
                
                if (kategoriId !== selectedKategoriId) {
                    card.classList.add('disabled');
                    overlay.style.opacity = '1';
                    overlay.style.pointerEvents = 'auto';
                } else {
                    card.classList.add('bg-gradient-selected', 'text-white');
                    card.querySelector('h3').classList.add('text-white');
                    card.querySelector('p').classList.add('text-white');
                    card.querySelector('div').classList.add('text-white');
                }
            });
        }
        
        function enableAllServices() {
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('disabled', 'bg-gradient-selected', 'text-white');
                card.querySelector('h3').classList.remove('text-white');
                card.querySelector('p').classList.remove('text-white');
                card.querySelector('div').classList.remove('text-white');
                
                const overlay = card.querySelector('.disabled-overlay');
                overlay.style.opacity = '0';
                overlay.style.pointerEvents = 'none';
            });
        }
        
        function hideQueueStatus() {
            const modal = document.getElementById('currentQueueStatus');
            modal.querySelector('#currentQueueStatus > div').classList.remove('scale-100');
            modal.querySelector('#currentQueueStatus > div').classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }
        
        function printAntrian() {
            // Create print content
            const printContent = `
                <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                    <h2 style="font-size: 24px; margin-bottom: 10px;">Nomor Antrian</h2>
                    <div style="font-size: 48px; font-weight: bold; color: #28a745; margin: 20px 0;">
                        ${document.getElementById('currentNomorAntrian').textContent}
                    </div>
                    <div style="font-size: 18px; margin: 10px 0; background: #28a745; color: white; display: inline-block; padding: 5px 15px; border-radius: 20px;">
                        ${document.getElementById('currentKategoriAntrian').textContent}
                    </div>
                    <div style="font-size: 14px; color: #666; margin: 10px 0;">
                        Posisi: ${document.getElementById('currentPosisiAntrian').textContent}
                    </div>
                    <div style="font-size: 12px; color: #999; margin: 20px 0;">
                        ${document.getElementById('currentTimestamp').textContent}
                    </div>
                    <div style="font-size: 10px; color: #ccc; margin: 10px 0;">
                        ID: ${document.getElementById('currentNomorAntrian').textContent}
                    </div>
                </div>
            `;
            
            // Open print window
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Cetak Nomor Antrian</title>
                        <style>
                            @media print {
                                @page { size: auto; margin: 5mm; }
                                body { -webkit-print-color-adjust: exact; }
                            }
                        </style>
                    </head>
                    <body onload="window.print();window.close()">
                        ${printContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
        }
        
        function calculateQueuePosition(antrianId, kategoriId) {
            // Get queue position from API
            fetch(`/cek-status/${antrianId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update position
                        const posisi = data.posisi_antrian || 0;
                        document.getElementById('currentPosisiAntrian').textContent = posisi;
                    } else {
                        document.getElementById('currentPosisiAntrian').textContent = '-';
                    }
                })
                .catch(error => {
                    console.error('Error getting queue position:', error);
                    document.getElementById('currentPosisiAntrian').textContent = '-';
                });
        }
        
        function updateMobileInfo() {
            // Get real data from API
            fetch('/statistik-antrian')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let totalAntrian = 0;
                        let sedangDipanggil = 0;
                        let sedangMenunggu = 0;
                        
                        data.statistik.forEach(stat => {
                            totalAntrian += stat.total_antrian || 0;
                            sedangDipanggil += stat.antrian_dipanggil || 0;
                        });
                        
                        sedangMenunggu = totalAntrian - sedangDipanggil;
                        
                        document.getElementById('mobileTotalAntrian').textContent = totalAntrian;
                        document.getElementById('mobileSedangDipanggil').textContent = sedangDipanggil;
                        document.getElementById('mobileSedangMenunggu').textContent = sedangMenunggu;
                    }
                })
                .catch(error => {
                    console.error('Error updating info:', error);
                });
        }
        
        function updateQueueInfo() {
            // Update queue info every 30 seconds
            setInterval(() => {
                const savedQueue = localStorage.getItem(STORAGE_KEY);
                if (savedQueue) {
                    try {
                        const queueData = JSON.parse(savedQueue);
                        calculateQueuePosition(queueData.antrian_id, queueData.kategori_id);
                    } catch (e) {
                        console.error('Error updating queue info:', e);
                    }
                }
            }, 30000);
        }
        
        function startRealTimeUpdates() {
            // Initial update
            updateMobileInfo();
            document.getElementById('mobileUpdateTerakhir').textContent = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Update info every 30 seconds
            setInterval(() => {
                updateMobileInfo();
                document.getElementById('mobileUpdateTerakhir').textContent = new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }, 30000);
        }
        
        function showQueueNumberFromStatusBar() {
            const savedQueue = localStorage.getItem(STORAGE_KEY);
            if (savedQueue) {
                try {
                    const queueData = JSON.parse(savedQueue);
                    showQueueModal(queueData);
                } catch (e) {
                    console.error('Error showing queue from status bar:', e);
                    alert('Terjadi kesalahan saat menampilkan detail antrian');
                }
            } else {
                alert('Tidak ada data antrian yang tersimpan');
            }
        }
        
        function showQueueModal(queueData) {
            // Show modal without changing status bar or disabling services
            const modal = document.getElementById('currentQueueStatus');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('#currentQueueStatus > div').classList.remove('scale-95');
            modal.querySelector('#currentQueueStatus > div').classList.add('scale-100');
            
            // Use display number for user-friendly view
            const displayNumber = queueData.nomor_antrian || queueData.nomor_antrian_full;
            document.getElementById('currentNomorAntrian').textContent = displayNumber;
            document.getElementById('currentKategoriAntrian').textContent = queueData.kategori;
            
            // Set current timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTimestamp').textContent = timestamp;
            
            // Calculate position and estimated time
            calculateQueuePosition(queueData.antrian_id, queueData.kategori_id);
        }
        
        function printAntrianFromStatusBar() {
            const savedQueue = localStorage.getItem(STORAGE_KEY);
            if (savedQueue) {
                try {
                    const queueData = JSON.parse(savedQueue);
                    // Update modal content first
                    showQueueModal(queueData);
                    // Wait a bit for modal to update, then print
                    setTimeout(() => {
                        printAntrian();
                    }, 300);
                } catch (e) {
                    console.error('Error printing from status bar:', e);
                    alert('Terjadi kesalahan saat mencetak antrian');
                }
            } else {
                alert('Tidak ada data antrian yang tersimpan');
            }
        }
        
        // Function untuk reset manual (untuk testing)
        function resetQueue() {
            localStorage.removeItem(STORAGE_KEY);
            hideStatusBar();
            enableAllServices();
            
            const mobileBtn = document.getElementById('mobileBtnAmbil');
            mobileBtn.disabled = true;
            mobileBtn.querySelector('.btn-text').textContent = 'Pilih layanan terlebih dahulu';
            
            // Hide modal if open
            const modal = document.getElementById('currentQueueStatus');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('#currentQueueStatus > div').classList.remove('scale-100');
            modal.querySelector('#currentQueueStatus > div').classList.add('scale-95');
        }
        
        // Expose reset function globally for testing
        window.resetQueue = resetQueue;
    </script>
</body>
</html>