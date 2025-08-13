<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Publik - QueueBank ProMax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        
        .display-header {
            background-color: #6c757d;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .display-number {
            font-size: 8rem;
            font-weight: bold;
            color: #dc3545;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .loket-info {
            font-size: 2.5rem;
            color: #495057;
            margin-top: 20px;
        }
        
        .next-queue {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .running-text {
            background-color: #6c757d;
            color: white;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            overflow: hidden;
        }
        
        .running-text p {
            white-space: nowrap;
            animation: scroll-left 20s linear infinite;
            margin: 0;
            font-size: 1.2rem;
        }
        
        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        .queue-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .clock {
            font-size: 2rem;
            color: #6c757d;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="display-header">
        <h1>QueueBank ProMax</h1>
        <p>Sistem Antrian Modern</p>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="queue-card">
                    <h2>Nomor Antrian yang Dipanggil</h2>
                    <div class="display-number" id="currentNumber">-</div>
                    <div class="loket-info" id="currentLoket">-</div>
                </div>
                
                <div class="next-queue">
                    <h4>Antrian Berikutnya</h4>
                    <div id="nextQueue">
                        <p class="text-muted">Menunggu data...</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="clock" id="clock">--:--:--</div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Statistik</h5>
                    </div>
                    <div class="card-body">
                        <p>Total Antrian: <span id="totalAntrian">0</span></p>
                        <p>Antrian Selesai: <span id="completedAntrian">0</span></p>
                        <p>Antrian Menunggu: <span id="waitingAntrian">0</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="running-text">
        <p id="runningText">Selamat datang di QueueBank ProMax. Silakan ambil nomor antrian sesuai kebutuhan Anda. Terima kasih atas kunjungan Anda.</p>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateDisplay() {
            $.get('/display/antrian', function(data) {
                if(data.length > 0) {
                    const current = data.find(item => item.status === 'dipanggil');
                    if(current) {
                        $('#currentNumber').text(current.nomor_antrian);
                        $('#currentLoket').text('Loket: ' + (current.nama_loket || 'Loket ' + current.loket_id));
                    }
                    
                    const next = data.filter(item => item.status === 'menunggu').slice(0, 3);
                    let nextHtml = '';
                    next.forEach(item => {
                        nextHtml += `<p><strong>${item.nomor_antrian}</strong> - ${item.nama_kategori}</p>`;
                    });
                    $('#nextQueue').html(nextHtml || '<p class="text-muted">Tidak ada antrian menunggu</p>');
                    
                    $('#totalAntrian').text(data.length);
                    $('#completedAntrian').text(data.filter(item => item.status === 'selesai').length);
                    $('#waitingAntrian').text(data.filter(item => item.status === 'menunggu').length);
                }
            });
            
            $.get('/display/pengaturan', function(data) {
                if(data.teks_berjalan) {
                    $('#runningText').text(data.teks_berjalan);
                }
            });
        }
        
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID');
            $('#clock').text(timeString);
        }
        
        // Update setiap 2 detik
        setInterval(updateDisplay, 2000);
        setInterval(updateClock, 1000);
        
        // Initial load
        updateDisplay();
        updateClock();
    </script>
</body>
</html>
