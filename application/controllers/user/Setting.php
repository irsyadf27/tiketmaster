<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_user');
        $this->load->library('user_agent');

        if(!$this->session->userdata('login')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect(site_url('auth/login'));
        }
    }

    public function index() {
        $data['user'] = $this->model_user->get_id($this->session->userdata('id_user'));

        $nama_depan = $this->input->post('nama_depan');
        $nama_belakang = $this->input->post('nama_belakang');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $pass_lama = $this->input->post('pass_lama');
        $password = $this->input->post('pass_baru');
        $cpassword = $this->input->post('konf_pass_baru');

        /* Validasi Input */
        $this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required|trim|callback_validasi_nama|min_length[3]|max_length[30]');

        if($data['user']->email != $email) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|min_length[5]|max_length[50]|callback_validasi_email');
        }
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim|callback_validasi_no_hp|min_length[8]|max_length[15]');

        if($pass_lama != '' || $password != '' || $cpassword != '') {
            $this->form_validation->set_rules('pass_lama', 'Password Lama', 'required|trim|min_length[6]|callback_validasi_pass_lama');
            $this->form_validation->set_rules('pass_baru', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('konf_pass_baru', 'Konfirmasi Password', 'required|trim|min_length[6]|matches[pass_baru]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', array('title' => 'Pengaturan Akun'));
            $this->load->view('layout/sidebar', array('active' => 'pengaturan-akun'));
            $this->load->view('user/setting', $data);
            $this->load->view('layout/footer2');
        } else {
            $data_update = array(
                'nama_depan' => $nama_depan,
                'nama_belakang' => $nama_belakang,
                'email' => $email,
                'no_hp' => $no_hp
            );

            if($password != '') {
                $data_update['password'] = enkripsi_password($password);
            }

            if($this->model_user->update($data_update, $this->session->userdata('id_user'))) {
                $this->session->set_flashdata('sukses', 'Berhasil memperbaharui pengaturan akun.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbaharui pengaturan akun.');
            }
            redirect(site_url('user/setting'), 'refresh');
        }
    }

    /* Validasi */
    public function validasi_pass_lama($pass) {
        $get_pass = $this->model_user->get_id($this->session->userdata('id'));
        if(!password_verify($pass, $get_pass->password)) {
            $this->form_validation->set_message('validasi_pass_lama', 'Password lama salah!');
            return false;
        }
        return true;
    }

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