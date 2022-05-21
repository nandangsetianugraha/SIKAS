<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array(), 'nasabahid'=>array());
	$nasabahid=$_GET['nasabahid'];
	if(empty($nasabahid)){
		$validator['success'] = false;
		$validator['messages'] = "Pilih Nasabah";
	}else{
		$sql = "SELECT * FROM nasabah WHERE nasabah_id = '$nasabahid'";
		$query = $connect->query($sql);
		$result = $query->fetch_assoc();
		$validator['success'] = true;
		$validator['messages'] = "Sukses";
		$validator['nasabahid'] = $nasabahid;
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}