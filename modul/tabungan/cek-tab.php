<?php

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$validator = array('success' => false, 'messages' => array());
$siswa = $_GET['siswa'];
$sql = "select * from nasabah where user_id='$siswa'";
$query = $connect->query($sql);
$cks = $query->fetch_assoc();
//$password = $_POST['password'];
//$query			= mysqli_fetch_array(mysqli_query($koneksi, 'SELECT * FROM nasabah WHERE user_id = "'.$siswa.'"')); // Check the table 
$idNasabah = $cks['nasabah_id'];
$setor=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE nasabah_id = '$idNasabah'")->fetch_assoc();
$ambil=$connect->query("SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idNasabah'")->fetch_assoc();
//$setor=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE nasabah_id = '$idNasabah'"));
//$ambil=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idNasabah'"));
$saldo=$setor['setoran']-$ambil['penarikan'];
$validator['success'] = false;
$validator['messages'] = rupiah($saldo);

echo json_encode($validator);