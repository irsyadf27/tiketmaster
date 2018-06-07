<?php
class Model_gerbong extends CI_Model {

    public function kereta($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);

        $sql = "SELECT * FROM gerbong WHERE kode_kereta='" . $kode_kereta . "'";
        return $this->db->query($sql)->result();
    }

    public function get($id) {
        $id = $this->db->escape_str($id);
        $sql = "SELECT * FROM gerbong WHERE id='" . $id . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function delete($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);

        $sql = "DELETE FROM gerbong WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }
    
    public function delete_by_id($id) {
        $id = $this->db->escape_str($id);

        $sql = "DELETE FROM gerbong WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function get_by_kereta($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);
        $sql = "SELECT * FROM gerbong WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query;
        }
        return false;
    }

    public function get_kursi($id_gerbong, $tanggal) {
        $id_gerbong = $this->db->escape_str($id_gerbong);
        $tanggal = $this->db->escape_str($tanggal);

        $sql = "SELECT CONCAT(row, '_', seat) AS kursi FROM penumpang
        JOIN pemesanan ON pemesanan.id=penumpang.id_pemesanan
        WHERE penumpang.id_gerbong='" . $id_gerbong . "' AND pemesanan.tanggal='" . $tanggal ."'";

        return $this->db->query($sql)->result_array();
    }

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO gerbong (kode_kereta, nama, kelas, no_gerbong) VALUES 
        (
        '" . $data_escaped['kode_kereta'] . "', 
        '" . $data_escaped['nama'] . "', 
        '" . $data_escaped['kelas'] . "', 
        '" . $data_escaped['no_gerbong'] . "'
        )";
        
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE gerbong SET";

        if(isset($data_escaped['nama'])) {
            $sql .= " nama = '" . $data_escaped['nama'] . "',";
        }
        if(isset($data_escaped['kelas'])) {
            $sql .= " kelas = '" . $data_escaped['kelas'] . "',";
        }
        if(isset($data_escaped['no_gerbong'])) {
            $sql .= " no_gerbong = '" . $data_escaped['no_gerbong'] . "',";
        }
        $sql = rtrim($sql, ',');
        $sql .= " WHERE id = '" . $data_escaped['id'] . "'";

        if($this->db->query($sql)) {
            return true;
        }
        return false;
    }
}