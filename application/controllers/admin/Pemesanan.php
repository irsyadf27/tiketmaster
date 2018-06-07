<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }

        $this->load->model('model_pemesanan');
        $this->load->model('model_penumpang');
        $this->load->model('model_user');
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola Pemesanan'));
        $this->load->view('admin/layout/sidebar', array('active' => 'pemesanan'));
        $this->load->view('admin/pemesanan/list');
        $this->load->view('admin/layout/footer');
    }

    public function detail($id) {
        $data['pemesanan'] = $this->model_pemesanan->get($id);
        if(!$data['pemesanan']) {
            redirect(site_url('admin/pemesanan'));
        }
        $data['pemesan'] = $this->model_user->get_id($data['pemesanan']->id_user);
        $data['detail_kereta'] = $this->model_pemesanan->detail_kereta($data['pemesanan']->id);

        $this->load->view('admin/layout/header', array('title' => 'Detail Pemesanan'));
        $this->load->view('admin/layout/sidebar', array('active' => 'pemesanan'));
        $this->load->view('admin/pemesanan/detail', $data);
        $this->load->view('admin/layout/footer');
    }

    public function pemesanan() {
        $columns = array( 
            0 =>'nama_pemesan', 
            1 =>'kereta',
            2 =>'tanggal',
            3 =>'jumlah',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_pemesanan->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $pemesanan = $this->model_pemesanan->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $pemesanan =  $this->model_pemesanan->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_pemesanan->datatables_search_count($search);
        }

        $data = array();
        if(!empty($pemesanan)) {
            foreach ($pemesanan as $st) {
                $dt['pemesan'] = $st->nama_pemesan;
                $dt['kereta'] = $st->kereta . " <small>" . $st->nama_stasiun_asal . " - " . $st->nama_stasiun_tujuan . "</small>";
                $dt['tanggal'] = tgl_indo3($st->tanggal);
                $dt['jumlah'] = $st->jumlah;
                $dt['aksi'] = '
                <a href="' . site_url('admin/pemesanan/detail/' . $st->id) . '" class="btn btn-sm btn-info" onclick=""><i class="fa fa-th"></i> Detail</a>';

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

    public function detail_pemesanan($id_pemesanan) {
        $columns = array( 
            0 =>'no_identitas', 
            1 =>'nama_lengkap',
            2 =>'nama_gerbong',
            3 =>'kursi',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_penumpang->datatables_all_count($id_pemesanan);

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $pemesanan = $this->model_penumpang->datatables_all($id_pemesanan, $limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $pemesanan =  $this->model_penumpang->datatables_search($id_pemesanan, $limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_penumpang->datatables_search_count($id_pemesanan, $search);
        }

        $data = array();
        if(!empty($pemesanan)) {
            foreach ($pemesanan as $st) {
                $dt['no_identitas'] = $st->no_identitas;
                $dt['nama_lengkap'] = $st->nama_lengkap;
                $dt['nama_gerbong'] = $st->nama_gerbong;
                $dt['kursi'] = $st->kursi;
                $dt['aksi'] = '
                <button type="button" class="btn btn-sm btn-info edit-identitas" data-id="' . $st->id . '" data-identitas="' . $st->no_identitas . '" data-nama="' . $st->nama_lengkap . '"><i class="fa fa-pencil"></i> Ubah Identitas</button>';

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
    function validasi_kode($kode){
        $cek = $this->model_pemesanan->get($kode);
        if($cek) {
            $this->form_validation->set_message('validasi_kode', 'Kode Pemesanan sudah digunakan!');
            return false;
        } else {
            return true;
        }
    }
}
