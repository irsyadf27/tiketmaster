<?php
class Model_slideshow extends CI_Model {

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO slideshow (judul, deskripsi, gambar, tampil) VALUES (
        '" . $data_escaped['judul'] . "', 
        '" . $data_escaped['deskripsi'] . "', 
        '" . $data_escaped['gambar'] . "', 
        '" . $data_escaped['tampil'] . "'
        )";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE slideshow SET 
            judul = '" . $data_escaped['judul'] . "', 
            deskripsi = '" . $data_escaped['deskripsi'] . "', 
            tampil = '" . $data_escaped['tampil'] . "'";

        if(isset($data_escaped['gambar'])) {
            $sql .= ", gambar = '" . $data_escaped['gambar'] . "'";
        }
        
        $sql .= " WHERE id = '" . $id ."'";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id = $this->db->escape_str($id);

        $sql = "DELETE FROM slideshow WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function get($id) {
        $id = $this->db->escape_str($id);

        $sql = "SELECT * FROM slideshow WHERE id='" . $id . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;;
    }

    public function tampil() {

        $sql = "SELECT * FROM slideshow WHERE tampil='Y'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query;
        }
        return array();
    }

    /* Datatables */
    public function datatables_all_count(){
        $sql = "SELECT COUNT(id) as jumlah FROM slideshow";
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

        $sql = "SELECT * FROM slideshow ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit ;

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

        $sql = "SELECT * FROM slideshow 
            WHERE judul LIKE '%" . $search ."%' OR 
            deskripsi LIKE '%" . $search ."%' ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit;

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

        $sql = "SELECT COUNT(*) as jumlah FROM slideshow WHERE judul LIKE '%" . $search ."%' OR 
            deskripsi LIKE '%" . $search ."%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }
}