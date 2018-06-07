<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_user');
        $this->load->library('user_agent');
        //die(enkripsi_password('123456'));
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        /* Validasi Input */
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', array('title' => 'Login'));
            $this->load->view('login');
            $this->load->view('layout/footer');
        } else {
            $result = $this->model_user->get_login($username);
            if($result) {
                if(password_verify($password, $result->password)) {

                    $session_data = array(
                        'id_user' => $result->id,
                        'jenis' => $result->jenis,
                        'login' => true
                    );

                    $this->session->set_userdata($session_data);
                    if($this->agent->referrer() && !strpos($this->agent->referrer(), 'auth/login')) {
                        redirect($this->agent->referrer());
                    } else {
                        redirect(site_url('user/dashboard'));
                    }
                } else {
                    $this->session->set_flashdata('error', 'Username/Email atau Password salah.');
                    redirect('auth/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Username/Email tidak ditemukan.');
                redirect(site_url('auth/login'), 'refresh');
            }
        }
    }

    public function logout() {
        $session = array('id_user', 'jenis', 'login');
        $this->session->unset_userdata($session);
        $this->session->set_flashdata('sukses','Anda berhasil logout!');
        redirect(site_url('auth/login'));
    }
}
