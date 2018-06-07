<?php
class Model_laporan extends CI_Model {
    /*public function stasiun_pemberangkatan($tahun) {
        $tahun = $this->db->escape_str($tahun);

        $sql = "SELECT CONCAT(stasiun.nama, ' (', stasiun.kode, ')') as pemberangkatan, COUNT(jadwal.asal) as jumlah FROM `pemesanan`
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun ON stasiun.kode=jadwal.asal
            WHERE YEAR(pemesanan.tanggal)='2018'
            GROUP BY jadwal.asal
            ORDER BY jumlah DESC
            LIMIT 10";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    public function stasiun_tujuan($tahun) {
        $tahun = $this->db->escape_str($tahun);

        $sql = "SELECT CONCAT(stasiun.nama, ' (', stasiun.kode, ')') as pemberangkatan, COUNT(jadwal.asal) as jumlah FROM `pemesanan`
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun ON stasiun.kode=jadwal.tujuan
            WHERE YEAR(pemesanan.tanggal)='2018'
            GROUP BY jadwal.tujuan
            ORDER BY jumlah DESC
            LIMIT 10";
        $result = $this->db->query($sql)->result();

        return $result;
    }*/

    public function pemesanan_per_bulan($tahun) {
        $tahun = $this->db->escape_str($tahun);

        $sql = "SELECT MONTH(tanggal) as bulan, COUNT(pemesanan.id) as jumlah FROM `pemesanan`
            WHERE YEAR(tanggal)='" . $tahun . "'
            GROUP BY MONTH(tanggal)";
        $result = $this->db->query($sql)->result();
        
        // buat bulan
        $data = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        foreach($result as $res) {
            $data[$res->bulan - 1] = (int) $res->jumlah;
        }

        return $data;
    }

    public function penumpang_per_bulan($tahun) {
        $tahun = $this->db->escape_str($tahun);

        $sql = "SELECT MONTH(tanggal) as bulan, COUNT(penumpang.id_pemesanan) as jumlah FROM `pemesanan` 
                JOIN penumpang ON penumpang.id_pemesanan=pemesanan.id 
                WHERE YEAR(tanggal)='" . $tahun . "'
                GROUP BY MONTH(tanggal)";
        $result = $this->db->query($sql)->result();
        
        // buat bulan
        $data = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        foreach($result as $res) {
            $data[$res->bulan - 1] = (int) $res->jumlah;
        }

        return $data;
    }
}