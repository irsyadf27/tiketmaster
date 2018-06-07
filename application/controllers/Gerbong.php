<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gerbong extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_gerbong');
    }

    public function get_kelas($id) {
        $date = DateTime::createFromFormat('d/m/Y', $this->input->post('tanggal'));
        //$date = DateTime::createFromFormat('d/m/Y', '13/01/2018');

        $gerbong = $this->model_gerbong->get($id);
        $data_kursi = $this->model_gerbong->get_kursi($id, $date->format('Y-m-d'));

        $func = function($value) {
            return $value['kursi'];
        };

        $kursi = array_map($func, $data_kursi);

        $result = array(
            'gerbong' =>  $gerbong,
            'kursi' => $kursi,
            'selected' => $this->get_sess_kursi($gerbong->id, false),
            'penumpang' => ($this->session->userdata('pilih_kursi') != '') ? $this->session->userdata('pilih_kursi') : array()
        );

        echo json_encode($result);
    }

    public function get_sess_kursi($gerbong, $json=true) {
        $session = ($this->session->userdata('selected') != '') ? $this->session->userdata('selected') : array();
        $sess_pilih_kursi = ($this->session->userdata('pilih_kursi') != '') ? $this->session->userdata('pilih_kursi') : array();
        $selected = array();

        foreach($session as $kursi) {
            if($kursi['g'] == $gerbong) {
                $selected[$kursi['p']] = $kursi['k'];
            }
        }

        if($json == true) {
            echo json_encode($this->session);
        } else {
            return $selected;
        }
    }

    public function set_kursi($gerbong, $penumpang, $kursi) {
        $session = ($this->session->userdata('selected') != '') ? $this->session->userdata('selected') : array();
        $sess_pilih_kursi = ($this->session->userdata('pilih_kursi') != '') ? $this->session->userdata('pilih_kursi') : array();

        $sukses = 0;
        if(!in_array($penumpang, $sess_pilih_kursi)) {

            $bisa_isi = true;
            foreach($session as $key => $val) {
                if($val['k'] == $kursi) {
                    $bisa_isi = false;
                }
            }
            if($bisa_isi) {
                $session[] = array('g' => $gerbong, 'p'=> $penumpang, 'k'=> $kursi);
                $sess_pilih_kursi[] = $penumpang;
                $this->session->set_userdata('pilih_kursi', $sess_pilih_kursi);
                $this->session->set_userdata('selected', $session);
                $sukses = 1;
            }
        }
        
        echo json_encode(array('sukses' => $sukses));
    }

    public function del_kursi($gerbong, $penumpang, $kursi) {
        $session = ($this->session->userdata('selected') != '') ? $this->session->userdata('selected') : array();
        $sess_pilih_kursi = ($this->session->userdata('pilih_kursi') != '') ? $this->session->userdata('pilih_kursi') : array();

        $list_pilih_kursi = array_diff($sess_pilih_kursi, array($penumpang));
        $sukses = 0;
        foreach($session as $key => $val) {
            if($val['p'] == $penumpang && $val['k'] == $kursi) {
                unset($session[$key]);
                $sukses = 1;
            }
        }
        if($sukses) {
            $this->session->set_userdata('selected', $session);
            $this->session->set_userdata('pilih_kursi', $list_pilih_kursi);
        }
        
        echo json_encode(array('sukses' => $sukses));
    }

    public function reset_kursi() {
        $this->session->unset_userdata('selected');
        $this->session->unset_userdata('pilih_kursi');
        
        echo json_encode(array('sukses' => 1));
    }
}
