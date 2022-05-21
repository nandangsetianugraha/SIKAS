<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Laporan Tabungan';
//view('template/head', $data);
include "../template/head.php";
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "../template/top-navbar.php"; ?>
	  <div class="main-sidebar sidebar-style-2">
		<?php 
		include "../template/sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Laporan Tabungan</h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" id="cetaklaporan"><i class="fas fa-print"></i> Cetak</button>
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
										<input type="text" class="form-control datepicker" name="tanggal1" id="tanggal1">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<input type="text" class="form-control datepicker" name="tanggal2" id="tanggal2">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-default">
										<button class="btn btn-primary mr-1" type="button" id="getLaporan">Submit</button>
									</div>
								</div>
							</div> <!--Akhir Row-->
					  <div id="tabel-laporan">
						
					  </div>
						<div class="table-responsive">
							<table id="TabunganTable" class="display table">
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
																			
								</tbody>
							</table>
						</div>
					</div>
				  </div>
				</div>
				
			</div>
          </div>
        </section>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  
  <script>
  var SPPku;
  $(document).ready(function() {
	  var awal=$('#tanggal1').val();
	  var akhir=$('#tanggal2').val();
	  SPPku = $('#TabunganTable').DataTable( {
			"destroy":true,
			"searching": false,
			"paging":true,
			"ajax": "../modul/tabungan/laporan-tabungan.php?awal="+awal+"&akhir="+akhir,
			"order": []
		} );
		function viewTr(){
				$.get("../modul/tabungan/laporan-transaksi.php?awal="+awal+"&akhir="+akhir, function(data) {
					$("#tabel-laporan").html(data);
				});
		};
		viewTr();
	  $(document).on('click', '#getLaporan', function(e){
		
			e.preventDefault();
			
			var tglawal=$('#tanggal1').val();
			var tglakhir=$('#tanggal2').val();
			SPPku = $('#TabunganTable').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":true,
				"ajax": "../modul/tabungan/laporan-tabungan.php?awal="+tglawal+"&akhir="+tglakhir,
				"order": []
			} );
			function viewTr(){
				$.get("../modul/tabungan/laporan-transaksi.php?awal="+tglawal+"&akhir="+tglakhir, function(data) {
					$("#tabel-laporan").html(data);
				});
			};
			viewTr();
			
		});
		$(document).on('click', '#cetaklaporan', function(e){
		
			e.preventDefault();
			var tglawal=$('#tanggal1').val();
			var tglakhir=$('#tanggal2').val();
			var tapel=$('#tapel').val();
			PopupCenter('../cetak/cetak-laporan-tabungan.php?tglawal='+tglawal+'&tglakhir='+tglakhir+'&tapel='+tapel, 'Cetak Laporan Tabungan',800,800);
			
		});
  });
  function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
  </script>
</body>
</html>