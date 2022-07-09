<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Nasabah';
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
							<h4>Daftar Nasabah</h4>
							<?php $jprinter=mysqli_fetch_array(mysqli_query($koneksi, "select * from printer where status='1'")); ?>
							<input type="hidden" name="lstPrinters" id="lstPrinters" value="<?=$jprinter['nama'];?>" />
							<input type="hidden" name="lstPrinterTrays" id="lstPrinterTrays" value="" />
							<div class="card-header-form">
								<a href="#" data-toggle="modal" data-toggle="modal" data-target="#NSiswa" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-plus"></i> Siswa</a>
								<a href="#" data-toggle="modal" data-toggle="modal" data-target="#NGuru" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-plus"></i> Guru</a>
								<a href="#" data-toggle="modal" data-toggle="modal" data-target="#NLainnya" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-plus"></i> Lainnya</a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="manageMemberTable" class="table table-striped">
									<thead>
										<tr>
											<th class="text-center">ID Nasabah</th>
											<th class="text-center">Nama Nasabah</th>
											<th class="text-center">Saldo</th>
											<th class="text-center">Jenis Nasabah</th>
											<th>&nbsp;</th>
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
		<div class="modal fade" id="NSiswa">
	        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nasabah Siswa</h4>
              </div>
                        <form class="form" action="../modul/nasabah/simpansiswa.php" method="POST" id="siswaForm">
						<div class="modal-body">
							<div class="form-group">
								<label for="output-device">ID Nasabah</label>
								<input type="text" class="form-control" id="idNasabah" name="idNasabah" placeholder="ID Nasabah" autocomplete=off>
							</div>
							<div class="form-group">
								<label for="output-device">Pilih Siswa</label>
								<select id="idsis" class="form-control  selectsiswa" style="width: 100%;" name="idsis">
									<option>Pilih Siswa</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from siswa where status=1 order by nama asc");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?php echo $nk['peserta_didik_id']; ?>"><?=$nk['nama']; ?></option>
									<?php };?>
								</select>
							</div>
                        </div>
                        <div class="modal-footer siswaModal">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                        </div>
						</form>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
		<div class="modal fade" id="NGuru">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nasabah Guru</h4>
              </div>
                        <form class="form" action="../modul/nasabah/simpanguru.php" method="POST" id="guruForm">
						<div class="modal-body">
							<div class="form-group">
								<label for="output-device">ID Nasabah</label>
								<input type="text" class="form-control" id="idNasabah" name="idNasabah" placeholder="ID Nasabah" autocomplete=off>
							</div>
							<div class="form-group">
								<label for="output-device">Pilih Guru</label>
								<select id="idsis" class="form-control selectguru" style="width: 100%;" name="idsis">
									<option>Pilih Guru</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from ptk where status_keaktifan_id=1 order by nama asc");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?php echo $nk['ptk_id']; ?>"><?=$nk['nama']; ?></option>
									<?php };?>
								</select>
							</div>
                        </div>
                        <div class="modal-footer ptkModal">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                        </div>
						</form>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
		<div class="modal fade" id="NLainnya">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nasabah Lainnya</h4>
              </div>
                        <form class="form" action="../modul/nasabah/simpanlain.php" method="POST" id="lainForm">
						<div class="modal-body">
							<div class="form-group">
								<label for="output-device">ID Nasabah</label>
								<input type="text" class="form-control" id="idNasabah" name="idNasabah" placeholder="ID Nasabah" autocomplete=off>
							</div>
							<div class="form-group">
								<label for="output-device">Nama Nasabah</label>
								<input type="text" class="form-control" id="idsis" name="idsis" placeholder="Nama Nasabah" autocomplete=off>
							</div>
                        </div>
                        <div class="modal-footer ptkModal">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                        </div>
						</form>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
		<div class="modal fade" id="hapusData">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus Data Nasabah</h4>
              </div>
                        <div class="modal-body">
							<p>Hapus Data Nasabah?<br/>Jika Nasabah Dihapus, Otomatis semua transaksi yang berhubungan akan dihapus juga.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light" id="outBtn">Ya</button>
                        </div>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="<?= base_url(); ?>assets/js/zip-full.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/JSPrintManager.js"></script>
  <script src="<?= base_url(); ?>assets/js/bluebird.min.js"></script>
  <script>
	var clientPrinters = null;
    var _this = this;

    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();

    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
	
	function printTabungan() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['tabungan'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/cetak-buku-tabungan.pdf", JSPM.FileSourceType.URL, 'cetak-buku-tabungan.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    }
	
	function printCoverTabungan() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['kwitansi'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/cetak-cover-tabungan2.pdf", JSPM.FileSourceType.URL, 'cetak-cover-tabungan2.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    }
	var manageMemberTable;
	var managePenempatan;
	$(document).ready(function() {
		manageMemberTable = $("#manageMemberTable").DataTable({
			"destroy":true,
			"searching": true,
			"paging":true,
			"ajax": "../modul/nasabah/nasabah.php",
			"order": []
		});
		$("#siswaForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 1000,});
										// reload the datatables
										$("#siswaForm")[0].reset();
										$('#idsis').val(null).trigger('change');
										$("#NSiswa").modal('hide');
										manageMemberTable.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
									} else {
										swal(response.messages, {buttons: false,timer: 1000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
			$("#guruForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 1000,});
										// reload the datatables
										$("#guruForm")[0].reset();
										$('#idsis').val(null).trigger('change');
										$("#NGuru").modal('hide');
										manageMemberTable.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
									} else {
										swal(response.messages, {buttons: false,timer: 1000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
			
			$("#lainForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 1000,});
										// reload the datatables
										$("#lainForm")[0].reset();
										$("#NLainnya").modal('hide');
										manageMemberTable.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
									} else {
										swal(response.messages, {buttons: false,timer: 1000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		$(document).on('click', '#getBlanko', function(e){
			e.preventDefault();
			var nasabahid = $(this).data('nasabah');
			$.ajax({
				type : 'GET',
				url : '../modul/nasabah/cek-kartu.php',
				data :  'nasabahid='+nasabahid,
				dataType: 'json',
				success: function (data) {
					if(data.success===true){
						swal({
							title: 'Cetak Tabungan',
							text: 'Cetak Buku Tabungan?',
							icon: 'success',
							buttons: ["Batal", "Cetak"],
							dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) {
								$.ajax({
									type : 'GET',
									url : '../cetak/cetak-buku-tabungan.php',
									data :  'nasabahid='+data.nasabahid,
									success: function (response) {
										printTabungan();												
									}
								});
						  } else {
							
						  }
						});
					}else{
						swal(data.messages, {buttons: false,timer: 500,});
					}				
				}
			});
		});
		
		$(document).on('click', '#getCover', function(e){
			e.preventDefault();
			var nasabahid = $(this).data('nasabah');
			$.ajax({
				type : 'GET',
				url : '../modul/nasabah/cek-cover.php',
				data :  'nasabahid='+nasabahid,
				dataType: 'json',
				success: function (data) {
					if(data.success===true){
						swal({
							title: 'Cetak Cover Tabungan',
							text: 'Cetak Cover Tabungan?',
							icon: 'success',
							buttons: ["Batal", "Cetak"],
							dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) {
								$.ajax({
									type : 'GET',
									url : '../cetak/cetakTabungan.php',
									data :  'nasabahid='+data.nasabahid,
									success: function (response) {
										printCoverTabungan();												
									}
								});
						  } else {
							
						  }
						});
					}else{
						swal(data.messages, {buttons: false,timer: 500,});
					}				
				}
			});
		});
		
	});
	function outMember(id = null) {
		if(id) {
			// click on remove button
			$("#outBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/nasabah/hapusnasabah.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 1000,});

							// refresh the table
							manageMemberTable.ajax.reload(null, false);

							// close the modal
							$("#hapusData").modal('hide');

						} else {
							swal(response.messages, {buttons: false,timer: 1000,});
						}
					}
				});
			}); // click remove btn
		} else {
			swal('Error: Refresh the page again', {buttons: false,timer: 1000,});
		};
		
		
	}
	function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
  </script>
</body>
</html>