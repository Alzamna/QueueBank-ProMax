<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesin Antrian Mobile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        
        .mobile-header {
            text-align: center;
            padding: 0.8rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 0.5rem;
            border-bottom: 3px solid rgba(255,255,255,0.3);
        }
        
        .mobile-header h1 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
            font-weight: bold;
            color: white;
        }
        
        .mobile-header p {
            font-size: 0.8rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .mobile-info-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.4rem;
            padding: 0.4rem;
            margin-bottom: 0.8rem;
        }
        
        .mobile-info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #1f2937;
            padding: 0.4rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        
        .mobile-info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.5);
        }
        
        .mobile-info-card .card-title {
            font-size: 0.55rem;
            margin-bottom: 0.2rem;
            color: #374151;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .mobile-info-card .card-value {
            font-size: 0.9rem;
            font-weight: bold;
            color: #1f2937;
        }
        
        /* Current Queue Status - Identical to Desktop Pop-up */
        .current-queue-status {
            background: white;
            margin: 0 0.4rem 0.8rem 0.4rem;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border: none;
            display: none;
            overflow: hidden;
        }
        
        .current-queue-status.show {
            display: block;
        }
        
        /* Header Section - Green with Checkmark */
        .queue-header {
            background: #28a745;
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .success-icon {
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-icon i {
            font-size: 1rem;
            color: white;
        }
        
        .header-text {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .close-icon {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.2s;
        }
        
        .close-icon:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .close-icon i {
            font-size: 1.1rem;
            color: white;
        }
        
        /* Main Content Area */
        .queue-content {
            padding: 1.5rem;
            text-align: center;
        }
        
        .queue-number-display {
            margin-bottom: 1.5rem;
        }
        
        .queue-number {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #28a745;
            margin: 0;
            line-height: 1;
            letter-spacing: 1px;
        }
        
        .queue-category {
            background: #28a745;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .queue-position {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .queue-timestamp {
            font-size: 0.9rem;
            color: #666;
        }
        
        /* Footer Buttons */
        .queue-footer {
            padding: 1rem 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            border-top: 1px solid #e9ecef;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 100px;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
        }
        
        .mobile-service-cards {
            padding: 0 0.4rem;
            margin-bottom: 0.8rem;
        }
        
        .mobile-service-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #1f2937;
            padding: 0.6rem;
            margin-bottom: 0.4rem;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .mobile-service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }
        
        .mobile-service-card:hover::before {
            left: 100%;
        }
        
        .mobile-service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.6);
            background: linear-gradient(135deg, #ffffff 0%, #e3f2fd 100%);
        }
        
        .mobile-service-card.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            border-color: rgba(255,255,255,0.8);
        }
        
        .mobile-service-card .service-name {
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
            color: #1f2937;
            position: relative;
            z-index: 1;
        }
        
        .mobile-service-card .service-description {
            font-size: 0.75rem;
            margin-bottom: 0.2rem;
            opacity: 0.8;
            color: #374151;
            position: relative;
            z-index: 1;
        }
        
        .mobile-service-card .service-prefix {
            font-size: 0.65rem;
            opacity: 0.7;
            color: #6b7280;
            position: relative;
            z-index: 1;
        }
        
        .mobile-service-card.selected .service-name,
        .mobile-service-card.selected .service-description,
        .mobile-service-card.selected .service-prefix {
            color: white;
        }
        
        .mobile-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 0.6rem;
            text-align: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .mobile-bottom-bar button {
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }
        
        .mobile-bottom-bar button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .mobile-bottom-bar button:disabled {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            cursor: not-allowed;
        }
        
        /* Landscape optimization */
        @media (orientation: landscape) {
            .mobile-header {
                padding: 0.5rem;
                margin-bottom: 0.3rem;
            }
            
            .mobile-header h1 {
                font-size: 1rem;
                margin-bottom: 0.2rem;
            }
            
            .mobile-header p {
                font-size: 0.7rem;
                margin-bottom: 0.3rem;
            }
            
            .mobile-info-cards {
                gap: 0.3rem;
                padding: 0.3rem;
                margin-bottom: 0.5rem;
            }
            
            .mobile-info-card {
                padding: 0.3rem;
            }
            
            .mobile-info-card .card-title {
                font-size: 0.5rem;
                margin-bottom: 0.15rem;
            }
            
            .mobile-info-card .card-value {
                font-size: 0.8rem;
            }
            
            .current-queue-status {
                margin: 0 0.3rem 0.5rem 0.3rem;
            }
            
            .queue-header {
                padding: 0.8rem 1.2rem;
            }
            
            .header-text {
                font-size: 1rem;
            }
            
            .success-icon {
                width: 1.8rem;
                height: 1.8rem;
            }
            
            .queue-content {
                padding: 1.2rem;
            }
            
            .queue-number {
                font-size: 3rem;
            }
            
            .queue-category {
                padding: 0.4rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .queue-position {
                font-size: 0.9rem;
            }
            
            .queue-timestamp {
                font-size: 0.8rem;
            }
            
            .queue-footer {
                padding: 0.8rem 1.2rem;
                gap: 0.8rem;
            }
            
            .btn {
                padding: 0.6rem 1.2rem;
                min-width: 90px;
            }
            
            .mobile-service-cards {
                padding: 0 0.3rem;
                margin-bottom: 0.5rem;
            }
            
            .mobile-service-card {
                padding: 0.5rem;
                margin-bottom: 0.3rem;
            }
            
            .mobile-service-card .service-name {
                font-size: 0.8rem;
            }
            
            .mobile-service-card .service-description {
                font-size: 0.7rem;
            }
            
            .mobile-service-card .service-prefix {
                font-size: 0.6rem;
            }
            
            .mobile-bottom-bar {
                padding: 0.5rem;
            }
            
            .mobile-bottom-bar button {
                padding: 0.6rem;
                font-size: 0.8rem;
            }
        }
        
        /* Extra small screens */
        @media (max-width: 360px) {
            .mobile-header h1 {
                font-size: 1.1rem;
            }
            
            .mobile-info-card .card-title {
                font-size: 0.5rem;
            }
            
            .mobile-info-card .card-value {
                font-size: 0.8rem;
            }
            
            .current-queue-status {
                margin: 0 0.3rem 0.5rem 0.3rem;
            }
            
            .queue-header {
                padding: 1rem 1.5rem;
            }
            
            .header-text {
                font-size: 1.1rem;
            }
            
            .success-icon {
                width: 2rem;
                height: 2rem;
            }
            
            .queue-content {
                padding: 1.5rem;
            }
            
            .queue-number {
                font-size: 3.5rem;
            }
            
            .queue-category {
                padding: 0.5rem 1.5rem;
                font-size: 1rem;
            }
            
            .queue-position {
                font-size: 1rem;
            }
            
            .queue-timestamp {
                font-size: 0.9rem;
            }
            
            .queue-footer {
                padding: 1rem 1.5rem;
                gap: 1rem;
            }
            
            .btn {
                padding: 0.75rem 1.5rem;
                min-width: 100px;
            }
            
            .mobile-service-card .service-name {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-header">
        <h1>📱 MESIN ANTRIAN</h1>
        <p>Pilih layanan & ambil nomor</p>
    </div>
    
    <div class="mobile-info-cards">
        <div class="mobile-info-card">
            <div class="card-title">Total</div>
            <div class="card-value" id="mobileTotalAntrian">0</div>
        </div>
        <div class="mobile-info-card">
            <div class="card-title">Dipanggil</div>
            <div class="card-value" id="mobileSedangDipanggil">0</div>
        </div>
        <div class="mobile-info-card">
            <div class="card-title">Menunggu</div>
            <div class="card-value" id="mobileSedangMenunggu">0</div>
        </div>
        <div class="mobile-info-card">
            <div class="card-title">Update</div>
            <div class="card-value" id="mobileUpdateTerakhir">-</div>
        </div>
    </div>
    
    <!-- Current Queue Status - Identical to Desktop -->
    <div class="current-queue-status" id="currentQueueStatus">
        <!-- Header Section - Green with Checkmark -->
        <div class="queue-header">
            <div class="header-content">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="header-text">Nomor Antrian Berhasil</div>
            </div>
            <div class="close-icon" onclick="hideQueueStatus()">
                <i class="fas fa-times"></i>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="queue-content">
            <div class="queue-number-display">
                <div class="queue-number" id="currentNomorAntrian">-</div>
                <div class="queue-category" id="currentKategoriAntrian">-</div>
            </div>
            
            <div class="queue-position">
                <span>Posisi antrian: </span>
                <span id="currentPosisiAntrian">-</span>
            </div>
            
            <div class="queue-timestamp">
                <span>Waktu: </span>
                <span id="currentTimestamp">-</span>
            </div>
        </div>
        
        <!-- Footer Buttons -->
        <div class="queue-footer">
            <button class="btn btn-secondary" onclick="hideQueueStatus()">
                <i class="fas fa-times me-1"></i> Tutup
            </button>
            <button class="btn btn-primary" onclick="printAntrian()">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
        </div>
    </div>
    
    <div class="mobile-service-cards">
        <?php foreach ($kategori as $kat): ?>
        <div class="mobile-service-card" data-kategori-id="<?= $kat['id'] ?>">
            <div class="service-name"><?= $kat['nama_kategori'] ?></div>
            <div class="service-description"><?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?></div>
            <div class="service-prefix">Prefix: <?= $kat['prefix'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="mobile-bottom-bar">
        <button id="mobileBtnAmbil" disabled>
            <span class="btn-text">Pilih layanan terlebih dahulu</span>
        </button>
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
            document.querySelectorAll('.mobile-service-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.mobile-service-card').forEach(c => {
                        c.classList.remove('selected');
                    });
                    
                    this.classList.add('selected');
                    
                    const mobileBtn = document.getElementById('mobileBtnAmbil');
                    mobileBtn.disabled = false;
                    mobileBtn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
                });
            });
            
            document.getElementById('mobileBtnAmbil').addEventListener('click', function() {
                const selectedCard = document.querySelector('.mobile-service-card.selected');
                if (selectedCard) {
                    const kategoriId = selectedCard.dataset.kategoriId;
                    const kategoriNama = selectedCard.querySelector('.service-name').textContent;
                    
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
                            selectedCard.classList.remove('selected');
                            this.disabled = true;
                            this.querySelector('.btn-text').textContent = 'Pilih layanan terlebih dahulu';
                            
                            // Update info cards
                            updateQueueInfo();
                        } else {
                            alert('Gagal mengambil nomor: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil nomor antrian');
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
                        showQueueNumber(queueData);
                        updateQueueInfo();
                    } else {
                        // Remove expired queue
                        localStorage.removeItem(STORAGE_KEY);
                    }
                } catch (e) {
                    localStorage.removeItem(STORAGE_KEY);
                }
            }
        }
        
        function showQueueNumber(queueData) {
            // Use display number for user-friendly view
            const displayNumber = queueData.nomor_antrian || queueData.nomor_antrian_full;
            document.getElementById('currentNomorAntrian').textContent = displayNumber;
            document.getElementById('currentKategoriAntrian').textContent = queueData.kategori;
            
            // Set current timestamp
            const now = new Date();
            const timestamp = now.getFullYear() + '-' + 
                            String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                            String(now.getDate()).padStart(2, '0') + ' ' + 
                            String(now.getHours()).padStart(2, '0') + ':' + 
                            String(now.getMinutes()).padStart(2, '0') + ':' + 
                            String(now.getSeconds()).padStart(2, '0');
            document.getElementById('currentTimestamp').textContent = timestamp;
            
            // Show the current queue status
            document.getElementById('currentQueueStatus').classList.add('show');
            
            // Calculate position and estimated time
            calculateQueuePosition(queueData.antrian_id, queueData.kategori_id);
        }
        
        function hideQueueStatus() {
            document.getElementById('currentQueueStatus').classList.remove('show');
        }
        
        function printAntrian() {
            // Create print content
            const printContent = `
                <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                    <h2>Nomor Antrian</h2>
                    <div style="font-size: 48px; font-weight: bold; color: #28a745; margin: 20px 0;">
                        ${document.getElementById('currentNomorAntrian').textContent}
                    </div>
                    <div style="font-size: 18px; margin: 10px 0;">
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
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
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
                        
                        // Log for debugging
                        console.log('Queue position data:', data);
                        console.log('Position:', posisi);
                    } else {
                        console.log('API response not successful:', data);
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
            // Update info every 30 seconds
            setInterval(() => {
                updateMobileInfo();
                document.getElementById('mobileUpdateTerakhir').textContent = new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }, 30000);
        }
    </script>
</body>
</html>
