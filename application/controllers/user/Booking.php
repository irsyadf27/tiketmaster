<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if(!$this->session->userdata('login')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect(site_url('auth/login'));
        }

        $this->load->library('pagination');
        $this->load->model('model_pemesanan');
        $this->load->model('model_penumpang');
    }

    public function detail($id) {
        $data['pemesanan'] = $this->model_pemesanan->get($id);
        if(!$data['pemesanan']) {
            redirect(site_url('user/booking'));
        } else if($data['pemesanan']->id_user != $this->session->userdata('id_user')) {
            redirect(site_url('user/booking'));
        }
        $data['pemesan'] = $this->model_user->get_id($data['pemesanan']->id_user);
        $data['detail_kereta'] = $this->model_pemesanan->detail_kereta($data['pemesanan']->id);
        $data['penumpang'] = $this->model_penumpang->get($data['pemesanan']->id_user);
        $this->load->view('layout/header', array('title' => 'Details Booking'));
        $this->load->view('user/details', $data);
        $this->load->view('layout/footer2');
    }

    public function qrcode() {
        $this->load->library('ciqrcode');
        header("Content-Type: image/png");
        $params['data'] = $this->input->get('s');
        $this->ciqrcode->generate($params);
    }

    public function index($offset = 0) {

        $keyword = $this->input->get('pencarian');
        $config['base_url'] = site_url('user/booking/index');
        $config['per_page'] = 10;
        $config['reuse_query_string'] = true;
        $config['first_link'] = '&laquo;';
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = ' <span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        if($keyword != '') {
            $config['total_rows'] = $this->model_pemesanan->count_all_by_user_search($this->session->userdata('id_user'), $keyword);
            $data['result'] = $this->model_pemesanan->get_all_by_user_search($this->session->userdata('id_user'), $offset, $config['per_page'], $keyword);
        } else {
            $config['total_rows'] = $this->model_pemesanan->count_all_by_user($this->session->userdata('id_user'));
            $data['result'] = $this->model_pemesanan->get_all_by_user($this->session->userdata('id_user'), $offset, $config['per_page']);
        }

        $this->pagination->initialize($config);

        

        $data['keyword'] = $keyword;
        $data['curr_page'] = ($offset != '') ? $offset + 1: 1;

        $this->load->view('layout/header', array('title' => 'Riwayat Booking'));
        $this->load->view('layout/sidebar', array('active' => 'riwayat-booking'));
        $this->load->view('user/riwayatbooking', $data);
        $this->load->view('layout/footer2');
    }
}
