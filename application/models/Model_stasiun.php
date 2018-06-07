<?php
class Model_stasiun extends CI_Model {

    public function cari($nama) {
        $nama = $this->db->escape_str($nama);
        $sql = "SELECT kode as id, CONCAT(nama, ' (', kode, ')') as `text` FROM stasiun WHERE nama LIKE '%" . $nama . "%' OR kode LIKE '%" . $nama . "%' LIMIT 15";
        return $this->db->query($sql)->result();
    }

    public function get($kode) {
        $kode = $this->db->escape_str($kode);
        $sql = "SELECT * FROM stasiun WHERE kode='" . $kode . "'";
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

        $sql = "INSERT INTO stasiun (kode, nama) VALUES ('" . $data_escaped['kode'] . "', '" . $data_escaped['nama'] . "')";
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

        $sql = "UPDATE stasiun SET nama='" . $data_escaped['nama'] . "' WHERE kode='" . $data_escaped['kode'] . "'";
        if($this->db->query($sql)) {
            return $data_escaped['kode'];
        }
        return false;
    }

    public function delete($kode) {
        $kode = $this->db->escape_str($kode);
        $sql = "DELETE FROM stasiun WHERE kode='" . $kode . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function datatables_all_count(){
        $sql = "SELECT COUNT(kode) as jumlah FROM stasiun";
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

        $sql = "SELECT * FROM stasiun ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit ;

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

        $sql = "SELECT * FROM stasiun WHERE kode LIKE '%" . $search ."%' OR nama LIKE '%" . $search . "%' ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit;

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

        $sql = "SELECT COUNT(*) as jumlah FROM stasiun WHERE kode LIKE '%" . $search ."%' OR nama LIKE '%" . $search . "%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    } 
}