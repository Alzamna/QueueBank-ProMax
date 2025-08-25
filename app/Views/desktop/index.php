<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        display: ['Poppins', 'sans-serif']
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .queue-number {
            font-family: 'Poppins', sans-serif;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3), 0 2px 4px -1px rgba(102, 126, 234, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4), 0 4px 6px -2px rgba(102, 126, 234, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            box-shadow: 0 4px 6px -1px rgba(40, 167, 69, 0.3), 0 2px 4px -1px rgba(40, 167, 69, 0.2);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(40, 167, 69, 0.4), 0 4px 6px -2px rgba(40, 167, 69, 0.3);
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
<body class="min-h-screen bg-gradient-to-br from-indigo-600 to-purple-600 font-sans antialiased text-gray-800">
    <!-- Main Container -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Glass Panel -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <!-- Header Section -->
            <div class="text-center py-10 px-6 border-b border-gray-200">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-indigo-600"></i>
                </div>
                <h1 class="text-4xl font-bold text-indigo-600 font-display mb-3">
                    MESIN ANTRIAN DIGITAL
                </h1>
                <p class="text-lg text-gray-700 font-medium max-w-2xl mx-auto">
                    Silakan pilih kategori layanan dan ambil nomor antrian Anda
                </p>
                
                <div class="text-gray-500 mt-2">
                    <small><i class="fas fa-desktop mr-1"></i> Desktop Mode</small>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 px-6 py-4" id="statistics">
                <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2" id="total-antrian">-</div>
                    <div class="text-sm font-medium text-gray-600">Total Antrian</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2" id="antrian-dipanggil">-</div>
                    <div class="text-sm font-medium text-gray-600">Sedang Dipanggil</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2" id="antrian-menunggu">-</div>
                    <div class="text-sm font-medium text-gray-600">Sedang Menunggu</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2" id="timestamp">-</div>
                    <div class="text-sm font-medium text-gray-600">Update Terakhir</div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6" id="categories">
                <?php foreach ($kategori as $kat): ?>
                <div class="category-card card-hover-effect rounded-2xl p-8 cursor-pointer flex flex-col items-center justify-between h-60 border border-gray-200 shadow-sm" data-kategori-id="<?= $kat['id'] ?>">
                    <div class="text-2xl font-bold text-gray-800 text-center font-display"><?= $kat['nama_kategori'] ?></div>
                    <div class="text-gray-600 text-center font-medium flex-grow flex items-center justify-center">
                        <?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?>
                    </div>
                    <div class="text-gray-700 text-center text-sm mt-4">
                        <span class="font-semibold">Prefix: </span>
                        <span class="font-bold text-indigo-600"><?= $kat['prefix'] ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Action Button -->
            <div class="px-6 pb-8">
                <button id="btnAmbil" disabled class="w-full py-4 px-6 btn-success text-white font-bold rounded-xl transition-all duration-300 disabled:bg-gray-500 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
                    <span class="btn-text">Pilih kategori terlebih dahulu</span>
                    <span class="loading hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden" id="resultModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-500 text-white px-8 py-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-xl"></i>
                        <h3 class="text-xl font-bold font-display">Nomor Antrian Berhasil</h3>
                    </div>
                    <button onclick="document.getElementById('resultModal').classList.add('hidden')" class="text-white hover:text-white/80 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-8 text-center">
                <div class="queue-number text-6xl font-bold text-green-600 animate-float mb-6" id="modalNomorAntrian"></div>
                <div class="space-y-4">
                    <h4 class="text-lg font-medium text-gray-800" id="modalKategori"></h4>
                    <div class="text-gray-600">
                        <p>Posisi antrian: <span class="font-semibold text-gray-800" id="modalPosisi"></span></p>
                        <p>Waktu: <span class="font-semibold text-gray-800" id="modalWaktu"></span></p>
                    </div>
                </div>
            </div>
            <div class="px-6 pb-6 flex justify-center space-x-4">
                <button onclick="document.getElementById('resultModal').classList.add('hidden')" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i> Tutup
                </button>
                <button onclick="printQueue()" class="px-6 py-2 btn-primary text-white rounded-lg font-medium transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedKategori = null;
        let currentQueueData = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            setupEventListeners();
            
            // Auto-refresh statistics every 30 seconds
            setInterval(loadStatistics, 30000);
        });

        function setupEventListeners() {
            // Category selection
            document.querySelectorAll('.category-card').forEach(card => {
                card.addEventListener('click', function() {
                    selectCategory(this);
                });
            });

            // Take queue button
            document.getElementById('btnAmbil').addEventListener('click', function() {
                if (selectedKategori) {
                    takeQueue();
                }
            });
        }

        function selectCategory(card) {
            // Remove previous selection
            document.querySelectorAll('.category-card').forEach(c => {
                c.classList.remove('selected');
                c.querySelector('div:nth-child(1)').classList.remove('text-white');
                c.querySelector('div:nth-child(2)').classList.remove('text-white');
                c.querySelector('div:nth-child(3)').classList.remove('text-white');
            });
            
            // Select current category
            card.classList.add('selected');
            card.querySelector('div:nth-child(1)').classList.add('text-white');
            card.querySelector('div:nth-child(2)').classList.add('text-white');
            card.querySelector('div:nth-child(3)').classList.add('text-white');
            
            selectedKategori = card.dataset.kategoriId;
            
            // Enable button
            const btn = document.getElementById('btnAmbil');
            btn.disabled = false;
            btn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
        }

        async function takeQueue() {
            if (!selectedKategori) return;

            // Debug logging
            console.log('=== TAKING QUEUE ===');
            console.log('Selected kategori:', selectedKategori);
            console.log('Selected kategori type:', typeof selectedKategori);

            const btn = document.getElementById('btnAmbil');
            const btnText = btn.querySelector('.btn-text');
            const loading = btn.querySelector('.loading');

            // Show loading
            btnText.classList.add('hidden');
            loading.classList.remove('hidden');
            btn.disabled = true;

            try {
                const response = await fetch('/desktop/ambilNomorDesktop', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        kategori_id: selectedKategori
                    })
                });

                const data = await response.json();
                
                // Debug logging
                console.log('Response status:', response.status);
                console.log('Response data:', data);

                if (data.success) {
                    currentQueueData = data;
                    showResultModal(data);
                    loadStatistics(); // Refresh statistics
                } else {
                    console.error('Error response:', data);
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil nomor antrian');
            } finally {
                // Hide loading
                btnText.classList.remove('hidden');
                loading.classList.add('hidden');
                btn.disabled = false;
            }
        }

        function showResultModal(data) {
            document.getElementById('modalNomorAntrian').textContent = data.nomor_antrian;
            document.getElementById('modalKategori').textContent = data.kategori;
            document.getElementById('modalPosisi').textContent = data.posisi_antrian + 1;
            document.getElementById('modalWaktu').textContent = data.timestamp;
            
            document.getElementById('resultModal').classList.remove('hidden');
        }

        async function loadStatistics() {
            try {
                const response = await fetch('/desktop/getStatistikHarian');
                const data = await response.json();

                if (data.success) {
                    updateStatistics(data.statistik);
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        function updateStatistics(statistik) {
            let totalAntrian = 0;
            let totalDipanggil = 0;

            statistik.forEach(stat => {
                totalAntrian += stat.total_antrian;
                totalDipanggil += stat.antrian_dipanggil.length;
            });

            document.getElementById('total-antrian').textContent = totalAntrian;
            document.getElementById('antrian-dipanggil').textContent = totalDipanggil;
            document.getElementById('antrian-menunggu').textContent = totalAntrian - totalDipanggil;
            document.getElementById('timestamp').textContent = new Date().toLocaleTimeString('id-ID');
        }

        function printQueue() {
            if (!currentQueueData) return;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Nomor Antrian</title>
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
                            justify-content: center;
                        }
                        
                        .queue-number {
                            font-size: 48px;
                            font-weight: 800;
                            color: #28a745;
                            margin: 10mm 0;
                            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
                            letter-spacing: 1px;
                            line-height: 1;
                        }
                        
                        .queue-info {
                            margin: 6mm 0;
                            padding: 4mm;
                            background: #fff;
                            border-radius: 6px;
                            border: 1px solid #e2e8f0;
                        }
                        
                        .timestamp {
                            color: #64748b;
                            font-size: 10px;
                            margin-top: 10mm;
                        }
                    </style>
                </head>
                <body>
                    <div class="print-container">
                        <h2>NOMOR ANTRIAN</h2>
                        <div class="queue-number">${currentQueueData.nomor_antrian}</div>
                        <div class="queue-info">
                            <h3>${currentQueueData.kategori}</h3>
                            <p>Posisi: ${currentQueueData.posisi_antrian + 1}</p>
                            <p>Waktu: ${currentQueueData.timestamp}</p>
                        </div>
                        <div class="timestamp">
                            Dicetak pada: ${new Date().toLocaleString('id-ID')}
                        </div>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>