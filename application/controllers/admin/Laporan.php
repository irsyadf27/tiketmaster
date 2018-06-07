<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('jenis') != 'admin') {
            redirect(site_url());
        }

        $this->load->model('model_laporan');

        $this->js = array(
            'assets/admin/plugins/Highcharts-6.0.4/code/highcharts.js',
            'assets/admin/plugins/Highcharts-6.0.4/code/modules/series-label.js',
            //'assets/admin/plugins/Highcharts-6.0.4/code/modules/exporting.js',
            'assets/admin/laporan.js',
        );

    }

    public function pemesanan() {
        $tahun = ($this->input->get('tahun') != '') ? $this->input->get('tahun') : date('Y');
        $this->load->view('admin/layout/header', array('title' => 'Laporan'));
        $this->load->view('admin/layout/sidebar', array('active' => 'laporan_pemesanan'));
        $this->load->view('admin/laporan/pemesanan', array('tahun' => $tahun));
        $this->load->view('admin/layout/footer', array('js' => $this->js));
    }

    public function get_data_pemesanan($tahun) {
        $data['penumpang'] = $this->model_laporan->penumpang_per_bulan($tahun);
        $data['pemesanan'] = $this->model_laporan->pemesanan_per_bulan($tahun);
        $data['tahun'] = $tahun;
        echo json_encode($data);
    }

    public function export_pemesanan($tahun) {
        $this->load->library('PHPExcel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load('assets/excel/template_pemesanan.xls');
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Tahun ' . $tahun);

        $pemesanan = $this->model_laporan->pemesanan_per_bulan($tahun);
        $penumpang = $this->model_laporan->penumpang_per_bulan($tahun);

        $total_pemesanan = 0;
        for($i=0; $i < count($pemesanan); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 7), $pemesanan[$i]);
            $total_pemesanan += $pemesanan[$i];
        }
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 7), $total_pemesanan);

        $total_penumpang = 0;
        for($i=0; $i < count($penumpang); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 7), $penumpang[$i]);
            $total_penumpang += $penumpang[$i];
        }
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 7), $total_penumpang);


        // tanggal dicetak
        $objPHPExcel->getActiveSheet()->setCellValue('C21', tgl_indo(date('d/m/Y')) . ' ' . date('H:i'));

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save("test_.xls");

        $filename = 'Laporan Pemesanan Tahun ' . $tahun . '.xls';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'. $filename . '"');
        $objWriter->save('php://output');
    }
}