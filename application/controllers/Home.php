<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index() {
        
        $this->load->model('model_slideshow');

        $data['slideshow'] = $this->model_slideshow->tampil();

        $css = array(
            'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
            'assets/plugins/select2/select2.min.css',
            'assets/plugins/select2/select2-bootstrap.min.css',
        );
        $js = array(
            'assets/plugins/select2/select2.full.min.js',
            'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        );
        $this->load->view('layout/header', array('css' => $css));
        $this->load->view('home', $data);
        $this->load->view('layout/footer', array('js' => $js));
    }
}
