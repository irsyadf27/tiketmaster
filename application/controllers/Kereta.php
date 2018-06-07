<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kereta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_jadwal');
        $this->load->model('model_stasiun');
        $this->load->model('model_gerbong');

        $this->css = array(
            'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
            'assets/plugins/sweetalert2-6.10.3/sweetalert2.min.css',
            'assets/css/jquery.seat-charts.css',
            'assets/plugins/select2/select2.min.css',
            'assets/plugins/select2/select2-bootstrap.min.css',
        );

        $this->js = array(
            'assets/plugins/select2/select2.full.min.js',
            'assets/plugins/sweetalert2-6.10.3/sweetalert2.min.js',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'assets/js/jquery.seat-charts.min.js',
        );
    }

    public function cari() {
        $asal = $this->input->get('asal');
        $tujuan = $this->input->get('tujuan');
        $tgl = $this->input->get('tgl');
        $kursi = $this->input->get('kursi');

        /* Validasi Input */
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('asal', 'Asal', 'required|callback_validasi_stasiun');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required|callback_validasi_stasiun');
        $this->form_validation->set_rules('tgl', 'Tanggal Pemberangkatan', 'required|callback_validasi_tanggal');
        $this->form_validation->set_rules('kursi', 'Jumlah Kursi', 'required|is_natural|less_than[7]');
            
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', array('css' => $this->css, 'title' => 'Pilih Kereta'));
            $this->load->view('home');
            $this->load->view('layout/footer', array('js' => $this->js));
        } else {
            $data['asal'] = $this->model_stasiun->get($asal);
            $data['tujuan'] = $this->model_stasiun->get($tujuan);
            $data['kursi'] = $kursi;
            $data['tgl'] = $tgl;
            $data['jadwal'] = $this->model_jadwal->cari_pemberangkatan($asal, $tujuan);

            $this->load->view('layout/header', array('css' => $this->css, 'title' => 'Pilih Kereta'));
            $this->load->view('pilih_kereta', $data);
            $this->load->view('layout/footer', array('js' => $this->js));
        }
    }

    public function pilih($jadwal) {
        if(!isset($this->session->login)) {
            redirect(site_url('auth/login'));
        }

        $tgl = $this->input->get('tgl');
        $kursi = $this->input->get('kursi');

        /* Validasi Input */
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('tgl', 'Tanggal Pemberangkatan', 'required|callback_validasi_tanggal');
        $this->form_validation->set_rules('kursi', 'Jumlah Kursi', 'required|is_natural|less_than[7]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', array('css' => $this->css, 'title' => 'Pilih Kereta'));
            $this->load->view('home');
            $this->load->view('layout/footer', array('js' => $this->js));
        } else {
            $data['kursi'] = $kursi;
            $data['tgl'] = $tgl;
            $data['jadwal'] = $this->model_jadwal->get($jadwal);
            if(!$data['jadwal']) {
                redirect(site_url());
            }
            $data['gerbong'] = $this->model_gerbong->kereta($data['jadwal']->kode_kereta);

            if($this->input->post()) {
                $this->form_validation->set_data($this->input->post());
                for($i=1; $i <= $kursi; $i++) {
                    $this->form_validation->set_rules('nama_lengkap[' . $i . ']', 'Nama Lengkap ' . $i, 'required|trim|min_length[3]|callback_validasi_nama');
                    $this->form_validation->set_rules('no_identitas[' . $i . ']', 'No. Identitas ' . $i, 'required|trim|min_length[3]');
                    $this->form_validation->set_rules('hidden_gerbong[' . $i . ']', 'Gerbong ' . $i, 'required|trim');
                    //$this->form_validation->set_rules('hidden_row[' . $i . ']', 'Baris ' . $i, 'required|trim');
                    $this->form_validation->set_rules('hidden_seat[' . $i . ']', 'Kursi ' . $i, 'required|trim');
                }
                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('layout/header', array('css' => $this->css));
                    $this->load->view('order', $data);
                    $this->load->view('layout/footer', array('js' => $this->js));
                } else {
                    $date = DateTime::createFromFormat('d/m/Y', $tgl);
                    $this->load->model('model_pemesanan');
                    $this->load->model('model_penumpang');
                    
                    $kode_booking = $this->model_pemesanan->generate_kode_booking();

                    $data_pemesanan = array(
                        'id_user' => $this->session->userdata('id_user'),
                        'id_jadwal' => $jadwal,
                        'tanggal' => $date->format('Y-m-d'),
                        'kode_booking' => $kode_booking
                    );
                    $pemesanan_id = $this->model_pemesanan->insert($data_pemesanan);

                    if($pemesanan_id) {
                        for($i=1; $i <= $kursi; $i++) {
                            $data_penumpang = array(
                                'id_pemesanan' => $pemesanan_id, 
                                'nama_lengkap' => $this->input->post('nama_lengkap[' . $i . ']'), 
                                'no_identitas' => $this->input->post('no_identitas[' . $i . ']'), 
                                'id_gerbong' => $this->input->post('hidden_gerbong[' . $i . ']'), 
                                'row' => $this->input->post('hidden_row[' . $i . ']'), 
                                'seat' => $this->input->post('hidden_seat[' . $i . ']')
                            );
                            $this->model_penumpang->insert($data_penumpang);
                        }
                    }
                    $this->session->set_flashdata('sukses', 'Booking tiket berhasil.');
                    redirect(site_url('user/booking'));
                }
            } else {
                $this->session->unset_userdata('selected');
                $this->session->unset_userdata('pilih_kursi');
                $this->load->view('layout/header', array('css' => $this->css));
                $this->load->view('order', $data);
                $this->load->view('layout/footer', array('js' => $this->js));
            }
        }
    }

    public function pilih_kursi($gerbong_id) {
        $kursi_dipilih = $this->input->post('dipilih');

        if($kursi_dipilih != '') {
            $list_session = $this->session->userdata('gerbong' . $gerbong_id);
            if(!in_array($kursi_dipilih, $list_session)) {
                $list_session[] = $kursi_dipilih;
                $this->session->set_userdata(array('gerbong' . $gerbong_id => $list_session));
            }
        } else {
            
        }
    }

    /* Validasi */
    function validasi_stasiun($kode){
        $cek = $this->model_stasiun->get($kode);
        if(!$cek) {
            $this->form_validation->set_message('validasi_stasiun', 'Stasiun Tidak Ditemukan!');
            return false;
        } else {
            return true;
        }
    }

    function validasi_tanggal($tgl) {
        $d = DateTime::createFromFormat('d/m/Y', $tgl);
        if($d && $d->format('d/m/Y') == $tgl) {
            return true;
        } else {
            $this->form_validation->set_message('validasi_tanggal', 'Tanggal Pemberangkatan Tidak Valid!');
            return false;
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
