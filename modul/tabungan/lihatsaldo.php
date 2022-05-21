<?php
include '../../function/db.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
if (isset($_POST['search'])) {
  $search = $_POST['search'];
  $query = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE nasabah_id='".$search."' order by tanggal asc");
  $saldo=0;
  $cek=mysqli_num_rows($query);
  if($cek>0){
  $query = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE nasabah_id='".$search."' order by tanggal asc");
  while ($row = mysqli_fetch_array($query)) {
	  $debet=$row['masuk'];
	  $kredit=$row['keluar'];
	  $saldo=$saldo+$debet-$kredit;
	  $idin=$row['id'];
 ?>
<tr>
  <td><?= $row['tanggal']; ?></td>
  <td><?= $row['kode']; ?></td>
  <td><?= rupiah($debet); ?></td>
  <td><?= rupiah($kredit); ?></td>
  <td><?= rupiah($saldo); ?><button class="btn btn-sm btn-icon btn-primary" data-idsaldo="<?=$saldo;?>" data-idinv="<?=$idin;?>" id="printinv"><i class="fas fa-print"></i></button></td>
</tr>
<?php }
}else{
?>
<tr>
  <td colspan="5"><center>Belum Ada Data</center></td>
</tr>
<?php }}; ?>