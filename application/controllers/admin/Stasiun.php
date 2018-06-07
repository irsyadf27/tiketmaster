<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stasiun extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_stasiun');
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola Stasiun'));
        $this->load->view('admin/layout/sidebar', array('active' => 'stasiun'));
        $this->load->view('admin/stasiun/list');
        $this->load->view('admin/layout/footer');
    }

    public function tambah() {
        $nama = $this->input->post('nama');
        $kode = $this->input->post('kode');


        /* Validasi Input */
        $this->form_validation->set_rules('kode', 'Kode Stasiun', 'required|trim|alpha_numeric|callback_validasi_kode|max_length[10]');
        $this->form_validation->set_rules('nama', 'Nama Stasiun', 'required|trim|min_length[2]|max_length[50]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Tambah Stasiun'));
            $this->load->view('admin/layout/sidebar', array('active' => 'stasiun'));
            $this->load->view('admin/stasiun/tambah');
            $this->load->view('admin/layout/footer');
        } else {
            $data = array(
                'kode' => $kode,
                'nama' => $nama
            );

            $tambah = $this->model_stasiun->insert($data);
            if($tambah) {
                $this->session->set_flashdata('sukses', 'Berhasil menambah stasiun.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah stasiun.');
            }
            redirect(site_url('admin/stasiun'), 'refresh');
        }
    }

    public function hapus($kode) {
        $hapus = $this->model_stasiun->delete($kode);
        if($hapus) {
            $this->session->set_flashdata('sukses', 'Berhasil menghapus stasiun.');
            redirect(site_url('admin/stasiun'), 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus stasiun.');
            redirect(site_url('admin/stasiun'), 'refresh');
        }
    }

    public function ubah() {
        /* Validasi Input */
        $this->form_validation->set_rules('kode', 'Kode Stasiun', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama Stasiun', 'required|trim|min_length[2]|max_length[50]');

        if ($this->form_validation->run() == TRUE) {
            $data_ubah = array(
                'kode' => $this->input->post('kode'),
                'nama' => $this->input->post('nama'),
            );
            $ubah = $this->model_stasiun->update($data_ubah);
            if($ubah) {
                $this->session->set_flashdata('sukses', 'Berhasil mengubah stasiun.');
                redirect(site_url('admin/stasiun'), 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah stasiun.');
                redirect(site_url('admin/stasiun'), 'refresh');
            }
        }
    }

    public function stasiun() {
        $columns = array( 
            0 =>'kode', 
            1 =>'nama',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_stasiun->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $stasiun = $this->model_stasiun->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $stasiun =  $this->model_stasiun->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_stasiun->datatables_search_count($search);
        }

        $data = array();
        if(!empty($stasiun)) {
            foreach ($stasiun as $st) {
                $dt['kode'] = $st->kode;
                $dt['nama'] = $st->nama;
                $dt['aksi'] = '
                <button type="button" class="btn btn-sm btn-info" onclick="javascript: edit_stasiun(\'' . $st->kode .'\', \'' . $st->nama .'\');"><i class="fa fa-pencil-square-o"></i> Ubah</button> 
                <button type="button" class="btn btn-sm btn-danger" onclick="javascript: hapus_stasiun(\'' . $st->kode .'\');"><i class="fa fa-trash"></i> Hapus</button>';

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
        $cek = $this->model_stasiun->get($kode);
        if($cek) {
            $this->form_validation->set_message('validasi_kode', 'Kode Stasiun sudah digunakan!');
            return false;
        } else {
            return true;
        }
    }
}
