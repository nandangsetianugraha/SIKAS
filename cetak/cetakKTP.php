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
 include 'fpdf/fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';
 include '../function/db_connect.php';
 $pdf=new exFPDF('P','mm','A4');
 $pdf->AddPage(); 
 $pdf->SetFont('helvetica','',10);

 $table1=new easyTable($pdf, '{15,65,15,2,15,65,15}');
 $table1->easyCell('', 'img:logo.jpg, align:C;valign:M;border:LTB');
 $table1->easyCell("KARTU TANDA PESERTA PENILAIAN AKHIR SEMESTER (PAS) TAHUN AJARAN 2021/2022", 'valign:M;align:C;font-size:10;font-style:B;paddingY:0.3;border:TB');
 $table1->easyCell('', 'img:151601001.png, align:C;valign:M;border:TBR');
 $table1->easyCell('', 'align:C;valign:M');
 $table1->easyCell('', 'img:logo.jpg, align:C;valign:M;border:LTB');
 $table1->easyCell("KARTU TANDA PESERTA PENILAIAN AKHIR SEMESTER (PAS) TAHUN AJARAN 2021/2022", 'valign:M;align:C;font-size:10;font-style:B;paddingY:0.3;border:TB');
 $table1->easyCell('', 'img:151601001.png, align:C;valign:M;border:TBR');
 $table1->printRow();
 $table1->endTable();
 
 $table1=new easyTable($pdf, '{15,65,15,2,15,65,15}');
 $table1->easyCell('', 'img:logo.jpg, align:C;valign:M;border:LTB');
 $table1->easyCell("KARTU TANDA PESERTA PENILAIAN AKHIR SEMESTER (PAS) TAHUN AJARAN 2021/2022", 'valign:M;align:C;font-size:10;font-style:B;paddingY:0.3;border:TB');
 $table1->easyCell('', 'img:151601001.png, align:C;valign:M;border:TBR');
 $table1->easyCell('', 'align:C;valign:M');
 $table1->easyCell('', 'img:logo.jpg, align:C;valign:M;border:LTB');
 $table1->easyCell("KARTU TANDA PESERTA PENILAIAN AKHIR SEMESTER (PAS) TAHUN AJARAN 2021/2022", 'valign:M;align:C;font-size:10;font-style:B;paddingY:0.3;border:TB');
 $table1->easyCell('', 'img:151601001.png, align:C;valign:M;border:TBR');
 $table1->printRow();
 $table1->endTable();

 $pdf->Output(); 


 

?>