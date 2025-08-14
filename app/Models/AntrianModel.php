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

    public function getAntrianAktif($kategori_id = null)
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

        $lastAntrian = $this->db->table($this->table)
            ->where('kategori_id', $kategori_id)
            ->where('DATE(waktu_ambil)', $today)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();

        $nextNumber = 1;
        if ($lastAntrian) {
            $lastNumber = (int)substr($lastAntrian['nomor_antrian'], strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        // Format: prefix + 3-digit number (e.g., T001, C001, P001)
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getAntrianDipanggil($loket_id = null)
    {
        $builder = $this->db->table($this->table . ' as antrians')
            ->select('antrians.*, kategori_antrians.nama_kategori, kategori_antrians.prefix, lokets.nama_loket, users.nama_lengkap as nama_petugas')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->join('lokets', 'lokets.id = antrians.loket_id', 'left')
            ->join('users', 'users.id = antrians.petugas_id', 'left')
            ->where('antrians.status', 'dipanggil')
            ->orderBy('antrians.id', 'DESC');

        if ($loket_id !== null) {
            $builder->where('antrians.loket_id', $loket_id);
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
            ->select('antrians.kategori_id, kategori_antrians.nama_kategori, COUNT(*) as total_antrian, AVG(TIMESTAMPDIFF(SECOND, antrians.waktu_ambil, antrians.waktu_selesai)) as rata_waktu_layanan')
            ->join('kategori_antrians', 'kategori_antrians.id = antrians.kategori_id')
            ->where('DATE(antrians.waktu_ambil)', $tanggal)
            ->where('antrians.status', 'selesai')
            ->groupBy('antrians.kategori_id, kategori_antrians.nama_kategori')
            ->orderBy('antrians.kategori_id', 'ASC');

        return $builder->get()->getResultArray();
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
}
