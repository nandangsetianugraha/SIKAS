<?php 

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$awal=$_GET['awal'];
	$akhir=$_GET['akhir'];
	//
	//$tanggal=substr($_GET['tglbro'], 6, 4)."-".substr($_GET['tglbro'], 0, 2)."-".substr($_GET['tglbro'], 3, 2);
	if(empty($awal) || empty($akhir)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
		
		$validator['success'] = true;
		$validator['messages'] = "Sukses";
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}