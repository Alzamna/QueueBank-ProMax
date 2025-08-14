<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Mobile - QueueBank ProMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: #ffffff;
            padding-bottom: 80px; /* Space for bottom bar */
        }

        /* Mobile Header */
        .mobile-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            padding: 1.5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .mobile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .mobile-header-content {
            position: relative;
            z-index: 10;
        }

        .mobile-header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .mobile-header-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .mobile-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-header p {
            font-size: 0.875rem;
            color: #e2e8f0;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .mobile-header .mode-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            color: #e2e8f0;
            backdrop-filter: blur(10px);
        }

        /* Mobile Info Cards */
        .mobile-info-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-info-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.2s ease;
        }

        .mobile-info-card:active {
            transform: scale(0.98);
        }

        .mobile-info-card .value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .mobile-info-card .label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Mobile Service Cards */
        .mobile-service-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-service-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .mobile-service-card:active {
            transform: scale(0.98);
        }

        .mobile-service-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .mobile-service-card p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .mobile-service-card .prefix {
            display: inline-block;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Mobile Bottom Bar */
        .mobile-bottom-bar {
            background: #6b7280;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 16px 16px 0 0;
            margin: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Landscape orientation adjustments */
        @media (max-width: 480px) and (orientation: landscape) {
            .mobile-header {
                padding: 1rem;
            }

            .mobile-header h1 {
                font-size: 1.25rem;
            }

            .mobile-info-cards {
                grid-template-columns: repeat(4, 1fr);
                gap: 0.5rem;
                padding: 0.5rem;
            }

            .mobile-service-cards {
                flex-direction: row;
                gap: 0.5rem;
                padding: 0.5rem;
            }

            .mobile-service-card {
                padding: 1rem;
                flex: 1;
            }

            .mobile-bottom-bar {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            body {
                padding-bottom: 60px;
            }
        }

        /* Small screen optimizations */
        @media (max-width: 360px) {
            .mobile-header h1 {
                font-size: 1.25rem;
            }

            .mobile-header p {
                font-size: 0.8rem;
            }

            .mobile-info-card .value {
                font-size: 1.25rem;
            }

            .mobile-info-card .label {
                font-size: 0.7rem;
            }

            .mobile-service-card {
                padding: 1.25rem;
            }

            .mobile-service-card h3 {
                font-size: 1rem;
            }

            .mobile-service-card p {
                font-size: 0.8rem;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .mobile-header,
            .mobile-info-card,
            .mobile-service-card,
            .mobile-bottom-bar {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }

        /* Animation for info cards */
        .mobile-info-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .mobile-service-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .mobile-service-card:nth-child(1) { animation-delay: 0.1s; }
        .mobile-service-card:nth-child(2) { animation-delay: 0.2s; }
        .mobile-service-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <header class="mobile-header">
        <div class="mobile-header-content">
            <div class="mobile-header-title">
                <div class="mobile-header-icon">
                    <i class="fas fa-ticket-alt" style="font-size: 1rem; color: white;"></i>
                </div>
                <div>
                    <h1>MESIN ANTRIAN</h1>
                    <p>Silakan pilih kategori layanan dan ambil nomor antrian</p>
                    <div class="mode-indicator">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Mobile Mode</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Info Cards -->
    <div class="mobile-info-cards">
        <div class="mobile-info-card">
            <div class="value" id="mobileTotalAntrian">41</div>
            <div class="label">Total Antrian</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileSedangDipanggil">0</div>
            <div class="label">Sedang Dipanggil</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileSedangMenunggu">-</div>
            <div class="label">Sedang Menunggu</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileUpdateTerakhir">22.40.48</div>
            <div class="label">Update Terakhir</div>
        </div>
    </div>

    <!-- Mobile Service Cards -->
    <div class="mobile-service-cards">
        <div class="mobile-service-card">
            <h3>Teller</h3>
            <p>Layanan teller untuk transaksi perbankan</p>
            <div class="prefix">Prefix: A</div>
        </div>
        <div class="mobile-service-card">
            <h3>Customer Service</h3>
            <p>Layanan customer service untuk informasi dan konsultasi</p>
            <div class="prefix">Prefix: B</div>
        </div>
        <div class="mobile-service-card">
            <h3>Prioritas</h3>
            <p>Layanan prioritas untuk nasabah prioritas</p>
            <div class="prefix">Prefix: C</div>
        </div>
    </div>

    <!-- Mobile Bottom Bar -->
    <div class="mobile-bottom-bar">
        Pilih kategori terlebih dahulu
    </div>

    <script>
        // Sample data for demonstration
        let queueData = [
            {
                id: '1',
                nomor_antrian: 'A001',
                status: 'dipanggil',
                loket_id: 1,
                nama_loket: 'Teller 1',
                nama_kategori: 'Tabungan',
                timestamp: new Date()
            },
            {
                id: '2',
                nomor_antrian: 'A002',
                status: 'menunggu',
                loket_id: 2,
                nama_loket: 'Teller 2',
                nama_kategori: 'Transfer',
                timestamp: new Date()
            },
            {
                id: '3',
                nomor_antrian: 'A003',
                status: 'menunggu',
                loket_id: 1,
                nama_loket: 'Teller 1',
                nama_kategori: 'Deposito',
                timestamp: new Date()
            },
            {
                id: '4',
                nomor_antrian: 'A004',
                status: 'menunggu',
                loket_id: 3,
                nama_loket: 'Customer Service',
                nama_kategori: 'Pembukaan Rekening',
                timestamp: new Date()
            },
            {
                id: '5',
                nomor_antrian: 'A005',
                status: 'menunggu',
                loket_id: 2,
                nama_loket: 'Teller 2',
                nama_kategori: 'Penarikan Tunai',
                timestamp: new Date()
            }
        ];

        // Update display function
        function updateDisplay() {
            // Update statistics
            const total = queueData.length;
            const completed = queueData.filter(item => item.status === 'selesai').length;
            const waiting = queueData.filter(item => item.status === 'menunggu').length;
            const called = queueData.filter(item => item.status === 'dipanggil').length;

            document.getElementById('mobileTotalAntrian').textContent = total;
            document.getElementById('mobileSedangDipanggil').textContent = called;
            document.getElementById('mobileSedangMenunggu').textContent = waiting > 0 ? waiting : '-';
            
            // Update mobile last update time
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('mobileUpdateTerakhir').textContent = timeString;
        }

        // Simulate queue progression
        function simulateQueueProgression() {
            // Randomly progress queue status
            const randomIndex = Math.floor(Math.random() * queueData.length);
            const item = queueData[randomIndex];

            if (item.status === 'menunggu') {
                // Sometimes call a waiting queue
                if (Math.random() > 0.7) {
                    // First, mark current as completed
                    const current = queueData.find(q => q.status === 'dipanggil');
                    if (current) {
                        current.status = 'selesai';
                    }
                    // Then call the next one
                    item.status = 'dipanggil';
                }
            } else if (item.status === 'dipanggil') {
                // Sometimes complete current queue
                if (Math.random() > 0.8) {
                    item.status = 'selesai';
                }
            }

            // Occasionally add new queue items
            if (Math.random() > 0.9 && queueData.length < 10) {
                const newId = (queueData.length + 1).toString();
                const queueNumber = `A${String(queueData.length + 1).padStart(3, '0')}`;
                const services = ['Tabungan', 'Transfer', 'Deposito', 'Pembukaan Rekening', 'Penarikan Tunai', 'Kredit'];
                const lokets = ['Teller 1', 'Teller 2', 'Customer Service'];
                
                queueData.push({
                    id: newId,
                    nomor_antrian: queueNumber,
                    status: 'menunggu',
                    loket_id: Math.floor(Math.random() * 3) + 1,
                    nama_loket: lokets[Math.floor(Math.random() * lokets.length)],
                    nama_kategori: services[Math.floor(Math.random() * services.length)],
                    timestamp: new Date()
                });
            }
        }

        // API simulation functions (replace with actual API calls)
        function fetchQueueData() {
            // In real implementation, replace with:
            // fetch('/display/antrian')
            //     .then(response => response.json())
            //     .then(data => {
            //         queueData = data;
            //         updateDisplay();
            //     });
            
            simulateQueueProgression();
            updateDisplay();
        }

        // Initialize
        function init() {
            updateDisplay();
            
            // Set intervals
            setInterval(fetchQueueData, 3000); // Update queue every 3 seconds
        }

        // Start the application
        document.addEventListener('DOMContentLoaded', init);

        // Add touch feedback for mobile
        document.addEventListener('touchstart', function(e) {
            if (e.target.closest('.mobile-service-card, .mobile-info-card')) {
                const element = e.target.closest('.mobile-service-card, .mobile-info-card');
                element.style.transform = 'scale(0.98)';
            }
        });

        document.addEventListener('touchend', function(e) {
            if (e.target.closest('.mobile-service-card, .mobile-info-card')) {
                const element = e.target.closest('.mobile-service-card, .mobile-info-card');
                setTimeout(() => {
                    element.style.transform = '';
                }, 150);
            }
        });
    </script>
</body>
</html>
