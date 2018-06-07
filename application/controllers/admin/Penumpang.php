<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penumpang extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }
        
        $this->load->model('model_penumpang');
        $this->load->library('user_agent');
    }

    public function ubah() {
        /* Validasi Input */
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|min_length[2]|max_length[50]|callback_validasi_nama');
        $this->form_validation->set_rules('no_identitas', 'No. Identitas', 'required|trim|min_length[2]|max_length[30]');

        if ($this->form_validation->run() == TRUE) {
            $data_ubah = array(
                'id' => $this->input->post('id_penumpang'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'no_identitas' => $this->input->post('no_identitas'),
            );
            $ubah = $this->model_penumpang->update($data_ubah);
            if($ubah) {
                $this->session->set_flashdata('sukses', 'Berhasil mengubah penumpang.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah penumpang.');
            }

            $url = ($this->agent->referrer() != '') ? $this->agent->referrer() : site_url('admin/pemesanan/detail/' . $this->input->post('id_pemesanan'));
            redirect($url, 'refresh');
        }
    }


    function validasi_nama($nama){
        if (! preg_match('/^[a-zA-Z\s]+$/', $nama)) {
            $this->form_validation->set_message('validasi_nama', '%s hanya boleh berisi abjad dan spasi.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}