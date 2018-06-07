CREATE TABLE `kereta` (
  `kode` varchar(10) NOT NULL PRIMARY KEY,
  `nama` varchar(50) NOT NULL
);

CREATE TABLE `stasiun` (
  `kode` varchar(10) NOT NULL PRIMARY KEY,
  `nama` varchar(50) NOT NULL
);

CREATE TABLE `user` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL UNIQUE KEY,
  `email` varchar(50) NOT NULL UNIQUE KEY,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `jenis` enum('user','admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(250) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `tampil` enum('Y','T') NOT NULL
);

CREATE TABLE `kelas` (
  `kode_kereta` varchar(10) NOT NULL,
  `kelas` enum('Ekonomi','Eksekutif','Bisnis') NOT NULL
);

ALTER TABLE `kelas`
  ADD FOREIGN KEY (`kode_kereta`) REFERENCES `kereta` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `gerbong` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `kode_kereta` varchar(10) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `kelas` enum('EKO','EKO_AC','BIS','EKS') NOT NULL,
  `no_gerbong` int(3) NOT NULL
);
ALTER TABLE `gerbong`
  ADD FOREIGN KEY (`kode_kereta`) REFERENCES `kereta` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `kode_kereta` varchar(10) NOT NULL,
  `asal` varchar(10) NOT NULL,
  `tujuan` varchar(10) NOT NULL,
  `waktu_berangkat` time NOT NULL,
  `waktu_tiba` time NOT NULL
);

ALTER TABLE `jadwal`
  ADD FOREIGN KEY (`asal`) REFERENCES `stasiun` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD FOREIGN KEY (`tujuan`) REFERENCES `stasiun` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD FOREIGN KEY (`kode_kereta`) REFERENCES `kereta` (`kode`) ON DELETE CASCADE ON UPDATE CASCADE;




CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `kode_booking` varchar(8) NOT NULL
);

ALTER TABLE `pemesanan`
  ADD FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `penumpang` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_pemesanan` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_identitas` varchar(30) NOT NULL,
  `id_gerbong` int(11) NOT NULL,
  `row` varchar(3) NOT NULL,
  `seat` int(3) NOT NULL
);

ALTER TABLE `penumpang`
  ADD FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD FOREIGN KEY (`id_gerbong`) REFERENCES `gerbong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



