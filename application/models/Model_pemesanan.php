<?php
class Model_pemesanan extends CI_Model {
    public function get($id) {
        $id = $this->db->escape_str($id);

        $sql = "SELECT * FROM pemesanan WHERE id='" . $id . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO pemesanan (id_user, tanggal, id_jadwal, kode_booking) 
        VALUES (
        '" . $data_escaped['id_user'] . "', 
        '" . $data_escaped['tanggal'] . "', 
        '" . $data_escaped['id_jadwal'] . "',
        '" . $data_escaped['kode_booking'] . "'
        )";

        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function get_kode_booking($kode_booking) {
        $kode_booking = $this->db->escape_str($kode_booking);

        $sql = "SELECT * FROM pemesanan WHERE BINARY kode_booking='" . $kode_booking . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function generate_kode_booking() {
        $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $kode_booking = '';
        do {
            $kode_booking = substr(str_shuffle($karakter), 0, 7);
            $sql = "SELECT * FROM pemesanan WHERE kode_booking='" . $kode_booking . "'";

        } while ($this->db->query($sql)->num_rows() > 0);
        return $kode_booking;
    }

    public function detail_kereta($id_pemesanan) {
        $id_pemesanan = $this->db->escape_str($id_pemesanan);

        $sql = "SELECT pemesanan.*,
        kereta.kode as kode_kereta,
        kereta.nama as nama_kereta,
        CONCAT(s1.nama, ' (', s1.kode, ')') as stasiun_pemberangkatan,
        CONCAT(s2.nama, ' (', s2.kode, ')') as stasiun_tujuan,
        jadwal.waktu_berangkat,
        jadwal.waktu_tiba,
        CONCAT(kereta.nama, ' (', kereta.kode, ')') as kereta
        FROM pemesanan
        JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
        JOIN kereta ON kereta.kode=jadwal.kode_kereta
        JOIN stasiun s1 ON s1.kode=jadwal.asal
        JOIN stasiun s2 ON s2.kode=jadwal.tujuan
        WHERE pemesanan.id='" . $id_pemesanan . "'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function get_all_by_user($id_user, $offset, $limit) {
        $id_user = $this->db->escape_str($id_user);
        $offset = $this->db->escape_str($offset);
        $limit = $this->db->escape_str($limit);

        $sql = "SELECT CONCAT(s1.nama, ' (', s1.kode, ')') as nama_stasiun_asal,
            CONCAT(s2.nama, ' (', s2.kode, ')') as nama_stasiun_tujuan,
            jadwal.waktu_berangkat, jadwal.waktu_tiba, pemesanan.*, COUNT(penumpang.id_pemesanan) as jumlah,
            CONCAT(kereta.nama, ' (', kereta.kode, ')') as kereta
            FROM pemesanan
            JOIN penumpang ON penumpang.id_pemesanan=pemesanan.id
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            WHERE pemesanan.id_user='" . $id_user . "'
            GROUP BY penumpang.id_pemesanan
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }

    public function count_all_by_user($id_user) {
        $id_user = $this->db->escape_str($id_user);

        $sql = "SELECT COUNT(id) as jumlah 
            FROM pemesanan
            WHERE pemesanan.id_user='" . $id_user . "'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    public function get_all_by_user_search($id_user, $offset, $limit, $keyword) {
        $id_user = $this->db->escape_str($id_user);
        $offset = $this->db->escape_str($offset);
        $limit = $this->db->escape_str($limit);

        $sql = "SELECT CONCAT(s1.nama, ' (', s1.kode, ')') as nama_stasiun_asal,
            CONCAT(s2.nama, ' (', s2.kode, ')') as nama_stasiun_tujuan,
            jadwal.waktu_berangkat, jadwal.waktu_tiba, pemesanan.*, COUNT(penumpang.id_pemesanan) as jumlah,
            CONCAT(kereta.nama, ' (', kereta.kode, ')') as kereta
            FROM pemesanan
            JOIN penumpang ON penumpang.id_pemesanan=pemesanan.id
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            WHERE pemesanan.id_user='" . $id_user . "'
            AND (s1.nama LIKE '%" . $keyword . "%' OR s2.nama LIKE '%" . $keyword . "%' OR kereta.nama LIKE '%" . $keyword . "%')
            GROUP BY penumpang.id_pemesanan
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }

    public function count_all_by_user_search($id_user, $keyword) {
        $id_user = $this->db->escape_str($id_user);
        $keyword = $this->db->escape_str($keyword);

        $sql = "SELECT CONCAT(pemesanan.id) as jumlah
            FROM pemesanan
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            WHERE pemesanan.id_user='" . $id_user . "'
            AND (s1.nama LIKE '%" . $keyword . "%' OR s2.nama LIKE '%" . $keyword . "%' OR kereta.nama LIKE '%" . $keyword . "%')";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    public function datatables_all($limit, $offset, $col, $dir) {
        // escape data
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT CONCAT(user.nama_depan, ' ', user.nama_belakang) as nama_pemesan,
            s1.nama as nama_stasiun_asal,
            s2.nama as nama_stasiun_tujuan,
            jadwal.waktu_berangkat, jadwal.waktu_tiba, pemesanan.*, COUNT(penumpang.id_pemesanan) as jumlah,
            CONCAT(kereta.nama, ' (', kereta.kode, ')') as kereta
            FROM pemesanan
            JOIN user ON user.id=pemesanan.id_user
            JOIN penumpang ON penumpang.id_pemesanan=pemesanan.id
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            GROUP BY penumpang.id_pemesanan
            ORDER BY " . $col . " " . $dir . "
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }

    public function datatables_all_count() {
        $sql = "SELECT COUNT(id) as jumlah FROM pemesanan";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    public function datatables_search($limit, $offset, $search, $col, $dir) {
        // escape data
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT CONCAT(user.nama_depan, ' ', user.nama_belakang) as nama_pemesan,
            s1.nama as nama_stasiun_asal,
            s2.nama as nama_stasiun_tujuan,
            jadwal.waktu_berangkat, jadwal.waktu_tiba, pemesanan.*, COUNT(penumpang.id_pemesanan) as jumlah,
            CONCAT(kereta.nama, ' (', kereta.kode, ')') as kereta
            FROM pemesanan
            JOIN user ON user.id=pemesanan.id_user
            JOIN penumpang ON penumpang.id_pemesanan=pemesanan.id
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            WHERE 
            user.nama_depan LIKE '%" . $search . "%' OR 
            user.nama_belakang LIKE '%" . $search . "%' OR 
            s1.nama LIKE '%" . $search . "%' OR 
            s2.nama LIKE '%" . $search . "%' OR 
            kereta.nama LIKE '%" . $search . "%'
            GROUP BY penumpang.id_pemesanan
            ORDER BY " . $col . " " . $dir . "
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }

    public function datatables_search_count($keyword) {
        $keyword = $this->db->escape_str($keyword);

        $sql = "SELECT CONCAT(pemesanan.id) as jumlah
            FROM pemesanan
            JOIN jadwal ON jadwal.id=pemesanan.id_jadwal
            JOIN stasiun s1 ON s1.kode=jadwal.asal
            JOIN stasiun s2 ON s2.kode=jadwal.tujuan
            JOIN kereta ON kereta.kode=jadwal.kode_kereta
            WHERE 
            s1.nama LIKE '%" . $keyword . "%' OR 
            s2.nama LIKE '%" . $keyword . "%' OR 
            kereta.nama LIKE '%" . $keyword . "%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }
}