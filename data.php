<?php 

// Koneksi Data base
$konek = mysqli_connect("localhost","id17426864_root","Kevins12319!","id17426864_websensor");
//Baca data dari tabel pada database

$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM tb_sensor");
//tanggap data
$data_ID = mysqli_fetch_array($sql_ID) ;
// ambil data id terbesar
$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal = $ID_akhir - 4 ;

//Baca informasi 5  data terakhir

$tanggal = mysqli_query($konek, "SELECT tanggal FROM tb_sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir ' ORDER BY ID ASC");
// Baca informasi suhu 5 data terakhir
$suhu = mysqli_query($konek, "SELECT suhu FROM tb_sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC");
 ?>
