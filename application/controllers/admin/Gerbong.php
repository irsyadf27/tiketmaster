<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerbong extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_kereta');
        $this->load->model('model_kelas');
        $this->load->model('model_gerbong');
    }

    public function tambah($kode_kereta) {
        $kereta = $this->model_kereta->get($kode_kereta);
        if($kereta) {
            $data_tambah = array(
                'kode_kereta' => $kode_kereta,
                'nama' => $this->input->post('nama'),
                'kelas' => $this->input->post('kelas'),
                'no_gerbong' => $this->input->post('no_gerbong'),
            );

            $insert = $this->model_gerbong->insert($data_tambah);
            if($insert) {
                $this->session->set_flashdata('sukses', 'Berhasil menambah gerbong.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah gerbong.');
            }
            redirect(site_url('admin/kereta/gerbong/' . $kode_kereta), 'refresh');
        }
    }

    public function hapus($id) {
        $this->load->library('user_agent');
        $hapus = $this->model_gerbong->delete_by_id($id);
        if($hapus) {
            $this->session->set_flashdata('sukses', 'Berhasil menghapus gerbong.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus gerbong.');
        }
        redirect($this->agent->referrer(), 'refresh');
    }

    public function ubah_nama() {
        if($this->input->post('id')) {
            $data_update = array(
                'nama' => $this->input->post('nama'),
                'id' => $this->input->post('id'),
            );
            $this->model_gerbong->update($data_update);
        }
    }

    public function ubah_kelas() {
        if($this->input->post('id')) {
            $data_update = array(
                'kelas' => $this->input->post('kelas'),
                'id' => $this->input->post('id'),
            );
            $this->model_gerbong->update($data_update);
        }
    }

    public function ubah_nomor() {
        if($this->input->post('id')) {
            $data_update = array(
                'no_gerbong' => $this->input->post('nomor'),
                'id' => $this->input->post('id'),
            );
            $this->model_gerbong->update($data_update);
        }
    }
}
