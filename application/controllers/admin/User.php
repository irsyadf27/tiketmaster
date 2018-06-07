<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_user');
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola Pengguna'));
        $this->load->view('admin/layout/sidebar', array('active' => 'user'));
        $this->load->view('admin/user/list');
        $this->load->view('admin/layout/footer');
    }

    public function hapus($id) {
        $hapus = $this->model_user->delete($id);
        if($hapus) {
            $this->session->set_flashdata('sukses', 'Berhasil menghapus pengguna.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pengguna.');
        }
        redirect(site_url('admin/user'), 'refresh');
    }

    public function ubah($id) {
        $data['data'] = $this->model_user->get_id($id);

        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $username = $this->input->post('username');
        $jenis = $this->input->post('jenis');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        /* Validasi Input */
        $this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim|callback_validasi_no_hp|min_length[8]|max_length[15]');

        if($email != $data['data']->email) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|min_length[5]|max_length[50]|callback_validasi_email');
        }

        if($username != $data['data']->username) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric|min_length[5]|max_length[25]|callback_validasi_username');
        }

        if($password != '') {
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('cpassword', 'Konfirmasi Password', 'required|trim|min_length[6]|matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Tambah Pengguna'));
            $this->load->view('admin/layout/sidebar', array('active' => 'user'));
            $this->load->view('admin/user/ubah', $data);
            $this->load->view('admin/layout/footer');
        } else {
            $data_update = array(
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'email' => $email,
                'no_hp' => $no_hp,
                'username' => $username,
                'jenis' => $jenis
            );

            if($password != '') {
                $data_update['password'] = enkripsi_password($password);
            }
            $daftar = $this->model_user->update($data_update, $id);
            if($daftar > 0) {
                $this->session->set_flashdata('sukses', 'Berhasil mengubah pengguna.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah pengguna.');
            }
            redirect(site_url('admin/user'), 'refresh');
        }
    }

    public function tambah() {
        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $username = $this->input->post('username');
        $jenis = $this->input->post('jenis');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        /* Validasi Input */
        $this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|min_length[5]|max_length[25]|callback_validasi_email');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim|callback_validasi_no_hp|min_length[8]|max_length[15]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric|min_length[5]|max_length[25]|callback_validasi_username');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('cpassword', 'Konfirmasi Password', 'required|trim|min_length[6]|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Tambah Pengguna'));
            $this->load->view('admin/layout/sidebar', array('active' => 'user'));
            $this->load->view('admin/user/tambah');
            $this->load->view('admin/layout/footer');
        } else {
            $data = array(
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'email' => $email,
                'no_hp' => $no_hp,
                'username' => $username,
                'password' => enkripsi_password($password),
                'jenis' => $jenis
            );

            $daftar = $this->model_user->insert($data);
            if($daftar > 0) {
                $this->session->set_flashdata('sukses', 'Berhasil menambah pengguna.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah pengguna.');
            }
            redirect(site_url('admin/user'), 'refresh');
        }
    }

    public function user() {
        $columns = array( 
            0 =>'nama_depan', 
            1 =>'nama_belakang',
            2 =>'email',
            3 =>'no_hp',
            4 =>'jenis'
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_user->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $user = $this->model_user->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $user =  $this->model_user->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_user->datatables_search_count($search);
        }

        $data = array();
        if(!empty($user)) {
            foreach ($user as $st) {
                $dt['nama_depan'] = $st->nama_depan;
                $dt['nama_belakang'] = $st->nama_belakang;
                $dt['email'] = $st->email;
                $dt['no_hp'] = $st->no_hp;
                $dt['jenis'] = $st->jenis;
                $dt['aksi'] = '
                <a href="' . site_url('admin/user/ubah/' . $st->id) . '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i> Ubah</a> 
                <button type="button" class="btn btn-sm btn-danger" onclick="javascript: hapus_user(\'' . $st->id . '\');"><i class="fa fa-trash"></i> Hapus</button>';

                $data[] = $dt;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($total_data),  
            "recordsFiltered" => intval($total_filter), 
            "data"            => $data   
        );

        echo json_encode($json_data); 
    }

    /* Validasi */
    function validasi_email($email) {
        $cek = $this->model_user->get_email($email);
        if($cek) {
            $this->form_validation->set_message('validasi_email', 'Email sudah digunakan!');
            return false;
        } else {
            return true;
        }
    }

    function validasi_username($username) {
        $cek = $this->model_user->get_username($username);
        if($cek) {
            $this->form_validation->set_message('validasi_username', 'Username sudah digunakan!');
            return false;
        } else {
            return true;
        }
    }

    function validasi_nama($nama) {
        if (! preg_match('/^[a-zA-Z\s]+$/', $nama)) {
            $this->form_validation->set_message('validasi_nama', '%s hanya boleh berisi abjad dan spasi.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function validasi_no_hp($no_hp) {
        if(!preg_match('/^\+?\d+$/', $no_hp)) {
            $this->form_validation->set_message('validasi_no_hp', 'No. HP tidak valid.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}