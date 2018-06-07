<?php
class Model_kelas extends CI_Model {

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO kelas (kode_kereta, kelas) VALUES ('" . $data_escaped['kode_kereta'] . "', '" . $data_escaped['kelas'] . "')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function delete($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);

        $sql = "DELETE FROM kelas WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function get($kode_kereta) {
        $kode_kereta = $this->db->escape_str($kode_kereta);

        $sql = "SELECT * FROM kelas WHERE kode_kereta='" . $kode_kereta . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query;
        }
        return false;;
    }
}