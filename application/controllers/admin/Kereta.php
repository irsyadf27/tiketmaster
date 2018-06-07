<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kereta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }

        $this->load->model('model_kereta');
        $this->load->model('model_kelas');
        $this->load->model('model_gerbong');
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola kereta'));
        $this->load->view('admin/layout/sidebar', array('active' => 'kereta'));
        $this->load->view('admin/kereta/list');
        $this->load->view('admin/layout/footer');
    }

    public function tambah() {
        $nama = $this->input->post('nama');
        $kode = $this->input->post('kode');


        /* Validasi Input */
        $this->form_validation->set_rules('kode', 'Kode kereta', 'required|trim|alpha_numeric|callback_validasi_kode|max_length[10]');
        $this->form_validation->set_rules('nama', 'Nama kereta', 'required|trim|min_length[2]|max_length[50]');

        for($i=0; $i < count($this->input->post('nama_gerbong')); $i++) {
            $this->form_validation->set_rules('nama_gerbong[' . $i . ']', 'Nama Gerbong ke ' . ($i + 1), 'required|trim|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('no_gerbong[' . $i . ']', 'No. Gerbong ke ' . ($i + 1), 'required|trim|numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Tambah kereta'));
            $this->load->view('admin/layout/sidebar', array('active' => 'kereta'));
            $this->load->view('admin/kereta/tambah', array(
                'gerbong' => count($this->input->post('nama_gerbong')),
                'kelas' => count($this->input->post('kelas'))
            ));
            $this->load->view('admin/layout/footer');
        } else {

            $data_kereta = array(
                'kode' => $kode,
                'nama' => $nama
            );

            $tambah = $this->model_kereta->insert($data_kereta);
            if($tambah) {

                for($i=0; $i < count($this->input->post('kelas')); $i++) {
                    $data_kelas = array(
                        'kode_kereta' => $tambah,
                        'kelas' => $this->input->post('kelas[' . $i . ']')
                    );
                    $this->model_kelas->insert($data_kelas);
                }

                for($i=0; $i < count($this->input->post('nama_gerbong')); $i++) {
                    $data_gerbong = array(
                        'kode_kereta' => $tambah,
                        'nama' => $this->input->post('nama_gerbong[' . $i . ']'),
                        'kelas' => $this->input->post('kelas_gerbong[' . $i . ']'),
                        'no_gerbong' => $this->input->post('no_gerbong[' . $i . ']')
                    );

                    $this->model_gerbong->insert($data_gerbong);
                }

                $this->session->set_flashdata('sukses', 'Berhasil menambah kereta.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah kereta.');
            }
            redirect(site_url('admin/kereta'), 'refresh');
            
        }
    }

    public function hapus($kode_kereta) {
        $this->load->model('model_jadwal');
        $hapus = $this->model_kereta->delete($kode_kereta);
        if($hapus) {
            $this->model_kelas->delete($kode_kereta);
            $this->model_gerbong->delete($kode_kereta);
            $this->model_jadwal->delete($kode_kereta);
            $this->session->set_flashdata('sukses', 'Berhasil menghapus kereta.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kereta.');
        }
        redirect(site_url('admin/kereta'), 'refresh');
    }

    public function ubah($kode_kereta) {
        $data['kereta'] = $this->model_kereta->get($kode_kereta);

        if(!$data['kereta']) {
            redirect(site_url('admin/kereta'));
        }

        if(!$this->input->post('kelas')) {
            $data['kelas'] = $this->model_kelas->get($kode_kereta);
        } else {
            $data['kelas'] = '';
        }
        $data['kelas_tambahan'] = count($this->input->post('kelas'))
        ;
        /* Validasi Input */
        $this->form_validation->set_rules('nama', 'Nama kereta', 'required|trim|min_length[2]|max_length[50]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Ubah kereta'));
            $this->load->view('admin/layout/sidebar', array('active' => 'kereta'));
            $this->load->view('admin/kereta/ubah', $data);
            $this->load->view('admin/layout/footer');
        } else {
            $this->model_kelas->delete($kode_kereta);
            for($i=0; $i < count($this->input->post('kelas')); $i++) {
                $data_kelas = array(
                    'kode_kereta' => $kode_kereta,
                    'kelas' => $this->input->post('kelas[' . $i . ']')
                );
                $this->model_kelas->insert($data_kelas);
            }
            $data_update = array(
                'kode' => $kode_kereta,
                'nama' => $this->input->post('nama'),
            ); 
            $update = $this->model_kereta->update($data_update);
            if($update) {
                $this->session->set_flashdata('sukses', 'Berhasil mengubah kereta.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah kereta.');
            }
            redirect(site_url('admin/kereta'), 'refresh');
        }
    }

    public function gerbong($kode_kereta) {
        $css = array(
            'assets/admin/plugins/bootstrap3-editable/css/bootstrap-editable.css'
        );
        $js = array(
            'assets/admin/plugins/bootstrap3-editable/js/bootstrap-editable.min.js'
        );
        $data['kereta'] = $this->model_kereta->get($kode_kereta);

        if(!$data['kereta']) {
            redirect(site_url('admin/kereta'));
        }

        $data['gerbong'] = $this->model_gerbong->get_by_kereta($kode_kereta);

        $this->load->view('admin/layout/header', array('title' => 'Kelola Gerbong kereta', 'css' => $css));
        $this->load->view('admin/layout/sidebar', array('active' => 'kereta'));
        $this->load->view('admin/kereta/gerbong', $data);
        $this->load->view('admin/layout/footer', array('js' => $js));
    }

    public function kereta() {
        $columns = array( 
            0 => 'kode', 
            1 => 'nama',
            2 => 'kelas',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_kereta->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $kereta = $this->model_kereta->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $kereta =  $this->model_kereta->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_kereta->datatables_search_count($search);
        }

        $data = array();
        if(!empty($kereta)) {
            foreach ($kereta as $kt) {
                $dt['kode'] = $kt->kode;
                $dt['nama'] = $kt->nama;
                $dt['kelas'] = $kt->kelas;
                $dt['aksi'] = '
                <a href="' . site_url('admin/kereta/gerbong/' . $kt->kode) . '" class="btn btn-sm btn-primary"><i class="fa fa-wrench"></i> Kelola Gerbong</a> 
                <a href="' . site_url('admin/kereta/ubah/' . $kt->kode) . '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i> Ubah</a> 
                <button type="button" class="btn btn-sm btn-danger" onclick="javascript: hapus_kereta(\'' . $kt->kode .'\');"><i class="fa fa-trash"></i> Hapus</button>';

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
        $cek = $this->model_kereta->get($kode);
        if($cek) {
            $this->form_validation->set_message('validasi_kode', 'Kode kereta sudah digunakan!');
            return false;
        } else {
            return true;
        }
    }
}
