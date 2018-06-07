<?php
class Model_jadwal extends CI_Model {
    public function cari_pemberangkatan($asal, $tujuan) {
        $asal = $this->db->escape_str($asal);
        $tujuan = $this->db->escape_str($tujuan);
        
        $sql = "SELECT 
                kereta.nama AS nama_kereta,
                s1.nama as nama_stasiun_asal,
                s2.nama as nama_stasiun_tujuan,
                jadwal.*
                FROM jadwal
                JOIN stasiun s1 ON s1.kode=jadwal.asal
                JOIN stasiun s2 ON s2.kode=jadwal.tujuan
                JOIN kereta ON kereta.kode=jadwal.kode_kereta
                WHERE
                s1.kode='" . $asal . "' AND s2.kode='" . $tujuan . "'";
                
        $query = $this->db->query($sql);
        if($query) {
            return $query->result();
        }
        return false;
    }

    /* Ambil Data */
    public function get($id) {
        $id = $this->db->escape_str($id);
        $sql = "SELECT 
                kereta.nama AS nama_kereta,
                s1.nama as nama_stasiun_asal,
                s2.nama as nama_stasiun_tujuan,
                jadwal.*
                FROM jadwal
                JOIN stasiun s1 ON s1.kode=jadwal.asal
                JOIN stasiun s2 ON s2.kode=jadwal.tujuan
                JOIN kereta ON kereta.kode=jadwal.kode_kereta
                WHERE
                jadwal.id='" . $id . "'";
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

        $sql = "INSERT INTO jadwal (kode_kereta, asal, tujuan, waktu_berangkat, waktu_tiba) 
        VALUES (
        '" . $data_escaped['kode_kereta'] . "', 
        '" . $data_escaped['asal'] . "', 
        '" . $data_escaped['tujuan'] . "', 
        '" . $data_escaped['waktu_berangkat'] . "', 
        '" . $data_escaped['waktu_tiba'] . "'
        )";
        
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE jadwal SET";

        if(isset($data_escaped['asal'])) {
            $sql .= " asal = '" . $data_escaped['asal'] . "',";
        }
        if(isset($data_escaped['tujuan'])) {
            $sql .= " tujuan = '" . $data_escaped['tujuan'] . "',";
        }
        if(isset($data_escaped['waktu_berangkat'])) {
            $sql .= " waktu_berangkat = '" . $data_escaped['waktu_berangkat'] . "',";
        }
        if(isset($data_escaped['waktu_tiba'])) {
            $sql .= " waktu_tiba = '" . $data_escaped['waktu_tiba'] . "',";
        }
        $sql = rtrim($sql, ',');
        $sql .= " WHERE id = '" . $data_escaped['id'] . "'";

        if($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    public function delete($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);

        $sql = "DELETE FROM jadwal WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }
    
    public function delete_by_id($id) {
        $id = $this->db->escape_str($id);

        $sql = "DELETE FROM jadwal WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    /* Datatables */
    public function datatables_all_count(){
        $sql = "SELECT COUNT(*) as jumlah FROM kereta";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    function datatables_all($limit, $offset, $col, $dir) {
        // escape data
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT kereta.*, COUNT(jadwal.id) as jumlah FROM kereta
                LEFT JOIN jadwal ON jadwal.kode_kereta=kereta.kode
                GROUP BY jadwal.kode_kereta
                ORDER BY " . $col . " " . $dir . " 
                LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }
   
    function datatables_search($limit, $offset, $search, $col, $dir) {
        // escape data
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $sql = "SELECT kereta.*, COUNT(jadwal.id) as jumlah FROM kereta
                LEFT JOIN jadwal ON jadwal.kode_kereta=kereta.kode
                WHERE kereta.nama LIKE '%" . $search ."%' OR kereta.kode LIKE '%" . $search . "%'
                GROUP BY jadwal.kode_kereta
                ORDER BY " . $col . " " . $dir . " 
                LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result();  
        } else {
            return null;
        }
    }

    function datatables_search_count($search) {
        // escape data
        $search = $this->db->escape_str($search);

        $sql = "SELECT COUNT(*) as jumlah FROM kereta WHERE kereta.nama LIKE '%" . $search ."%' OR kereta.kode LIKE '%" . $search . "%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    public function datatables_kelola_all_count($kode_kereta){
        $kode_kereta = $this->db->escape_str($kode_kereta);
        $sql = "SELECT COUNT(*) as jumlah FROM jadwal WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    function datatables_kelola_all($kode_kereta, $limit, $offset, $col, $dir) {
        // escape data
        $kode_kereta = $this->db->escape_str($kode_kereta);
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT 
                CONCAT(s1.nama, ' (', s1.kode, ')') as nama_stasiun_asal,
                CONCAT(s2.nama, ' (', s2.kode, ')') as nama_stasiun_tujuan,
                DATE_FORMAT(jadwal.waktu_berangkat, \"%H:%i\") as waktu_berangkat,
                DATE_FORMAT(jadwal.waktu_tiba, \"%H:%i\") as waktu_tiba,
                jadwal.id
                FROM jadwal
                JOIN stasiun s1 ON s1.kode=jadwal.asal
                JOIN stasiun s2 ON s2.kode=jadwal.tujuan
                JOIN kereta ON kereta.kode=jadwal.kode_kereta
                WHERE
                kereta.kode='" . $kode_kereta . "'
                ORDER BY " . $col . " " . $dir . " 
                LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }
   
    function datatables_kelola_search($kode_kereta, $limit, $offset, $search, $col, $dir) {
        // escape data
        $kode_kereta = $this->db->escape_str($kode_kereta);
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $sql = "SELECT 
                CONCAT(s1.nama, ' (', s1.kode, ')') as nama_stasiun_asal,
                CONCAT(s2.nama, ' (', s2.kode, ')') as nama_stasiun_tujuan,
                DATE_FORMAT(jadwal.waktu_berangkat, \"%H:%i\") as waktu_berangkat,
                DATE_FORMAT(jadwal.waktu_tiba, \"%H:%i\") as waktu_tiba,
                jadwal.id
                FROM jadwal
                JOIN stasiun s1 ON s1.kode=jadwal.asal
                JOIN stasiun s2 ON s2.kode=jadwal.tujuan
                JOIN kereta ON kereta.kode=jadwal.kode_kereta
                WHERE
                kereta.kode='" . $kode_kereta . "' AND 
                (
                nama_stasiun_asal LIKE '%" . $search ."%' OR 
                nama_stasiun_tujuan LIKE '%" . $search . "%'
                )
                ORDER BY " . $col . " " . $dir . " 
                LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result();  
        } else {
            return null;
        }
    }

    function datatables_kelola_search_count($kode_kereta, $search) {
        // escape data
        $search = $this->db->escape_str($search);

        $sql = "SELECT 
                COUNT(jadwal.id) as jumlah
                FROM jadwal
                JOIN stasiun s1 ON s1.kode=jadwal.asal
                JOIN stasiun s2 ON s2.kode=jadwal.tujuan
                JOIN kereta ON kereta.kode=jadwal.kode_kereta
                WHERE
                kereta.kode='" . $kode_kereta . "' AND 
                (
                nama_stasiun_asal LIKE '%" . $search ."%' OR 
                nama_stasiun_tujuan LIKE '%" . $search . "%'
                )";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    } 
}