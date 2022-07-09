<?php
require_once '../../function/functions.php';
include '../../function/db_connect.php';

    //menangkap variabel yang diketik oleh user
    $cari   = $_GET['search'];


    //jika tidak ada data yang dicari
    if($cari == null){
        echo "data kosong";
    
    //jika ada data yang dicari
    }else{
        //cari sesuai kata yang diketik
		$sql="SELECT * FROM siswa WHERE nama LIKE '%$cari%' and status=1";
		//$sql1 = "select * from siswa where nama like '%$cari%'";
		$query = $connect->query($sql);
		//$data = $query->fetch_assoc()
        //$data   = mysqli_query($koneksi, "select * from siswa where nama_siswa like '%$cari%'");

        $list = array();
        $key=0;

        //lakukan looping untuk menampilkan data yang sesuai
        while($row = $query->fetch_assoc()) {
			$ids=$row['peserta_didik_id'];
			$siswa=$connect->query("select * from penempatan where peserta_didik_id='$ids' and tapel='$tapel_aktif' and smt='$smt_aktif'")->fetch_assoc();
			$nasabah=$connect->query("select * from nasabah where user_id='$ids'")->fetch_assoc();
			$idpek=$row['pek_ayah'];
			$peker = $connect->query("select * from pekerjaan where id_pekerjaan='$idpek'")->fetch_assoc();
            $list[$key]['text'] = $row['nama']; 
            $list[$key]['id'] = $row['peserta_didik_id'];
			$list[$key]['rmb'] = $siswa['rombel'];
			$list[$key]['nama_ayah'] = $row['nama_ayah'];
			$list[$key]['pek_ayah'] = $peker['nama_pekerjaan'];
			$list[$key]['id_nasabah'] = $nasabah['nasabah_id'];
            $key++;
        }

        //data ditampilkan dalam bentuk json
        echo json_encode($list);
    }