<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .queue-machine {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      padding: 2rem;
      margin: 2rem auto;
      max-width: 1200px;
      width: 100%;
    }
    .header {
      text-align: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 3px solid #1e3c72;
    }
    .header h1 {
      color: #1e3c72;
      font-weight: bold;
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }
    .header p {
      color: #374151;
      font-size: 1.1rem;
      margin: 0;
      font-weight: 500;
    }
    .category-card {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border: none;
      border-radius: 15px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
      cursor: pointer;
      height: 200px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .category-card.selected {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      color: white;
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(30, 60, 114, 0.4);
    }
    .category-card.selected .category-name,
    .category-card.selected .category-description,
    .category-card.selected small,
    .category-card.selected strong {
      color: white !important;
    }
    .category-name {
      font-size: 1.5rem;
      font-weight: bold;
      color: #1f2937;
      margin-bottom: 1rem;
      text-align: center;
    }
    .category-description {
      color: #374151;
      font-size: 1rem;
      font-weight: 500;
      text-align: center;
      line-height: 1.5;
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-ambil {
      background: linear-gradient(135deg, #1e90ff 0%, #007bff 100%);
      border: none;
      border-radius: 50px;
      padding: 1rem 3rem;
      font-size: 1.2rem;
      font-weight: bold;
      color: white;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 1rem;
    }
    .btn-ambil:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
      color: white;
    }
    .btn-ambil:disabled {
      background: #6c757d;
      cursor: not-allowed;
    }
    .result-modal .modal-content {
      border-radius: 20px;
      border: none;
    }
    .result-modal .modal-header {
      background: linear-gradient(135deg, #1e90ff 0%, #007bff 100%);
      color: white;
      border-radius: 20px 20px 0 0;
      border: none;
    }
    .queue-number {
      font-size: 4rem;
      font-weight: bold;
      color: #1e90ff;
      text-align: center;
      margin: 1rem 0;
    }
    .queue-info {
      text-align: center;
      margin: 1rem 0;
    }
    .stats-card {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      height: 120px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .stats-number {
      font-size: 2.5rem;
      font-weight: bold;
      color: #1e3c72;
      margin-bottom: 0.5rem;
    }
    .stats-label {
      color: #374151;
      font-size: 0.9rem;
      font-weight: 600;
    }
    .loading { display: none; }
    .spinner-border-sm { width: 1rem; height: 1rem; }

    /* Responsive */
    @media (max-width: 1200px) {
      .queue-machine { max-width: 95%; }
    }
    @media (max-width: 768px) {
      .queue-machine { max-width: 98%; padding: 1rem; }
      .category-card { height: 180px; padding: 1.5rem; }
      .stats-card { height: 100px; padding: 1rem; }
      .stats-number { font-size: 2rem; }
      .category-name { font-size: 1.3rem; }
      .category-description { font-size: 0.9rem; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="queue-machine">
      <!-- Header -->
      <div class="header">
        <h1><i class="fas fa-ticket-alt"></i> MESIN ANTRIAN</h1>
        <p>Silakan pilih kategori layanan dan ambil nomor antrian</p>
        <div class="text-muted">
          <small><i class="fas fa-desktop"></i> Desktop Mode</small>
        </div>
      </div>

      <!-- Categories -->
      <div class="row" id="categories">
        <?php foreach ($kategori as $kat): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="category-card" data-kategori-id="<?= $kat['id'] ?>">
            <div class="category-name"><?= $kat['nama_kategori'] ?></div>
            <div class="category-description"><?= $kat['deskripsi'] ?? 'Layanan ' . $kat['nama_kategori'] ?></div>
            <div class="text-dark text-center">
              <small class="fw-semibold">Prefix: <strong class="text-primary"><?= $kat['prefix'] ?></strong></small>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Action Button -->
      <div class="row mt-4">
        <div class="col-12">
          <button class="btn btn-ambil" id="btnAmbil" disabled>
            <span class="btn-text">Pilih kategori terlebih dahulu</span>
            <span class="loading">
              <span class="spinner-border spinner-border-sm"></span>
              Memproses...
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Result Modal -->
  <div class="modal fade result-modal" id="resultModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-check-circle"></i> Nomor Antrian Berhasil</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <div class="queue-number" id="modalNomorAntrian"></div>
          <div class="queue-info">
            <h6 id="modalKategori"></h6>
            <p class="text-muted">Posisi antrian: <span id="modalPosisi"></span></p>
            <p class="text-muted">Waktu: <span id="modalWaktu"></span></p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button class="btn btn-primary" onclick="printQueue()"><i class="fas fa-print"></i> Cetak</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let selectedKategori = null;
    let currentQueueData = null;

    document.addEventListener('DOMContentLoaded', function() {
      loadStatistics();
      setupEventListeners();
      setInterval(loadStatistics, 30000);
    });

    function setupEventListeners() {
      document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', () => selectCategory(card));
      });
      document.getElementById('btnAmbil').addEventListener('click', () => {
        if (selectedKategori) takeQueue();
      });
    }

    function selectCategory(card) {
      document.querySelectorAll('.category-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      selectedKategori = card.dataset.kategoriId;
      const btn = document.getElementById('btnAmbil');
      btn.disabled = false;
      btn.querySelector('.btn-text').textContent = 'Ambil Nomor Antrian';
    }

    async function takeQueue() {
      if (!selectedKategori) return;
      const btn = document.getElementById('btnAmbil');
      const btnText = btn.querySelector('.btn-text');
      const loading = btn.querySelector('.loading');
      btnText.style.display = 'none';
      loading.style.display = 'inline-block';
      btn.disabled = true;

      try {
        const response = await fetch('/desktop/ambilNomorDesktop', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded','X-Requested-With': 'XMLHttpRequest' },
          body: new URLSearchParams({ kategori_id: selectedKategori })
        });
        const data = await response.json();
        if (data.success) {
          currentQueueData = data;
          showResultModal(data);
          loadStatistics();
        } else {
          alert('Error: ' + data.message);
        }
      } catch {
        alert('Terjadi kesalahan saat mengambil nomor antrian');
      } finally {
        btnText.style.display = 'inline-block';
        loading.style.display = 'none';
        btn.disabled = false;
      }
    }

    function showResultModal(data) {
      document.getElementById('modalNomorAntrian').textContent = data.nomor_antrian;
      document.getElementById('modalKategori').textContent = data.kategori;
      document.getElementById('modalPosisi').textContent = data.posisi_antrian + 1;
      document.getElementById('modalWaktu').textContent = data.timestamp;
      new bootstrap.Modal(document.getElementById('resultModal')).show();
    }

    async function loadStatistics() {
      try {
        const response = await fetch('/desktop/getStatistikHarian');
        const data = await response.json();
        if (data.success) updateStatistics(data.statistik);
      } catch (error) { console.error(error); }
    }

    function updateStatistics(statistik) {
      let totalAntrian = 0, totalDipanggil = 0;
      statistik.forEach(stat => {
        totalAntrian += stat.total_antrian;
        totalDipanggil += stat.antrian_dipanggil.length;
      });
      document.getElementById('total-antrian').textContent = totalAntrian;
      document.getElementById('antrian-dipanggil').textContent = totalDipanggil;
      document.getElementById('timestamp').textContent = new Date().toLocaleTimeString('id-ID');
    }

    function printQueue() {
      if (!currentQueueData) return;
      const w = window.open('', '_blank');
      w.document.write(`
        <html><head><title>Nomor Antrian</title>
        <style>
          body { font-family: Arial; text-align: center; padding: 20px; }
          .queue-number { font-size: 48px; font-weight: bold; color: #1e90ff; margin: 20px 0; }
          .timestamp { color: #666; font-size: 14px; }
        </style></head><body>
        <h2>NOMOR ANTRIAN</h2>
        <div class="queue-number">${currentQueueData.nomor_antrian}</div>
        <h3>${currentQueueData.kategori}</h3>
        <p>Posisi: ${currentQueueData.posisi_antrian + 1}</p>
        <p>Waktu: ${currentQueueData.timestamp}</p>
        <div class="timestamp">Dicetak pada: ${new Date().toLocaleString('id-ID')}</div>
        </body></html>
      `);
      w.document.close();
      w.print();
    }
  </script>
</body>
</html>