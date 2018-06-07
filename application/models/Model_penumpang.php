<?php
class Model_penumpang extends CI_Model {
    public function get($id_pemesanan) {
        $id_pemesanan = $this->db->escape_str($id_pemesanan);
        $sql = "SELECT penumpang.*, gerbong.nama as nama_gerbong, CONCAT(seat, row) as kursi
            FROM penumpang
            JOIN gerbong ON gerbong.id=penumpang.id_gerbong
            WHERE 
            id_pemesanan='" . $id_pemesanan . "'";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }
    }

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO penumpang (id_pemesanan, nama_lengkap, no_identitas, id_gerbong, `row`, seat) 
        VALUES 
        ('" . $data_escaped['id_pemesanan'] ."', 
        '" . $data_escaped['nama_lengkap'] ."', 
        '" . $data_escaped['no_identitas'] ."', 
        '" . $data_escaped['id_gerbong'] ."', 
        '" . $data_escaped['row'] ."', 
        '" . $data_escaped['seat'] ."')";

        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE penumpang SET ";
        if(isset($data_escaped['nama_lengkap'])) {
            $sql .= " nama_lengkap='" . $data_escaped['nama_lengkap'] . "',";
        }
        if(isset($data_escaped['no_identitas'])) {
            $sql .= " no_identitas='" . $data_escaped['no_identitas'] . "',";
        }
        if(isset($data_escaped['id_gerbong'])) {
            $sql .= " id_gerbong='" . $data_escaped['id_gerbong'] . "',";
        }
        if(isset($data_escaped['row'])) {
            $sql .= " `row`='" . $data_escaped['row'] . "',";
        }
        if(isset($data_escaped['seat'])) {
            $sql .= " seat='" . $data_escaped['seat'] . "',";
        }
        $sql = rtrim($sql, ',');
        $sql .= " WHERE id='" . $data_escaped['id'] . "'";

        if($this->db->query($sql)) {
            return true;
        }
        return false;
    }
    public function datatables_all($id_pemesanan, $limit, $offset, $col, $dir) {
        // escape data
        $id_pemesanan = $this->db->escape_str($id_pemesanan);
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT penumpang.*, gerbong.nama as nama_gerbong, CONCAT(seat, row) as kursi
            FROM penumpang
            JOIN gerbong ON gerbong.id=penumpang.id_gerbong
            WHERE 
            id_pemesanan='" . $id_pemesanan . "'
            ORDER BY " . $col . " " . $dir . "
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }
    }

    public function datatables_all_count($id_pemesanan) {
        $id_pemesanan = $this->db->escape_str($id_pemesanan);

        $sql = "SELECT COUNT(id) as jumlah FROM penumpang WHERE id_pemesanan='" . $id_pemesanan . "'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }

    public function datatables_search($id_pemesanan, $limit, $offset, $search, $col, $dir) {
        // escape data
        $id_pemesanan = $this->db->escape_str($id_pemesanan);
        $limit = $this->db->escape_str($limit);
        $offset = $this->db->escape_str($offset);
        $col = $this->db->escape_str($col);
        $dir = $this->db->escape_str($dir);

        $sql = "SELECT penumpang.*, gerbong.nama as nama_gerbong, CONCAT(seat, row) as kursi
            FROM penumpang
            JOIN gerbong ON gerbong.id=penumpang.id_gerbong
            WHERE 
            id_pemesanan='" . $id_pemesanan . "'
            AND (nama_lengkap LIKE '%" . $search . "%' OR 
            no_identitas LIKE '%" . $search . "%')
            ORDER BY " . $col . " " . $dir . "
            LIMIT " . $offset . ", " . $limit;

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){
            return $query->result(); 
        } else {
            return null;
        }   
    }

    public function datatables_search_count($id_pemesanan, $search) {
        $id_pemesanan = $this->db->escape_str($id_pemesanan);
        $search = $this->db->escape_str($search);

        $sql = "SELECT COUNT(id) as jumlah
            FROM penumpang
            WHERE 
            id_pemesanan='" . $id_pemesanan . "'
            AND (nama_lengkap LIKE '%" . $search . "%' OR 
            no_identitas LIKE '%" . $search . "%')";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }
}