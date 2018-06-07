<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }

        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbutil();
    }

    public function index() {
        $prefs = array(
                'tables'        => array('kereta', 'stasiun', 'user', 'slideshow', 'kelas', 'gerbong', 'jadwal', 'pemesanan', 'penumpang'),
                'ignore'        => array(),
                'format'        => 'txt',
                'filename'      => 'tiketmaster.sql',
                'add_drop'      => TRUE,
                'add_insert'    => TRUE,
                'newline'       => "\n",
                'foreign_key_checks' => TRUE,
                'per_1000_baris' => TRUE
        );

        $backup = $this->dbutil->backup($prefs);
        force_download('tiketmaster.sql', $backup);
    }
}