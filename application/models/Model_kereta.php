<?php
class Model_kereta extends CI_Model {

    public function get($kode) {
        $kode = $this->db->escape_str($kode);
        $sql = "SELECT * FROM kereta WHERE kode='" . $kode . "'";
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

        $sql = "INSERT INTO kereta (kode, nama) VALUES ('" . $data_escaped['kode'] . "', '" . $data_escaped['nama'] . "')";
        if($this->db->query($sql)) {
            return $data_escaped['kode'];
        }
        return false;
    }

    public function update($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE kereta SET nama='" . $data_escaped['nama'] . "' WHERE kode='" . $data_escaped['kode'] . "'";
        if($this->db->query($sql)) {
            return $data_escaped['kode'];
        }
        return false;
    }

    public function delete($kode) {
        $kode = $this->db->escape_str($kode);
        $sql = "DELETE FROM kereta WHERE kode='" . $kode . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function datatables_all_count(){
        $sql = "SELECT COUNT(kode) as jumlah FROM kereta";
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
        $sql = "SELECT kereta.kode, kereta.nama, GROUP_CONCAT(kelas.kelas) as kelas FROM `kereta`
        LEFT JOIN kelas ON kelas.kode_kereta = kereta.kode
        GROUP BY kereta.kode
        ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit;

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

        $sql = "SELECT kereta.kode, kereta.nama, GROUP_CONCAT(kelas.kelas) as kelas FROM `kereta`
        LEFT JOIN kelas ON kelas.kode_kereta = kereta.kode
        GROUP BY kereta.kode
        HAVING kode LIKE '%" . $search ."%' OR nama LIKE '%" . $search . "%'
        ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit;

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

        $sql = "SELECT COUNT(*) as jumlah FROM kereta WHERE kode LIKE '%" . $search ."%' OR nama LIKE '%" . $search . "%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    } 
}