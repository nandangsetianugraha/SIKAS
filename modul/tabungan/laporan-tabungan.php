<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$awal=$_GET['awal'];
$akhir=$_GET['akhir'];
$output = array('data' => array());
$sql = "select * from tabungan where tanggal >= '$awal' and tanggal <= '$akhir'";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idpd=$row['nasabah_id'];
	$namasiswa=$connect->query("select * from nasabah where nasabah_id='$idpd'")->fetch_assoc();
	$output['data'][] = array(
		$row['tanggal'],
		$row['nasabah_id'],
		$namasiswa['nama'],
		rupiah($row['masuk']),
		rupiah($row['keluar'])
	);
}

// database connection close
$connect->close();

echo json_encode($output);