<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
    }

    public function index() {
            $this->load->view('admin/layout/header', array('title' => 'Dashboard Admin'));
            $this->load->view('admin/layout/sidebar', array('active' => 'dashboard'));
            $this->load->view('admin/dashboard');
            $this->load->view('admin/layout/footer');
    }

    public function qrcode() {
        $this->load->library('ciqrcode');
        header("Content-Type: image/png");
        $params['data'] = $this->input->get('s');
        $this->ciqrcode->generate($params);
    }


    public function test() {
        $this->load->model('model_laporan');
        $data = $this->model_laporan->penumpang_per_bulan('2018');
        print_r($data);
    }
}