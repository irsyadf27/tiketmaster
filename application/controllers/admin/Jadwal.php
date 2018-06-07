<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_jadwal');
        $this->load->model('model_kereta');
        $this->load->model('model_stasiun');
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola Jadwal'));
        $this->load->view('admin/layout/sidebar', array('active' => 'jadwal'));
        $this->load->view('admin/jadwal/list');
        $this->load->view('admin/layout/footer');
    }

    public function kelola($kode_kereta) {
        $css = array(
            'assets/admin/plugins/bootstrap3-editable/css/bootstrap-editable.css',
            'assets/plugins/select2/select2.min.css',
            'assets/plugins/select2/select2-bootstrap.min.css',
            'assets/admin/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css',
        );
        $js = array(
            'assets/plugins/select2/select2.full.min.js',
            'assets/admin/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js',
            'assets/admin/plugins/bootstrap3-editable/js/bootstrap-editable.min.js',
        );
        $data['kereta'] = $this->model_kereta->get($kode_kereta);
        $data['kode_kereta'] = $kode_kereta;
        if(!$data['kereta']) {
            redirect(site_url('admin/jadwal'));
        }
        $this->load->view('admin/layout/header', array('title' => 'Kelola Jadwal', 'css' => $css));
        $this->load->view('admin/layout/sidebar', array('active' => 'jadwal'));
        $this->load->view('admin/jadwal/kelola', $data);
        $this->load->view('admin/layout/footer', array('js' => $js));
    }

    public function tambah($kode_kereta) {
        $css = array(
            'assets/plugins/select2/select2.min.css',
            'assets/plugins/select2/select2-bootstrap.min.css',
            'assets/admin/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css',
        );
        $js = array(
            'assets/plugins/select2/select2.full.min.js',
            'assets/admin/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js',
        );
        $data['kereta'] = $this->model_kereta->get($kode_kereta);
        $data['kode_kereta'] = $kode_kereta;
        if(!$data['kereta']) {
            redirect(site_url('admin/jadwal'));
        }

        /* Validasi Input */
        $this->form_validation->set_rules('asal', 'Stasiun Asal', 'required|trim|callback_validasi_stasiun');
        $this->form_validation->set_rules('tujuan', 'Stasiun Tujuan', 'required|trim|callback_validasi_stasiun');
        $this->form_validation->set_rules('berangkat', 'Waktu Berangkat', 'required|trim|callback_validasi_waktu');
        $this->form_validation->set_rules('tiba', 'Waktu Tiba', 'required|trim|callback_validasi_waktu');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Kelola Jadwal', 'css' => $css));
            $this->load->view('admin/layout/sidebar', array('active' => 'jadwal'));
            $this->load->view('admin/jadwal/tambah', $data);
            $this->load->view('admin/layout/footer', array('js' => $js));
        } else {
            $data_insert = array(
                'kode_kereta' => $kode_kereta,
                'asal' => $this->input->post('asal'),
                'tujuan' => $this->input->post('tujuan'),
                'waktu_berangkat' => $this->input->post('berangkat'),
                'waktu_tiba' => $this->input->post('tiba'),
            );

            $insert = $this->model_jadwal->insert($data_insert);
            if($insert) {
                $this->session->set_flashdata('sukses', 'Berhasil menambah jadwal.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah jadwal.');
            }
            redirect(site_url('admin/jadwal/kelola/' . $kode_kereta), 'refresh');
        }
    }

    public function hapus($id) {
        $this->load->library('user_agent');
        $hapus = $this->model_jadwal->delete_by_id($id);
        if($hapus) {
            $this->session->set_flashdata('sukses', 'Berhasil menghapus jadwal.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jadwal.');
        }
        redirect($this->agent->referrer(), 'refresh');
    }

    public function ubah() {
        if($this->input->post('id')) {
            $update = $this->model_jadwal->update($this->input->post());
            if($update) {
                echo json_encode(array('sukses' => 1, 'data' => $this->input->post()));
            }
        }
    }

    public function kelola_jadwal($kode_kereta) {
        $columns = array( 
            0 => 'nama_stasiun_asal', 
            1 => 'waktu_berangkat',
            2 => 'nama_stasiun_tujuan',
            3 => 'waktu_tiba',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_jadwal->datatables_kelola_all_count($kode_kereta);

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $jadwal = $this->model_jadwal->datatables_kelola_all($kode_kereta, $limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $jadwal =  $this->model_jadwal->datatables_kelola_search($kode_kereta, $limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_jadwal->datatables_kelola_search_count($kode_kereta, $search);
        }

        $data = array();
        if(!empty($jadwal)) {
            foreach ($jadwal as $st) {
                $dt['id'] = $st->id;
                $dt['nama_stasiun_asal'] = '<a href="#" id="kelola-st-asal-' . $st->id . '" data-type="select2" data-pk="' . $st->id . '" data-url="' . site_url('admin/jadwal/ubah') .'" data-title="Stasiun Pemberangkatan">' . $st->nama_stasiun_asal . '</a> <button type="button" id="btn-kelola-st-asal-' . $st->id . '" class="btn btn-sm btn-toggle-xedit" data-id="kelola-st-asal-' . $st->id . '"><i class="fa fa-pencil"></i></button>';

                $dt['waktu_berangkat'] = '<a href="#" id="kelola-waktu-asal-' . $st->id . '" data-type="datetime" data-pk="' . $st->id . '" data-url="' . site_url('admin/jadwal/ubah') .'" data-title="Waktu Berangkat" data-value="' . $st->waktu_berangkat . '">' . $st->waktu_berangkat . '</a> <button type="button" id="btn-kelola-waktu-asal-' . $st->id . '" class="btn btn-sm btn-toggle-xedit" data-id="kelola-waktu-asal-' . $st->id . '"><i class="fa fa-pencil"></i></button>';

                $dt['nama_stasiun_tujuan'] = '<a href="#" id="kelola-st-tujuan-' . $st->id . '" data-type="select2" data-pk="' . $st->id . '" data-url="' . site_url('admin/jadwal/ubah') .'" data-title="Stasiun Tujuan">' . $st->nama_stasiun_tujuan . '</a> <button type="button" id="btn-kelola-st-tujuan-' . $st->id . '" class="btn btn-sm btn-toggle-xedit" data-id="kelola-st-tujuan-' . $st->id . '"><i class="fa fa-pencil"></i></button>';

                $dt['waktu_tiba'] = '<a href="#" id="kelola-waktu-tiba-' . $st->id . '" data-type="datetime" data-pk="' . $st->id . '" data-url="' . site_url('admin/jadwal/ubah') .'" data-title="Waktu Tiba">' . $st->waktu_tiba . '</a> <button type="button" id="btn-kelola-waktu-tiba-' . $st->id . '" class="btn btn-sm btn-toggle-xedit" data-id="kelola-waktu-tiba-' . $st->id . '"><i class="fa fa-pencil"></i></button>';

                $dt['aksi'] = '
                <a href="#" class="btn btn-sm btn-danger" onclick="javascript: hapus_jadwal(\'' . $st->id . '\');"><i class="fa fa-trash"></i> Hapus</a>';

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

    public function semua() {
        $columns = array( 
            0 => 'kode', 
            1 => 'nama',
            2 => 'jumlah',
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_jadwal->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $jadwal = $this->model_jadwal->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $jadwal =  $this->model_jadwal->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_jadwal->datatables_search_count($search);
        }

        $data = array();
        if(!empty($jadwal)) {
            foreach ($jadwal as $st) {
                $dt['kode'] = $st->kode;
                $dt['nama'] = $st->nama;
                $dt['jumlah'] = $st->jumlah;
                $dt['aksi'] = '
                <a href="' . site_url('admin/jadwal/kelola/' . $st->kode) . '" class="btn btn-sm btn-primary" ><i class="fa fa-wrench"></i> Kelola Jadwal</button>';

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
    function validasi_stasiun($kode){
        $cek = $this->model_stasiun->get($kode);
        if(!$cek) {
            $this->form_validation->set_message('validasi_stasiun', '%s Tidak Ditemukan!');
            return false;
        } else {
            return true;
        }
    }

    function validasi_waktu($waktu) {
        if(preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $waktu)) {
            return true;
        } else {
            $this->form_validation->set_message('validasi_waktu', '%s Tidak Valid!');
            return false;
        }
    }
}