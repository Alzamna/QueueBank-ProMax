<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-center">Ambil Nomor Antrian</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pilih Kategori Layanan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($kategori as $kat): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= $kat['nama_kategori'] ?></h5>
                                        <p class="card-text"><?= $kat['deskripsi'] ?></p>
                                        <button class="btn btn-primary btn-lg" onclick="ambilNomor(<?= $kat['id'] ?>, '<?= $kat['nama_kategori'] ?>')">
                                            Ambil Nomor
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cek Status Antrian</h5>
                </div>
                <div class="card-body">
                    <form id="cekStatusForm">
                        <div class="mb-3">
                            <label for="nomor_antrian" class="form-label">Nomor Antrian</label>
                            <input type="text" class="form-control" id="nomor_antrian" placeholder="Masukkan nomor antrian">
                        </div>
                        <button type="submit" class="btn btn-info">Cek Status</button>
                    </form>
                    <div id="statusResult" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan nomor antrian -->
<div class="modal fade" id="nomorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nomor Antrian Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h1 id="nomorAntrian" class="display-1 text-primary"></h1>
                <p id="kategoriAntrian" class="lead"></p>
                <p id="waktuTunggu" class="text-muted"></p>
                <div id="qrcode" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printAntrian()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function ambilNomor(kategoriId, kategoriNama) {
    $.post('/ambil-nomor', {kategori_id: kategoriId}, function(response) {
        if(response.success) {
            $('#nomorAntrian').text(response.nomor_antrian);
            $('#kategoriAntrian').text('Kategori: ' + kategoriNama);
            $('#waktuTunggu').text('Silakan tunggu panggilan di display');
            
            // Generate QR Code
            const qrcode = new QRCode(document.getElementById("qrcode"), {
                text: response.nomor_antrian,
                width: 128,
                height: 128
            });
            
            $('#nomorModal').modal('show');
        }
    });
}

$('#cekStatusForm').on('submit', function(e) {
    e.preventDefault();
    const nomor = $('#nomor_antrian').val();
    
    $.get('/cek-status/' + nomor, function(response) {
        let html = '';
        if(response.success === false) {
            html = '<div class="alert alert-danger">Nomor antrian tidak ditemukan</div>';
        } else {
            html = `
                <div class="alert alert-info">
                    <h6>Nomor Antrian: ${response.nomor_antrian}</h6>
                    <p>Status: ${response.status}</p>
                    <p>Kategori: ${response.nama_kategori}</p>
                    ${response.sisa_antrian ? `<p>Sisa antrian di depan: ${response.sisa_antrian}</p>` : ''}
                </div>
            `;
        }
        $('#statusResult').html(html);
    });
});

function printAntrian() {
    const nomor = $('#nomorAntrian').text();
    const kategori = $('#kategoriAntrian').text();
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Nomor Antrian</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; }
                    .nomor { font-size: 48px; font-weight: bold; margin: 20px 0; }
                    .kategori { font-size: 24px; margin: 10px 0; }
                    .waktu { font-size: 16px; color: #666; }
                </style>
            </head>
            <body>
                <h1>QueueBank ProMax</h1>
                <div class="nomor">${nomor}</div>
                <div class="kategori">${kategori}</div>
                <div class="waktu">Waktu: ${new Date().toLocaleString('id-ID')}</div>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}
</script>

<!-- Include QR Code library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<?= $this->endSection() ?>
