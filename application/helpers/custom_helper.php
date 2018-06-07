<?php
function alert_sukses($teks) {
 return '<div class="alert alert-success alert-dismissible text-left"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses!</h4>' . $teks .'</div>';
}

function alert_warning($teks) {
 return '<div class="alert alert-warning alert-dismissible text-left"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Peringatan!</h4>' . $teks .'</div>';
}

function alert_error($teks) {
 return '<div class="alert alert-danger alert-dismissible text-left"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Error!</h4>' . $teks .'</div>';
}

function alert_info($teks) {
 return '<div class="alert alert-info alert-dismissible text-left"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-info"></i> Info!</h4>' . $teks .'</div>';
}

function enkripsi_password($password) {
    $options = array(
        'cost' => 12,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    );
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

function format_uang($number = ''){
    $value = 'Rp. ' . number_format($number, 2, ',', '.') ;
    return $value;
}

function tgl_indo($tanggal) {
    $hari = array ('Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array ('Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $d = DateTime::createFromFormat('d/m/Y', $tanggal);
    if($d) {
        $tgl_indo = $d->format('d') . ' ' . $bulan[$d->format('m') - 1] . ' ' . $d->format('Y');
        $num = date('N', strtotime($d->format('Y-m-d')));
        return $hari[$num - 1] . ', ' . $tgl_indo;
    }
}

function tgl_indo2($d) {
    $hari = array ('Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array ('Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            );

    $tgl_indo = $d->format('d') . ' ' . $bulan[$d->format('m') - 1] . ' ' . $d->format('Y');
    $num = date('N', strtotime($d->format('Y-m-d')));
    return $hari[$num - 1] . ', ' . $tgl_indo . ' ' .$d->format('H'). ':' .$d->format('i');
}

function tgl_indo3($tanggal) {
    $hari = array ('Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array ('Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            );
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    $tgl_indo = $d->format('d') . ' ' . $bulan[$d->format('m') - 1] . ' ' . $d->format('Y');
    $num = date('N', strtotime($d->format('Y-m-d')));
    return $hari[$num - 1] . ', ' . $tgl_indo;
}