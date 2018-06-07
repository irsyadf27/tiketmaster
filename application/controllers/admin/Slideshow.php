<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_slideshow');

        $config['upload_path'] = 'assets/slideshow/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '0';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
    }

    public function index() {
        $this->load->view('admin/layout/header', array('title' => 'Kelola Slideshow'));
        $this->load->view('admin/layout/sidebar', array('active' => 'slideshow'));
        $this->load->view('admin/slideshow/list');
        $this->load->view('admin/layout/footer');
    }

    public function hapus($id) {
        $hapus = $this->model_slideshow->delete($id);
        if($hapus) {
            $this->session->set_flashdata('sukses', 'Berhasil menghapus slideshow.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus slideshow.');
        }
        redirect(site_url('admin/slideshow'), 'refresh');
    }

    public function ubah($id) {
        $data['data'] = $this->model_slideshow->get($id);

        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $tampil = $this->input->post('tampil');


        /* Validasi Input */
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|max_length[250]');
        //$this->form_validation->set_rules('gambar', 'Gambar', 'callback_validasi_gambar');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Ubah Slideshow'));
            $this->load->view('admin/layout/sidebar', array('active' => 'slideshow'));
            $this->load->view('admin/slideshow/ubah', $data);
            $this->load->view('admin/layout/footer');
        } else {
            $gambar = '';
            if ($this->upload->do_upload('gambar')) {
                $image_data = $this->upload->data();
                if($image_data) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image_data['full_path'];
                    $config['create_thumb'] = TRUE;
                    $config['new_image'] = $image_data['file_path'] . 'thumb/';
                    //$config['maintain_ratio'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['width'] = 150;
                    $config['height'] = 150;

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $gambar = $image_data['file_name'];
                }
            }
            $data_update = array(
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'tampil' => $tampil
            );
            if($gambar != '') {
                $data_update['gambar'] = $gambar;
            }
            $update = $this->model_slideshow->update($data_update, $id);
            if($update) {
                $this->session->set_flashdata('sukses', 'Berhasil mengubah slideshow.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah slideshow.');
            }
            redirect(site_url('admin/slideshow'), 'refresh');
        }
    }

    public function tambah() {
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $tampil = $this->input->post('tampil');


        /* Validasi Input */
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|max_length[250]');
        $this->form_validation->set_rules('gambar', 'Gambar', 'callback_validasi_gambar');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/layout/header', array('title' => 'Tambah Slideshow'));
            $this->load->view('admin/layout/sidebar', array('active' => 'slideshow'));
            $this->load->view('admin/slideshow/tambah');
            $this->load->view('admin/layout/footer');
        } else {
            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('error', 'Gagal mengupload gambar.');
                redirect(site_url('admin/slideshow/tambah'), 'refresh');
            } else {
                $gambar = '';

                $image_data = $this->upload->data();
                if($image_data) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $image_data['full_path'];
                    $config['create_thumb'] = TRUE;
                    $config['new_image'] = $image_data['file_path'] . 'thumb/';
                    //$config['maintain_ratio'] = TRUE;
                    $config['thumb_marker'] = '';
                    $config['width'] = 150;
                    $config['height'] = 150;

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $gambar = $image_data['file_name'];
                }

                $data_insert = array(
                    'judul' => $judul,
                    'deskripsi' => $deskripsi,
                    'gambar' => $gambar,
                    'tampil' => $tampil
                );

                $insert = $this->model_slideshow->insert($data_insert);
                if($insert) {
                    $this->session->set_flashdata('sukses', 'Berhasil menambah slideshow.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambah slideshow.');
                }
                redirect(site_url('admin/slideshow'), 'refresh');
            }
        }
    }

    public function slideshow() {
        $columns = array( 
            0 =>'judul', 
            1 =>'deskripsi',
            2 =>'tampil'
        );

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $total_data = $this->model_slideshow->datatables_all_count();

        $total_filter = $total_data; 

        if(empty($this->input->post('search')['value'])) {            
            $slideshow = $this->model_slideshow->datatables_all($limit, $offset, $order, $dir);
        } else {
            $search = $this->input->post('search')['value']; 
            $slideshow =  $this->model_slideshow->datatables_search($limit, $offset, $search, $order, $dir);
            $total_filter = $this->model_slideshow->datatables_search_count($search);
        }

        $data = array();
        if(!empty($slideshow)) {
            foreach ($slideshow as $st) {
                $dt['judul'] = $st->judul;
                $dt['deskripsi'] = (strlen($st->deskripsi) > 150) ? substr($st->deskripsi, 0, 150) . '...' : $st->deskripsi;
                $dt['gambar'] = '<img src="' . base_url('assets/slideshow/thumb/' . $st->gambar) . '">';
                $dt['tampil'] = $st->tampil;
                $dt['aksi'] = '
                <a href="' . site_url('admin/slideshow/ubah/' . $st->id) . '" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i> Ubah</a> 
                <button type="button" class="btn btn-sm btn-danger" onclick="javascript: hapus_slideshow(\'' . $st->id .'\');"><i class="fa fa-trash"></i> Hapus</button>';

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
    public function validasi_gambar($str){
        $allowed_mime_type_arr = array('jpg', 'png', 'jpeg', 'gif');
        $ext = explode('.', $_FILES['gambar']['name']);
        $mime = end($ext);
        if(isset($_FILES['gambar']['name']) && $_FILES['gambar']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('validasi_gambar', 'Hanya diperbolehkan file jpg,jpeg,png dan gif.');
                return false;
            }
        }else{
            $this->form_validation->set_message('validasi_gambar', '%s harus diisi.');
            return false;
        }
    }
}