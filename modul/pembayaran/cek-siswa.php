<?php

include "../../function/db.php";
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$idpd = $_POST['idpd'];
//$password = $_POST['password'];
$query			= mysqli_fetch_array(mysqli_query($koneksi, 'SELECT * FROM siswa WHERE peserta_didik_id = "'.$idpd.'"')); // Check the table 
if($idpd === $query['peserta_didik_id']){
	$idp=$query['peserta_didik_id'];
	$kelas=mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM penempatan WHERE peserta_didik_id = '$idp' and tapel='$tapel_aktif' and smt='$smt_aktif'"));
	$rombel="Kelas ".$kelas['rombel'];
	$filegbr = 'https://sdi-aljannah.web.id/apins/images/siswa/'.$query['avatar'];
	$file_headerss = @get_headers($filegbr);
	if($file_headerss[0] == 'HTTP/1.1 404 Not Found') {
		//$exists = false;
		$gbr="https://sdi-aljannah.web.id/sikas/assets/img/users/user-1.png";
	}else {
		//$exists = true;
		$gbr='https://sdi-aljannah.web.id/apins/images/siswa/'.$query['avatar'];
	};
	$gambar="<img alt='image' src='".$gbr."' class='rounded-circle author-box-picture'>";
    $response = array("status"=>"ada_nasabah","namaLengkap"=>$query['nama'],"kelas"=>$rombel,"gambar"=>$gambar);
}else{
	$gambar="<img alt='image' src='https://sdi-aljannah.web.id/sikas/assets/img/users/user-1.png' class='rounded-circle author-box-picture'>";
    $response = array("status"=>"no_nasabah","kelas"=>"","gambar"=>$gambar);
};
echo json_encode($response);