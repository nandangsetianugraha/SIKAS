<?php
	header('Content-Type: application/json; charset=utf8');

	$server = "127.0.0.1";
	$user 	= "root";
	$pass 	= "";
	$dbname = "apins";
	//koneksi ke database db_country
	$conn = mysqli_connect($server, $user, $pass, $dbname);

	if(!$conn){
		die("Connection Failed: " .mysqli_connect_error());
	}
	$term = trim(strip_tags($_GET['term']));
	//query untuk menampilkan data dari tabel country
	$query = mysqli_query($conn, "SELECT * FROM siswa WHERE  nama LIKE '%$term%' ");

	$array=array();
	//looping data
	while($data=mysqli_fetch_assoc($query)){	
    	$row['value']=$data['nama'];
		//buat array yang nantinya akan di konversi ke json
    	array_push($array, $row);
    }

	//mengubah data object menjadi data json
	echo json_encode($array);
?>