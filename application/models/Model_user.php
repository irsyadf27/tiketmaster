<?php
class Model_user extends CI_Model {

    public function delete($id) {
        $id = $this->db->escape_str($id);
        $sql = "DELETE FROM user WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if($query) {
            return true;
        }
        return false;
    }

    public function insert($data) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "INSERT INTO user (nama_depan, nama_belakang, username, email, no_hp, password, jenis) VALUES 
        ('" . $data_escaped['nama_depan'] . "', '" . $data_escaped['nama_belakang'] . "', '" . $data_escaped['username'] . "', '" . $data_escaped['email'] . "', '" . $data_escaped['no_hp'] . "', '" . $data_escaped['password'] . "', '" . $data_escaped['jenis'] . "')";

        $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update($data, $id) {
        // escape data
        foreach($data as $key => $val) {
            $data_escaped[$key] = $this->db->escape_str($data[$key]);
        }

        $sql = "UPDATE user SET 
            nama_depan = '" . $data_escaped['nama_depan'] . "', 
            nama_belakang = '" . $data_escaped['nama_belakang'] . "', 
            email = '" . $data_escaped['email'] . "', 
            no_hp = '" . $data_escaped['no_hp'] . "'";

        if(isset($data_escaped['username'])) {
            $sql .= ", username = '" . $data_escaped['username'] . "'";
        }
        if(isset($data_escaped['password'])) {
            $sql .= ", password = '" . $data_escaped['password'] . "'";
        }
        if(isset($data_escaped['jenis'])) {
            $sql .= ", jenis = '" . $data_escaped['jenis'] . "'";
        }
        
        $sql .= " WHERE user.id = '" . $id ."'";
        return $this->db->query($sql);
    }

    // ambil nama berdasarkan id
    public function get_username_login($id) {
        $sql = "SELECT username FROM user WHERE id='" . $id ."'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->username;
        }
        return false;
    }

    public function get_login($login) {
        $login = $this->db->escape_str($login);

        $sql = "SELECT * FROM user WHERE username='" . $login ."' OR email='" . $login . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function get_email($email) {
        $email = $this->db->escape_str($email);
        $sql = "SELECT * FROM user WHERE email='" . $email . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function get_username($username) {
        $username = $this->db->escape_str($username);
        $sql = "SELECT * FROM user WHERE username='" . $username . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }

    public function get_id($id) {
        $id = $this->db->escape_str($id);
        $sql = "SELECT * FROM user WHERE id='" . $id . "'";
        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0];
        }
        return false;
    }


    /* Datatables */
    public function datatables_all_count(){
        $sql = "SELECT COUNT(id) as jumlah FROM user";
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

        $sql = "SELECT * FROM user ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit ;

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

        $sql = "SELECT * FROM user 
            WHERE 
            nama_depan LIKE '%" . $search ."%' OR 
            nama_belakang LIKE '%" . $search ."%' OR 
            username LIKE '%" . $search ."%' OR 
            email LIKE '%" . $search ."%' ORDER BY " . $col . " " . $dir . " LIMIT " . $offset . ", " . $limit;

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

        $sql = "SELECT COUNT(*) as jumlah FROM user WHERE nama_depan LIKE '%" . $search ."%' OR 
            nama_belakang LIKE '%" . $search ."%' OR 
            username LIKE '%" . $search ."%' OR 
            email LIKE '%" . $search ."%'";

        $query = $this->db->query($sql)->result();
        if($query) {
            return $query[0]->jumlah;
        }
        return false;
    }
}