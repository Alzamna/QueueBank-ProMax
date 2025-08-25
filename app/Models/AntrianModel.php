<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = 'antrians';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nomor_antrian', 'kategori_id', 'loket_id', 'petugas_id', 'status', 'waktu_ambil', 'device_type', 'device_id', 'user_agent', 'ip_address', 'waktu_panggil', 'waktu_selesai'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nomor_antrian' => 'required|max_length[20]',
        'kategori_id' => 'required|integer',
        'status' => 'required|in_list[menunggu,dipanggil,selesai,lewati]',
    ];

    protected $skipValidation = false;

    public function getAntrianAktif($kategori_id = null, $user_id = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'menunggu')
            ->orderBy('antrians.id', 'ASC');

        if ($kategori_id !== null) {
            $builder->where('antrians.kategori_id', $kategori_id);
        }

        // If user_id is provided, filter by user's assigned categories
        if ($user_id !== null) {
            $builder->join('user_kategori', 'user_kategori.kategori_id = antrians.kategori_id')
                    ->where('user_kategori.user_id', $user_id);
        }

        return $builder->get()->getResultArray();
    }



    public function getNextNomorAntrian($kategori_id)
    {
        // Validate input
        if (!$kategori_id || !is_numeric($kategori_id)) {
            return null;
        }

        $kategori = $this->db->table('kategori_antrians')
                             ->where('id', $kategori_id)
                             ->where('status', 'aktif')
                             ->get()
                             ->getRowArray();
        
        if (!$kategori) {
            return null;
        }

        $prefix = $kategori['prefix'];
        $today = date('Y-m-d');

        // Get the last queue number for today
        $lastAntrian = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('DATE(waktu_ambil)', $today)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();

        $nextNumber = 1;
        if ($lastAntrian) {
            // Extract number from existing queue number
            // Handle both old format (PREFIX+DATE+NUMBER) and new format (PREFIX+NUMBER)
            $nomor = $lastAntrian['nomor_antrian'];
            if (strlen($nomor) >= 9) {
                // Old format: {PREFIX}{DATE}{NUMBER} (e.g., A240101001)
                $lastNumber = (int)substr($nomor, -3);
            } else {
                // New format: {PREFIX}{NUMBER} (e.g., A001)
                $lastNumber = (int)substr($nomor, 1);
            }
            $nextNumber = $lastNumber + 1;
        }

        // Format: prefix + 3-digit number (e.g., A001, C001)
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getAntrianDipanggil()
    {
        return $this->db->table($this->table . ' as a')
            ->select('a.*, k.nama_kategori, k.prefix, l.nama_loket, u.nama_lengkap as petugas')
            ->join('kategori_antrians k', 'k.id = a.kategori_id')
            ->join('lokets l', 'l.id = a.loket_id', 'left')
            ->join('users u', 'u.id = a.petugas_id', 'left')
            ->where('a.status', 'dipanggil')
            ->where('a.waktu_panggil IS NOT NULL')
            ->orderBy('a.waktu_panggil', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAllAntrian()
    {
        return $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, lokets.nama_loket')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->whereIn('antrians.status', ['dipanggil']) // Get both waiting and called
            ->orderBy('lokets.nama_loket, antrians.id', 'ASC') // Order by loket and then by antrian id
            ->get()
            ->getResultArray();
    }




    /**
     * Get called queue numbers by kategori
     * @param int $kategori_id
     * @param int $user_id
     * @return array
     */
    public function getAntrianDipanggilByKategori($kategori_id, $user_id = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'dipanggil')
            ->where('antrians.kategori_id', $kategori_id)
            ->orderBy('antrians.id', 'DESC');

        // If user_id is provided, filter by user's assigned categories
        if ($user_id !== null) {
            $builder->join('user_kategori', 'user_kategori.kategori_id = antrians.kategori_id')
                    ->where('user_kategori.user_id', $user_id);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get called queue numbers for today only
     * @param int $kategori_id
     * @return int
     */
    public function getAntrianDipanggilHariIni($kategori_id = null)
    {
        $builder = $this->db->table($this->table)
            ->where('status', 'dipanggil')
            ->where('DATE(waktu_panggil)', date('Y-m-d'));

        if ($kategori_id !== null) {
            $builder->where('kategori_id', $kategori_id);
        }

        return $builder->countAllResults();
    }

    /**
     * Get completed queue numbers by category
     * @param int $kategori_id
     * @param int $user_id
     * @return array
     */
    public function getAntrianSelesaiByKategori($kategori_id, $user_id = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'selesai')
            ->where('antrians.kategori_id', $kategori_id)
            ->where('DATE(antrians.waktu_selesai)', date('Y-m-d'))
            ->orderBy('antrians.waktu_selesai', 'DESC')
            ->limit(10); // Show last 10 completed queues

        // If user_id is provided, filter by user's assigned categories
        if ($user_id !== null) {
            $builder->join('user_kategori', 'user_kategori.kategori_id = antrians.kategori_id')
                    ->where('user_kategori.user_id', $user_id);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get skipped queue numbers by category
     * @param int $kategori_id
     * @param int $user_id
     * @return array
     */
    public function getAntrianDilewatiByKategori($kategori_id, $user_id = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'lewati')
            ->where('antrians.kategori_id', $kategori_id)
            ->where('DATE(antrians.waktu_selesai)', date('Y-m-d'))
            ->orderBy('antrians.waktu_selesai', 'DESC')
            ->limit(10); // Show last 10 skipped queues

        // If user_id is provided, filter by user's assigned categories
        if ($user_id !== null) {
            $builder->join('user_kategori', 'user_kategori.kategori_id = antrians.kategori_id')
                    ->where('user_kategori.user_id', $user_id);
        }

        return $builder->get()->getResultArray();
    }

    public function getAntrianSelesai($loket_id = null, $limit = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'selesai')
            ->orderBy('antrians.waktu_selesai', 'DESC');

        if ($loket_id !== null) {
            $builder->where('antrians.loket_id', $loket_id);
        }

        if ($limit !== null) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function getStatistikHarian($tanggal = null)
    {
        if ($tanggal === null) {
            $tanggal = date('Y-m-d');
        }

        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.kategori_id, kategori_antrians.nama_kategori, COUNT(*) as total_antrian, AVG(TIMESTAMPDIFF(SECOND, antrians.waktu_ambil, antrians.waktu_selesai)) as rata_rata_waktu')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->where('DATE(antrians.waktu_ambil)', $tanggal)
            ->where('antrians.status', 'selesai')
            ->groupBy('antrians.kategori_id, kategori_antrians.nama_kategori')
            ->orderBy('antrians.kategori_id', 'ASC');

        $result = $builder->get()->getResultArray();
        
        // Handle NULL values for rata_rata_waktu
        foreach ($result as &$item) {
            if ($item['rata_rata_waktu'] === null) {
                $item['rata_rata_waktu'] = 0;
            }
        }
        
        return $result;
    }

    /**
     * Check if mobile device already has an active queue number
     * @param string $device_id
     * @return array|null
     */
    public function getAntrianAktifMobile($device_id)
    {
        if (!$device_id) {
            return null;
        }

        return $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->where('antrians.device_id', $device_id)
            ->where('antrians.status', 'menunggu')
            ->where('DATE(antrians.waktu_ambil)', date('Y-m-d'))
            ->orderBy('antrians.id', 'DESC')
            ->get()
            ->getRowArray();
    }

    /**
     * Get queue position for a specific number
     * @param int $antrian_id
     * @param int $kategori_id
     * @return int
     */
    public function getPosisiAntrian($antrian_id, $kategori_id)
    {
        return $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'menunggu')
            ->where('DATE(waktu_ambil)', date('Y-m-d'))
            ->where('id <', $antrian_id)
            ->countAllResults();
    }

    /**
     * Get total active queue for a category
     * @param int $kategori_id
     * @return int
     */
    public function getTotalAntrianAktif($kategori_id)
    {
        return $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'menunggu')
            ->where('DATE(waktu_ambil)', date('Y-m-d'))
            ->countAllResults();
    }

    /**
     * Clean up old queue data (for maintenance)
     * @param int $days_old Number of days to keep
     * @return int Number of deleted records
     */
    public function cleanupOldAntrian($days_old = 30)
    {
        $cutoff_date = date('Y-m-d', strtotime("-{$days_old} days"));
        
        return $this->db->table($this->table)
            ->where('DATE(waktu_ambil) <', $cutoff_date)
            ->whereIn('status', ['selesai', 'lewati'])
            ->delete();
    }

    /**
     * Get today's queue summary
     * @return array
     */
    public function getTodaySummary()
    {
        $today = date('Y-m-d');
        
        $summary = $this->db->table($this->table . ' as antrians')
            ->select('
                kategori_antrians.nama_kategori,
                kategori_antrians.prefix,
                COUNT(CASE WHEN antrians.status = "menunggu" THEN 1 END) as menunggu,
                COUNT(CASE WHEN antrians.status = "dipanggil" THEN 1 END) as dipanggil,
                COUNT(CASE WHEN antrians.status = "selesai" THEN 1 END) as selesai,
                COUNT(CASE WHEN antrians.status = "lewati" THEN 1 END) as lewati,
                COUNT(*) as total
            ')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->where('DATE(antrians.waktu_ambil)', $today)
            ->groupBy('antrians.kategori_id, kategori_antrians.nama_kategori, kategori_antrians.prefix')
            ->orderBy('antrians.kategori_id', 'ASC')
            ->get()
            ->getResultArray();
            
        return $summary;
    }

    /**
     * Get user-friendly queue number for display
     * @param string $nomor_antrian
     * @return string
     */
    public function getDisplayNomorAntrian($nomor_antrian)
    {
        // Handle both old format (PREFIX+DATE+NUMBER) and new format (PREFIX+NUMBER)
        if (strlen($nomor_antrian) >= 9) {
            // Old format: {PREFIX}{DATE}{NUMBER} -> Display: {PREFIX}{NUMBER}
            $prefix = substr($nomor_antrian, 0, 1);
            $number = substr($nomor_antrian, -3);
            return $prefix . $number;
        } else {
            // New format: {PREFIX}{NUMBER} (e.g., A001, C001)
            return $nomor_antrian;
        }
    }

    /**
     * Get full queue number from display number and date
     * @param string $display_number
     * @param string $date
     * @return string
     */
    public function getFullNomorAntrian($display_number, $date = null)
    {
        // For new format, the number is already in the correct format
        // Format: {PREFIX}{NUMBER} (e.g., A001, C001)
        // This method is kept for backward compatibility but now returns the same value
        return $display_number;
    }

    /**
     * Get statistics for a specific kategori
     * @param int $kategori_id
     * @return array
     */
    public function getStatistikKategori($kategori_id)
    {
        $today = date('Y-m-d');
        
        // Get statistics for today based on waktu_ambil
        $stats = $this->db->table($this->table)
            ->select('
                status,
                COUNT(*) as total
            ')
            ->where('kategori_id', $kategori_id)
            ->where('DATE(waktu_ambil)', $today)
            ->groupBy('status')
            ->get()
            ->getResultArray();

        $result = [
            'menunggu' => 0,
            'dipanggil' => 0,
            'selesai' => 0,
            'lewati' => 0
        ];

        foreach ($stats as $stat) {
            if (isset($result[$stat['status']])) {
                $result[$stat['status']] = (int)$stat['total'];
            }
        }

        return $result;
    }

    /**
     * Get real-time statistics for a specific kategori
     * @param int $kategori_id
     * @return array
     */
    public function getStatistikKategoriRealTime($kategori_id)
    {
        $today = date('Y-m-d');
        
        // Get real-time statistics using separate queries for better performance
        $menunggu = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'menunggu')
            ->where('DATE(waktu_ambil)', $today)
            ->countAllResults();
            
        $dipanggil = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'dipanggil')
            ->where('DATE(waktu_ambil)', $today)
            ->countAllResults();
            
        $selesai = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'selesai')
            ->where('DATE(waktu_ambil)', $today)
            ->countAllResults();
            
        $lewati = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('status', 'lewati')
            ->where('DATE(waktu_ambil)', $today)
            ->countAllResults();

        return [
            'menunggu' => (int)$menunggu,
            'dipanggil' => (int)$dipanggil,
            'selesai' => (int)$selesai,
            'lewati' => (int)$lewati
        ];
    }

    /**
     * Get comprehensive daily statistics for admin dashboard
     * @param string|null $tanggal
     * @return array
     */
    public function getStatistikHarianLengkap($tanggal = null)
    {
        if ($tanggal === null) {
            $tanggal = date('Y-m-d');
        }

        // Get all categories first
        $kategori = $this->db->table('kategori_antrians')
            ->select('id, nama_kategori')
            ->where('status', 'aktif')
            ->get()
            ->getResultArray();

        $result = [];
        
        foreach ($kategori as $kat) {
            // Get statistics for each category
            $stats = $this->db->table($this->table . ' as antrians')
                ->select('
                    COUNT(*) as total_antrian,
                    AVG(TIMESTAMPDIFF(SECOND, antrians.waktu_ambil, antrians.waktu_selesai)) as rata_rata_waktu
                ')
                ->where('antrians.kategori_id', $kat['id'])
                ->where('DATE(antrians.waktu_ambil)', $tanggal)
                ->where('antrians.status', 'selesai')
                ->get()
                ->getRowArray();

            $result[] = [
                'kategori_id' => $kat['id'],
                'nama_kategori' => $kat['nama_kategori'],
                'total_antrian' => (int)($stats['total_antrian'] ?? 0),
                'rata_rata_waktu' => $stats['rata_rata_waktu'] ? (int)$stats['rata_rata_waktu'] : 0
            ];
        }

        return $result;
    }

    /**
     * Cleanup semua antrian (untuk dijalankan setiap hari jam 00:00)
     * @return bool
     */
    public function cleanupAntrian()
    {
        try {
            // Hapus semua antrian dari database
            $result = $this->db->table($this->table)->truncate();
            
            // Log cleanup activity
            log_message('info', 'Cleanup antrian berhasil dilakukan pada: ' . date('Y-m-d H:i:s'));
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Gagal melakukan cleanup antrian: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cleanup antrian berdasarkan tanggal (alternatif)
     * @param string $tanggal Format: Y-m-d
     * @return bool
     */
    public function cleanupAntrianByDate($tanggal)
    {
        try {
            // Hapus antrian berdasarkan tanggal
            $result = $this->db->table($this->table)
                ->where('DATE(waktu_ambil)', $tanggal)
                ->delete();
            
            // Log cleanup activity
            log_message('info', 'Cleanup antrian untuk tanggal ' . $tanggal . ' berhasil dilakukan pada: ' . date('Y-m-d H:i:s'));
            
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Gagal melakukan cleanup antrian untuk tanggal ' . $tanggal . ': ' . $e->getMessage());
            return false;
        }
    }
}
