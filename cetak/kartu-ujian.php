<?php
function TanggalIndo($tanggal)
{
	$bulan = array ('Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1]-1 ] . ' ' . $split[0];
};
use setasign\Fpdi\Fpdi;
include "../modul/qrcode/phpqrcode/qrlib.php";
require_once('fpdf/fpdf.php');
require_once('fpdi2/autoload.php');
include '../function/db_connect.php';
$idp=$_GET['idp'];
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$sqls = "select * from siswa where peserta_didik_id='$idp'";
$querys = $connect->query($sqls);
$siswa=$querys->fetch_assoc();
$kode=$siswa['peserta_didik_id'];
$sqls1 = "select * from penempatan where peserta_didik_id='$kode' and tapel='$tapel' and smt='$smt'";
$querys1 = $connect->query($sqls1);
$rombel=$querys1->fetch_assoc();
$ab=substr($rombel['rombel'],0,1);
if($siswa['jk']==='P'){
	$jk="Perempuan";
}else{
	$jk="Laki-laki";
};
if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/siswa/".$siswa['avatar'])){
		$gbr="../images/siswa/".$siswa['avatar'];
	}else{
	    if($siswa['jk']==='P'){
	       $gbr="../images/user-default.jpg"; 
	    }else{
	       $gbr="../images/user-default.jpg";
	    };
	};
// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
if($ab==='1'){
	$nama='kartu1.pdf';
}elseif($ab==='2' or $ab==='3'){
	$nama='kartu23.pdf';
}elseif($ab==='4'){
	$nama='kartu4.pdf';
}elseif($ab==='5'){
	$nama='kartu5.pdf';
}else{
	$nama='kartu.pdf';
};
$pdf->setSourceFile($nama);
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx,0,0,200);

// now write some text above the imported page
$pdf->SetFont('Helvetica','',10);
//$pdf->SetTextColor(255, 0, 0);
//Nomor Ujian
$pdf->SetXY(40, 23);
$pdf->Write(0, $siswa['nisn']);

//nama
$pdf->SetXY(40, 27.2);
$pdf->Write(0, $siswa['nama']);

//Tempat Tanggal Lahir
$pdf->SetXY(40, 31.4);
$pdf->Write(0, $siswa['tempat'].", ".TanggalIndo($siswa['tanggal']));

//Kelas Ruangan
$pdf->SetXY(40, 35.6);
$pdf->Write(0, $rombel['rombel']);



$tempdir = "../modul/qrcode/temp/";
if (!file_exists($tempdir)){
	mkdir($tempdir);
};
$isi_teks = $siswa['nisn'];
$namafile = $siswa['nisn'].".png";
$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
$padding = 2;
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
$pdf->Image("../modul/qrcode/temp/".$namafile,10,42,20,20);

//TTD
$pdf->Image('ttd.png',40,45,20,20);
//Cap
$pdf->Image('cap.png',30,45,20,20);

$pdf->Output('F','kartu-ujian.pdf');
//$pdf->Output();