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
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
            text-align: center;
        }

        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.25rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        /* Multiple Queue Display */
        .active-queues {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .queue-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .queue-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.25);
        }

        .queue-card.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626, #ef4444, #f87171);
            animation: pulse-glow 2s infinite;
        }

        .queue-card.waiting::before {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .queue-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .queue-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .queue-number {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .queue-number.animate {
            transform: scale(1.05);
            filter: drop-shadow(0 4px 8px rgba(220, 38, 38, 0.3));
        }

        .loket-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            margin-top: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.75rem;
        }

        .status-active {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #047857;
        }

        .status-waiting {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }

        /* Next Queue Section */
        .next-queue {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .next-queue-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .next-queue-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .next-queue h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            margin-bottom: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .queue-item-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .queue-position {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.875rem;
        }

        .position-1 { background: linear-gradient(135deg, #10b981, #059669); }
        .position-2 { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .position-3 { background: linear-gradient(135deg, #6b7280, #4b5563); }

        .queue-details h4 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .queue-details p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Clock Card */
        .clock-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .clock-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .clock-icon {
            color: #3b82f6;
        }

        .clock-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .clock-time {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Inter', monospace;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .clock-date {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Statistics Card */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stats-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .stats-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .stat-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-item-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .stat-total { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .stat-total .stat-item-icon { background: #3b82f6; }

        .stat-completed { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }
        .stat-completed .stat-item-icon { background: #10b981; }

        .stat-waiting { background: linear-gradient(135deg, #fef3c7, #fde68a); }
        .stat-waiting .stat-item-icon { background: #f59e0b; }

        .stat-label {
            font-weight: 500;
            color: #374151;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .stat-total .stat-value { color: #1e40af; }
        .stat-completed .stat-value { color: #047857; }
        .stat-waiting .stat-value { color: #d97706; }

        /* Running Text */
        .running-text {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #374151, #4b5563);
            color: white;
            padding: 1rem 0;
            overflow: hidden;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .running-text-content {
            white-space: nowrap;
            animation: scroll-left 30s linear infinite;
            font-size: 1.125rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .running-text-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .running-text-icon {
            color: #60a5fa;
        }

        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }

        .empty-state h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .active-queues {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
            
            .queue-number {
                font-size: 3rem;
            }
            
            .header h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .active-queues {
                grid-template-columns: 1fr;
            }
            
            .queue-card,
            .next-queue,
            .clock-card,
            .stats-card {
                padding: 1.5rem;
            }
            
            .queue-number {
                font-size: 2.5rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
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
    <!-- Header -->
    <header class="header">
        <div class="container">
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
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="main-content">
            <!-- Left Column -->
            <div>
                <!-- Active Queues Display -->
                <div class="active-queues" id="activeQueues">
                    <!-- Queue cards will be populated by JavaScript -->
                </div>

                <!-- Next Queue -->
                <div class="next-queue fade-in">
                    <div class="next-queue-header">
                        <div class="next-queue-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Antrian Berikutnya</h3>
                    </div>
                    
                    <div id="nextQueue">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h4>Menunggu Data</h4>
                            <p>Sistem sedang memuat informasi antrian...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="sidebar">
                <!-- Clock -->
                <div class="clock-card fade-in">
                    <div class="clock-header">
                        <i class="fas fa-clock clock-icon"></i>
                        <h3>Waktu Saat Ini</h3>
                    </div>
                    <div class="clock-time" id="clock">--:--:--</div>
                    <div class="clock-date" id="date">-</div>
                </div>

                <!-- Statistics -->
                <div class="stats-card fade-in">
                    <div class="stats-header">
                        <div class="stats-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3>Statistik Antrian</h3>
                    </div>
                    
                    <div class="stat-item stat-total">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="stat-label">Total Antrian</span>
                        </div>
                        <span class="stat-value" id="totalAntrian">0</span>
                    </div>
                    
                    <div class="stat-item stat-completed">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="stat-label">Selesai</span>
                        </div>
                        <span class="stat-value" id="completedAntrian">0</span>
                    </div>
                    
                    <div class="stat-item stat-waiting">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <span class="stat-label">Menunggu</span>
                        </div>
                        <span class="stat-value" id="waitingAntrian">0</span>
                    </div>
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

    // Load and display multiple active queues
    function loadAllAntrian() {
        fetch("<?= base_url('display/antrian') ?>")
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    const activeQueuesContainer = document.getElementById("activeQueues");
                    activeQueuesContainer.innerHTML = '';

                    // Create queue cards for each active queue
                    data.data.forEach((antrian, index) => {
                        const queueCard = document.createElement('div');
                        queueCard.classList.add('queue-card', antrian.status === 'dipanggil' ? 'active' : 'waiting');
                        
                        queueCard.innerHTML = `
                            <div class="queue-header">
                                <div class="queue-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h3>Nomor Antrian</h3>
                            </div>
                            <div class="queue-number animate">${antrian.nomor_antrian}</div>
                            <div class="loket-info">
                                <i class="fas fa-map-marker-alt" style="color: #3b82f6;"></i>
                                <span>${antrian.nama_loket}</span>
                            </div>
                            <div class="status-badge ${antrian.status === 'dipanggil' ? 'status-active' : 'status-waiting'}">
                                <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                                ${antrian.layanan}
                            </div>
                        `;
                        
                        activeQueuesContainer.appendChild(queueCard);
                        
                        // Add animation delay for each card
                        setTimeout(() => {
                            queueCard.style.animationDelay = `${index * 0.2}s`;
                        }, 100);
                    });

                    // Update next queue
                    updateNextQueue(data.nextQueue);
                    
                    // Update statistics
                    updateStatistics(data.stats);
                } else {
                    document.getElementById("activeQueues").innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h4>Belum Ada Antrian Aktif</h4>
                            <p>Sistem menunggu antrian yang dipanggil...</p>
                        </div>
                    `;
                }
            })
            .catch(err => console.error("Failed to load all queues:", err));
    }

    // Load and display active queues and next queue
function loadQueues() {
    fetch("<?= base_url('display/antrian') ?>")
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data) {
                const activeQueuesContainer = document.getElementById("activeQueues");
                activeQueuesContainer.innerHTML = '';

                // Create queue cards for each active queue
                data.data.forEach((antrian) => {
                    const queueCard = document.createElement('div');
                    queueCard.classList.add('queue-card', 'fade-in', antrian.status === 'dipanggil' ? 'active' : 'waiting');
                    
                    queueCard.innerHTML = `
                        <div class="queue-header">
                            <div class="queue-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3>Nomor Antrian</h3>
                        </div>
                        <div class="queue-number animate">${antrian.nomor_antrian}</div>
                        <div class="loket-info">
                            <i class="fas fa-map-marker-alt" style="color: #3b82f6;"></i>
                            <span>${antrian.nama_loket}</span>
                        </div>
                        <div class="status-badge ${antrian.status === 'dipanggil' ? 'status-active' : 'status-waiting'}">
                            <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                            ${antrian.layanan}
                        </div>
                    `;
                    
                    activeQueuesContainer.appendChild(queueCard);
                });

                // Update next queue
                updateNextQueue(data.nextQueue);
            } else {
                document.getElementById("activeQueues").innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>Belum Ada Antrian Aktif</h4>
                        <p>Sistem menunggu antrian yang dipanggil...</p>
                    </div>
                `;
            }
        })
        .catch(err => console.error("Failed to load queues:", err));
}

    // Update next queue section
function updateNextQueue(nextQueueData) {
    const nextQueueContainer = document.getElementById("nextQueue");
    
    if (nextQueueData && nextQueueData.length > 0) {
        nextQueueContainer.innerHTML = '';
        
        nextQueueData.forEach((queue, index) => {
            const queueItem = document.createElement('div');
            queueItem.classList.add('queue-item');
            queueItem.innerHTML = `
                <div class="queue-item-left">
                    <div class="queue-position">${index + 1}</div>
                    <div class="queue-details">
                        <h4>${queue.nomor_antrian}</h4>
                        <p>${queue.layanan}</p>
                    </div>
                </div>
                <div class="queue-status">
                    Est. ${queue.estimasi}
                </div>
            `;
            nextQueueContainer.appendChild(queueItem);
        });
    } else {
        nextQueueContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-clock"></i>
                <h4>Tidak Ada Antrian Berikutnya</h4>
                <p>Sistem menunggu antrian berikutnya...</p>
            </div>
        `;
    }
}

    // Update statistics
    function updateStatistics(stats) {
        if (stats) {
            document.getElementById('totalAntrian').textContent = stats.total;
            document.getElementById('completedAntrian').textContent = stats.completed;
            document.getElementById('waitingAntrian').textContent = stats.waiting;
        }
    }

    // Initialize the application
    document.addEventListener('DOMContentLoaded', function() {
        updateClock();
        setInterval(updateClock, 1000);
        
        loadAllAntrian();
        setInterval(loadAllAntrian, 3000); // refresh every 3 seconds
    });
</script>

</body>
</html>

