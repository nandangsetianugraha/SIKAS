<?php 

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$output = array('success' => false, 'nomor' => array());

$memberId = $_POST['member_id'];
$sql = "SELECT * FROM tabungan WHERE nasabah_id = '$memberId'";
$ceks = $connect->query($sql)->num_rows;
if($ceks > 0) {
	$output['success'] = true;
	$output['nomor'] = $ceks;
} else {
	$output['success'] = false;
	$output['nomor'] = 1;
}

// close database connection
$connect->close();

echo json_encode($output);