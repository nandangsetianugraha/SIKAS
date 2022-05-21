<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$tglawal=$_GET['tglawal'];
$tglakhir=$_GET['tglakhir'];
$sql11="select * from tabungan where tanggal >= '$tglawal' and tanggal <= '$tglakhir'";
$query11 = $connect->query($sql11);
?>
	<div class="table-responsive">
	<table class="table table-bordered" id="laporan">
		<thead>
		   <tr>
				<th>Tanggal</th>
				<th>ID Nasabah</th>
				<th>Nama Nasabah</th>
				<th>Setoran</th>
				<th>Penarikan</th>
			</tr>
		</thead>
		<tbody>	
<?php
while($h=$query11->fetch_assoc()) {
	$idpd=$h['nasabah_id'];
	$namasiswa=$connect->query("select * from nasabah where nasabah_id='$idpd'")->fetch_assoc();
?>
			<tr>
				<td><?=$h['tanggal'];?></td>
				<td><?=$h['nasabah_id'];?></td>
				<td><?=$namasiswa['nama'];?></td>
				<td style="text-align:right;"><?=rupiah($h['masuk']);?></td>
				<td style="text-align:right;"><?=rupiah($h['keluar']);?></td>
			</tr>
<?php 
};

$tot=$connect->query("select sum(masuk) as setoran, sum(keluar) as penarikan from tabungan where tanggal >= '$tglawal' and tanggal <= '$tglakhir'")->fetch_assoc();

?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" rowspan="2" style="text-align:right;">TOTAL</td>
				<td style="text-align:right;"><?=rupiah($tot['setoran']);?></td>
				<td style="text-align:right;"><?=rupiah($tot['penarikan']);?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><?=rupiah($tot['setoran']-$tot['penarikan']);?></td>
			</tr>
		</tfoot>
	</table>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#laporan').DataTable();
	});
</script>
