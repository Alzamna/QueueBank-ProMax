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
    protected $allowedFields = ['nomor_antrian', 'kategori_id', 'loket_id', 'petugas_id', 'status', 'waktu_ambil', 'waktu_panggil', 'waktu_selesai'];

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
        $kategori = $this->db->table('kategori_antrians')->where('id', $kategori_id)->get()->getRowArray();
        if (!$kategori) {
            return null;
        }

        $prefix = $kategori['prefix'];
        $today = date('Y-m-d');

        $lastAntrian = $this->db->table($this->table . ' as antrians')
            ->where('antrians.kategori_id', $kategori_id)
            ->where('DATE(antrians.waktu_ambil)', $today)
            ->orderBy('antrians.id', 'DESC')
            ->get()
            ->getRowArray();

        $nextNumber = 1;
        if ($lastAntrian) {
            $lastNumber = (int)substr($lastAntrian['nomor_antrian'], strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

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
}
