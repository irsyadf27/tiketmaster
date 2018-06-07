<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stasiun extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_stasiun');
    }

    public function cari_json() {
        $data = $this->model_stasiun->cari($this->input->get('q'));
        $result = array(
            'results' => $data
        );

        echo json_encode($result);
    }

    public function test() {
        $data = $this->model_stasiun->datatable_search(10, 0, 'cica', 'kode', 'ASC');
        print_r($data);
    }
}
