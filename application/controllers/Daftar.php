<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_user');
    }

    public function index() {
        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');
        $email = $this->input->post('email');
        $nohp = $this->input->post('nohp');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');

        /* Validasi Input */
        $this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|min_length[5]|max_length[50]|callback_validasi_email');
        $this->form_validation->set_rules('nohp', 'No. HP', 'required|trim|callback_validasi_no_hp|min_length[8]|max_length[15]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric|min_length[5]|max_length[25]|callback_validasi_username');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('cpassword', 'Konfirmasi Password', 'required|trim|min_length[6]|matches[password]');
            
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', array('title' => 'Pendaftaran Akun'));
            $this->load->view('daftar');
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'email' => $email,
                'no_hp' => $nohp,
                'username' => $username,
                'password' => enkripsi_password($password),
                'jenis' => 'user'
            );

            $daftar = $this->model_user->insert($data);
            if($daftar > 0) {
                $this->session->set_flashdata('sukses', 'Berhasil mendaftar sebagai user. Klik <a href="' . site_url('auth/login') . '">disini</a> untuk login.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mendaftar sebagai user.');
            }
            redirect(site_url('daftar'), 'refresh');
        }


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
