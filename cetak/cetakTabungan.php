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

require_once('fpdf/fpdf.php');
require_once('fpdi2/autoload.php');
include '../function/db_connect.php';
$idp=$_GET['nasabahid'];
$sqls = "select * from nasabah where nasabah_id='$idp'";
$querys = $connect->query($sqls);
$siswa=$querys->fetch_assoc();

// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('cover-tabungan.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx,0,0,215);

// now write some text above the imported page
$pdf->SetFont('Times','',40);
//$pdf->SetTextColor(255, 0, 0);
//Nomor NISN
$pdf->SetXY(115, 133);
$pdf->Write(0, $siswa['nasabah_id']);
$pdf->SetFont('Courier','',25);
//Nama
$pdf->SetXY(85, 145);
$pdf->MultiCell(100,10,$siswa['nama'],0,'C');
/**
if(strlen($siswa['nama'])>18){
	$pdf->SetXY(85, 145);
	$pdf->MultiCell(100,10,$siswa['nama'],'C');
	//$pdf->Write(0, substr($siswa['nama'],0,17));
	//$pdf->SetXY(85, 155);
	//$pdf->Write(0, substr($siswa['nama'],17,strlen($siswa['nama'])));
}else{
	$pdf->SetXY(85, 145);
	$pdf->Write(0, $siswa['nama']);
}
**/
$pdf->Output('F','cetak-cover-tabungan.pdf');
//$pdf->Output();