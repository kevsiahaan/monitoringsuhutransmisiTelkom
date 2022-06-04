<?php 
// Koneksi Data base
$konek = mysqli_connect("localhost","id17426864_root","Kevins12319!","id17426864_websensor");

// tangkap parameter yg ada pada nodemcu
$suhu = $_GET['suhu'];
 
//Simpan ke tabel tb_sensor
// atur ID selalu dimulai dari 1
mysqli_query($konek, "ALTER TABLE tb_sensor AUTO_INCREMENT= 1");
//simpan nilai suhu ke tb_sensor
$simpan = mysqli_query($konek, "INSERT INTO tb_sensor(suhu)VALUES('$suhu')");

// berikan respon ke nodemcu
if($simpan)
	echo "Berhasil disimpan";
else 
	echo "Tidak Berhasil di simpan";

 ?>