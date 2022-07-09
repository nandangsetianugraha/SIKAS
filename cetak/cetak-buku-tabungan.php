<?php
 include 'fpdf/fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';
 include '../function/db_connect.php';
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
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
	
function namahari($tanggal){
    
    //fungsi mencari namahari
    //format $tgl YYYY-MM-DD
    //harviacode.com
    
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);

    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
    
};

	//$idinv=$_GET['idinv'];
	$nasabahid=$_GET['nasabahid'];
	$nasabah=$connect->query("select * from nasabah where nasabah_id='$nasabahid'")->fetch_assoc();
	$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
		$pdf=new exFPDF('P','mm',array(110,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',12);

		$table2=new easyTable($pdf, '{90,20}');
		$table2->rowStyle('min-height:15');
		$table2->easyCell($nasabah['nama'],'valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell($nasabah['nasabah_id'],'valign:M;align:C;font-style:B;border:1');
		$table2->printRow();
		$table2->endTable();
		$pdf->SetFont('helvetica','',8);
		$table2=new easyTable($pdf, '{6,22,5,20,22,22,13}');
		$table2->rowStyle('min-height:5');
		$table2->easyCell('#','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('Tanggal','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('K','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('Setor','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('Ambil','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('Saldo','valign:M;align:C;font-style:B;;border:1');
		$table2->easyCell('Ket.','valign:M;align:C;font-style:B;border:1');
		$table2->printRow(true);
		
		$xd=55;
		$saldo=0;
		for ($x = 1; $x <= $xd; $x++) {
		//	$x=$x+1;
			
			if($x==$xd){
				if($x % 2 == 0){
					$table2->rowStyle('min-height:5');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:L;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					//$saldo=$saldo+($h['masuk']-$h['keluar']);
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;border:LRB');
					$table2->printRow();
				}else{
					$table2->rowStyle('min-height:5;bgcolor:#E6E6E6');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:L;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					//$saldo=$saldo+($h['masuk']-$h['keluar']);
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:LB');
					$table2->easyCell('','valign:M;align:R;font-style:B;border:LRB');
					$table2->printRow();
				}					
			}else{
				if($x % 2 == 0){
					$table2->rowStyle('min-height:5');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:L;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					//$saldo=$saldo+($h['masuk']-$h['keluar']);
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;border:LR');
					$table2->printRow();
				}else{
					$table2->rowStyle('min-height:5;bgcolor:#E6E6E6');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:L;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:C;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					//$saldo=$saldo+($h['masuk']-$h['keluar']);
					$table2->easyCell('','valign:M;align:R;font-style:B;;border:L');
					$table2->easyCell('','valign:M;align:R;font-style:B;border:LR');
					$table2->printRow();
				}
			};
		};
		$table2->endTable();
		
		
		
		
		
			$pdf->Output('F','cetak-buku-tabungan.pdf');
			//$pdf->Output('D',$namafilenya);
		 


 

?>