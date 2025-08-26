<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Publik - QueueBank ProMax</title>
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
        }

        .container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            position: relative;
            overflow: hidden;
            padding: 1rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .header-content {
            position: relative;
            z-index: 10;
            text-align: left;
            flex: 1;
            padding-left: 2rem;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.25rem;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        /* Clock in header */
        .header-clock {
            position: relative;
            z-index: 10;
            text-align: right;
            padding-right: 2rem;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .clock-time {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.1rem;
            font-family: 'Inter', monospace;
        }

        .clock-date {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Statistics Section */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
        }
        
        .total-queues { color: #3b82f6; }
        .completed { color: #10b981; }
        .waiting { color: #f59e0b; }
        .called { color: #ef4444; }

        /* Active Queues Container - REVISI UTAMA */
        .queues-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            justify-content: center;
            min-height: 50vh;
        }

        /* Queue Card - REVISI UTAMA */
        .queue-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 320px;
        }

        .queue-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.25);
        }

        .queue-card.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #dc2626, #ef4444, #f87171);
            animation: pulse-glow 2s infinite;
        }

        .queue-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .queue-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .queue-header h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
        }

        .queue-number {
            font-size: 4.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            line-height: 1;
            word-break: break-all;
        }

        .queue-number.animate {
            transform: scale(1.05);
            filter: drop-shadow(0 4px 8px rgba(220, 38, 38, 0.3));
        }

        .queue-details {
            margin-top: 1rem;
        }

        .loket-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .service-info {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
            border-radius: 8px;
            display: inline-block;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .status-active {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #047857;
        }

        .wait-time {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
        }

        .category-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 0.5rem;
            background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
            color: #374151;
        }

        /* Next Queue Section */
        .next-queues-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 1.5rem;
        }

        .next-queues-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .next-queues-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .next-queues-header h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
        }

        .next-queues-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .next-queue-category {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 14px;
            padding: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .next-queue-category h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem;
            background: white;
            border-radius: 10px;
            margin-bottom: 0.6rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .queue-item-left {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .queue-position {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.8rem;
        }

        .position-1 { background: linear-gradient(135deg, #10b981, #059669); }
        .position-2 { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .position-3 { background: linear-gradient(135deg, #6b7280, #4b5563); }

        .queue-details h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.1rem;
        }

        .queue-details p {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Running Text */
        .running-text {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #374151, #4b5563);
            color: white;
            padding: 0.8rem 0;
            overflow: hidden;
            box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .running-text-content {
            white-space: nowrap;
            animation: scroll-left 30s linear infinite;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .running-text-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .running-text-icon {
            color: #60a5fa;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1.5rem;
            color: #6b7280;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            color: #d1d5db;
        }

        .empty-state h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .empty-state p {
            font-size: 0.8rem;
        }

        /* Animation Classes */
        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Responsive Design - REVISI UTAMA */
        @media (max-width: 1400px) {
            .queue-number {
                font-size: 4rem;
            }
            
            .loket-info {
                font-size: 1.3rem;
            }
            
            .service-info {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 1200px) {
            .queues-container {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            }
            
            .queue-number {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 1024px) {
            .header {
                padding: 0.8rem 0;
            }
            
            .header-content {
                padding-left: 1.5rem;
            }
            
            .header-clock {
                padding-right: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .header p {
                font-size: 0.9rem;
            }
            
            .clock-time {
                font-size: 1.6rem;
            }
            
            .queues-container {
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            }
        }

        @media (max-width: 900px) {
            .queues-container {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
            
            .queue-card {
                min-height: 280px;
                padding: 1.25rem;
            }
            
            .queue-number {
                font-size: 3rem;
            }
            
            .loket-info {
                font-size: 1.2rem;
            }
            
            .service-info {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 0.8rem;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                padding: 0.8rem 0;
            }
            
            .header-content {
                text-align: center;
                margin-bottom: 0.8rem;
                padding-left: 0;
            }
            
            .header-clock {
                text-align: center;
                padding-right: 0;
                align-items: center;
            }
            
            .clock-time {
                font-size: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.6rem;
            }
            
            .queues-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .queue-card {
                width: 100%;
                min-height: 250px;
                padding: 1.25rem;
            }
            
            .queue-number {
                font-size: 3.5rem;
            }
            
            .queue-header h3 {
                font-size: 1.2rem;
            }
            
            .loket-info {
                font-size: 1.1rem;
            }
            
            .service-info {
                font-size: 1rem;
            }
            
            .next-queues-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .queue-number {
                font-size: 3rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.4rem;
            }
            
            .header-icon {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Clock -->
    <header class="header">
        <div class="header-content">
            <div class="header-title">
                <div class="header-icon">
                    <i class="fas fa-building" style="font-size: 1rem; color: white;"></i>
                </div>
                <div>
                    <h1>QueueBank ProMax</h1>
                    <p><i class="fas fa-bolt" style="color: #fbbf24; margin-right: 0.5rem;"></i>Sistem Antrian Digital Multi-Loket</p>
                </div>
            </div>
        </div>
        <div class="header-clock">
            <div class="clock-time" id="clock">--:--:--</div>
            <div class="clock-date" id="date">-</div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="main-content">
            <!-- Statistics Section -->
            

            <!-- Active Queues Display -->
            <div class="queues-container" id="queuesContainer">
                <!-- Queue cards will be populated by JavaScript -->
            </div>

            <!-- Next Queue Section -->
            <div class="next-queues-section">
                <div class="next-queues-header">
                    <div class="next-queues-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Antrian Berikutnya</h3>
                </div>
                
                <div class="next-queues-grid" id="nextQueuesGrid">
                    <!-- Next queues will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <!-- Running Text -->
    <div class="running-text">
        <div class="running-text-content" id="runningTextContent">
            <div class="running-text-item">
                <i class="fas fa-star running-text-icon"></i>
                <span>Selamat datang di QueueBank ProMax - Sistem Antrian Digital Multi-Loket</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-ticket-alt running-text-icon"></i>
                <span>Silakan ambil nomor antrian sesuai kebutuhan Anda</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-heart running-text-icon"></i>
                <span>Terima kasih atas kepercayaan Anda kepada layanan kami</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-shield-alt running-text-icon"></i>
                <span>Teknologi Terdepan untuk Efisiensi Pelayanan</span>
            </div>
        </div>
    </div>

    <script>
    // Base URL for API calls
    const baseUrl = '<?= base_url() ?>';

    // Clock function
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const dateString = now.toLocaleDateString('id-ID', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        document.getElementById('clock').textContent = timeString;
        document.getElementById('date').textContent = dateString;
    }

    // Load statistics
    async function loadStatistics() {
        try {
            const response = await fetch(`${baseUrl}display/statistics`);
            const data = await response.json();
            
            if (data.success) {
                const statsContainer = document.getElementById("statsContainer");
                statsContainer.innerHTML = `
                    <div class="stat-card">
                        <div class="stat-value total-queues">${data.data.total}</div>
                        <div class="stat-label">Total Antrian Hari Ini</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value completed">${data.data.selesai}</div>
                        <div class="stat-label">Antrian Selesai</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value waiting">${data.data.menunggu}</div>
                        <div class="stat-label">Antrian Menunggu</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value called">${data.data.dipanggil}</div>
                        <div class="stat-label">Sedang Dipanggil</div>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading statistics:', error);
        }
    }

    // Load and display active queues
    async function loadAllAntrian() {
        try {
            const response = await fetch(`${baseUrl}display/getAntrian`);
            const data = await response.json();
            
            const queuesContainer = document.getElementById("queuesContainer");
            
            if (data.success && data.data && data.data.length > 0) {
                queuesContainer.innerHTML = '';
                
                // Create queue cards for each active queue
                data.data.forEach((antrian, index) => {
                    const queueCard = document.createElement('div');
                    queueCard.classList.add('queue-card', 'active');
                    
                    queueCard.innerHTML = `
                        <div class="queue-header">
                            <div class="queue-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3>Nomor Antrian</h3>
                            <span class="category-badge">${antrian.nama_kategori}</span>
                        </div>
                        <div class="queue-number animate">${antrian.nomor_antrian_display || antrian.nomor_antrian}</div>
                        <div class="queue-details">
                            <div class="loket-info">
                                <i class="fas fa-map-marker-alt" style="color: #3b82f6;"></i>
                                <span>${antrian.nama_loket || 'Belum ditentukan'}</span>
                            </div>
                            <div class="service-info">${antrian.nama_kategori}</div>
                            <div class="status-badge status-active">
                                <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                                Sedang Dipanggil
                            </div>
                            ${antrian.waktu_panggil ? `
                            <div class="wait-time">
                                <i class="fas fa-clock"></i>
                                Dipanggil: ${new Date(antrian.waktu_panggil).toLocaleTimeString('id-ID')}
                            </div>
                            ` : ''}
                        </div>
                    `;
                    
                    queuesContainer.appendChild(queueCard);
                });
            } else {
                queuesContainer.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>Belum Ada Antrian Aktif</h4>
                        <p>Sistem menunggu antrian yang dipanggil...</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading queues:', error);
            document.getElementById("queuesContainer").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Gagal Memuat Data</h4>
                    <p>Terjadi kesalahan saat memuat data antrian</p>
                </div>
            `;
        }
    }

    // Load next queues
    async function loadNextQueues() {
        try {
            const response = await fetch(`${baseUrl}display/getNextQueue`);
            const data = await response.json();
            
            const nextQueuesGrid = document.getElementById("nextQueuesGrid");
            
            if (data.success && data.data && data.data.length > 0) {
                nextQueuesGrid.innerHTML = '';
                
                // Create a section for each category
                data.data.forEach(category => {
                    const categoryDiv = document.createElement('div');
                    categoryDiv.classList.add('next-queue-category');
                    
                    categoryDiv.innerHTML = `
                        <h4>${category.kategori} <span class="category-badge">${category.prefix}</span></h4>
                    `;
                    
                    // Add next queues for this category
                    if (category.queues && category.queues.length > 0) {
                        category.queues.forEach(queue => {
                            const positionClass = queue.position === 1 ? 'position-1' : 
                                                queue.position === 2 ? 'position-2' : 'position-3';
                            
                            const queueItem = document.createElement('div');
                            queueItem.classList.add('queue-item');
                            queueItem.innerHTML = `
                                <div class="queue-item-left">
                                    <div class="queue-position ${positionClass}">${queue.position}</div>
                                    <div class="queue-details">
                                        <h4>${queue.nomor_antrian}</h4>
                                        <p>${new Date(queue.waktu_ambil).toLocaleTimeString('id-ID')}</p>
                                    </div>
                                </div>
                            `;
                            categoryDiv.appendChild(queueItem);
                        });
                    } else {
                        categoryDiv.innerHTML += `
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <p>Tidak ada antrian menunggu</p>
                            </div>
                        `;
                    }
                    
                    nextQueuesGrid.appendChild(categoryDiv);
                });
            } else {
                nextQueuesGrid.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <h4>Tidak Ada Antrian Berikutnya</h4>
                        <p>Sistem menunggu antrian berikutnya...</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading next queues:', error);
        }
    }

    // Initialize the application
    document.addEventListener('DOMContentLoaded', function() {
        updateClock();
        setInterval(updateClock, 1000);
        
        // Load initial data
        loadStatistics();
        loadAllAntrian();
        loadNextQueues();
        
        // Set up periodic refresh
        setInterval(loadStatistics, 30000); // refresh stats every 30 seconds
        setInterval(loadAllAntrian, 5000);  // refresh queues every 5 seconds
        setInterval(loadNextQueues, 10000); // refresh next queues every 10 seconds
    });
    </script>
</body>
</html>