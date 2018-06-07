<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('login')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect(site_url('auth/login'));
        }
    }

    public function index() {
        $this->load->view('layout/header', array('title' => 'Dashboard User'));
        $this->load->view('layout/sidebar', array('active' => 'dashboard'));
        $this->load->view('user/dashboard');
        $this->load->view('layout/footer2');
    }
}