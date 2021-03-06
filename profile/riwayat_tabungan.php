<?php 
	include('../db_con.php');

	if (isset($_SESSION['s_user_id']))
{
	$id_user = $_SESSION['s_user_id'];
	$query2 = "SELECT * FROM log_tabungan WHERE status='sudah_diverifikasi' AND id_user='$id_user'";
	$results2 = mysqli_query($db, $query2) or die (mysqli_error());
	$lenght2=mysqli_num_rows($results2);


	$query3 = "SELECT * FROM log_tabungan WHERE status='belum_diverifikasi' AND id_user='$id_user'";
	$results3 = mysqli_query($db, $query3) or die (mysqli_error());
	$lenght3=mysqli_num_rows($results3);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Riwayat Transaksi Tabungan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="icon" href="favicon/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="favicon/favicon.ico" type="image/x-icon"/>
	<meta name="theme-color" content="#4AB616">
	<script type="text/javascript" src="../partials/jquery-3.2.1.min.js"></script>
	<?php include('../partials/css.php'); ?>
	<link href="../admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
<?php include('../partials/navbar.php'); ?>
<section>
	<div class="container mt-0 mt-md-3 mt-lg-3">
		<div class="row">
			<?php include ('nav-l.php'); ?>
			<div class="col-lg-8 col-sm-12 px-0 px-sm-0 px-md-0 px-lg-3 px-xl-3">
	        	<section>
					<div class="card">
						<div class="card-header">
							<div class="row">
							<div class="col d-flex">
									<h5 class="mb-0 font-weight-bold">Riwayat Transaksi Tabungan</h5>
							</div>
							<div class="col-auto">
								<a class="btn btn-sm btn-color m-0" href="index.php" >Kembail</a>
							</div>
						</div>
						</div>
						<div class="card-body p-0">
							<ul class="nav nav-tabs grey lighten-3 border-0" id="myTab" role="tablist">
							  <li class="nav-item">
							    <a class="nav-link font-color active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
							      aria-selected="true"><i class="fa fa-times-circle"></i> Belum Di Konfirmasi</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link font-color" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
							      aria-selected="false"><i class="fa fa-history"></i> Riwayat Transaksi</a>
							  </li>
							</ul>
								<div class="tab-content p-3" style="width:100%" id="myTabContent"> <!-- myTabContent -->
									<!-- /////////////////////////// riwayat belum terverifikasi /////////////////////////// -->
									<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<?php if($lenght2 > 0){ ?>
									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
											<thead>
												<tr style="text-align:center">
													<th>No</th>
													<th>Tanggal Transaksi</th>
													<th>Jumlah Transaksi</th>
													<th>Jenis Transaksi</th>
													<th>Jenis Pembayaran</th>
												</tr>
											</thead>
											<tfoot>
												<tr style="text-align:center">
													<th>No</th>
													<th>Tanggal Transaksi</th>
													<th>Jumlah Transaksi</th>
													<th>Jenis Transaksi</th>
													<th>Jenis Pembayaran</th>
												</tr>
											</tfoot>
											<tbody>
												<?php	$no=1;
												while ($row2=mysqli_fetch_array($results2))
												{ 
														$totaltabungan = $row2['jumlah_transaksi_beras'];
														if (strpos($totaltabungan, '.') !== false) {
															$b=strstr($totaltabungan, '.', true);
															$removecoma = str_replace('.', '', $b );
															$takedecimal =  substr($totaltabungan, strpos($totaltabungan, ".") + 1); 
														}
														else
														{
															$removecoma = $totaltabungan;
															$takedecimal = null;
														}
														$hasil_rupiah = number_format($removecoma,0,'','.');
														if (strpos($totaltabungan, '.') !== false) {
															$finaltotalsaldo=$hasil_rupiah.",".$takedecimal."  Kg";
														}
														else
														{
															$finaltotalsaldo=$hasil_rupiah."  Kg";
														}
															// echo("<script>console.log('PHP: " . $finaltotalsaldo . "');</script>");

													?>
													<tr>
														<td style="text-align:center" ><?php echo $no++;?></td>
														<td><?php echo $row2['tanggal_transaksi'] ?></td>
														<td><?php echo $finaltotalsaldo?></td>
														<td><?php echo $row2['jenis_transaksi'] ?></td>
														<td><?php echo $row2['jenis_pembayaran'] ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<?php } else {?>
										<div class="card-body text-center">
											<img width="100" src="https://image.flaticon.com/icons/svg/1634/1634836.svg">
											<h5 class="m-0 mt-3" >Anda belum melakukan transaksi apapun</h5>
										</div>
									<?php } ?>	
									</div>
									<!-- /////////////////////////// riwayat terverifikasi /////////////////////////// -->
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<?php if($lenght3 > 0){ ?>
									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
											<thead>
												<tr style="text-align:center">
													<th>No</th>
													<th>Tanggal Transaksi</th>
													<th>Jumlah Transaksi</th>
													<th>Jenis Transaksi</th>
													<th>Jenis Pembayaran</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tfoot>
												<tr style="text-align:center">
													<th>No</th>
													<th>Tanggal Transaksi</th>
													<th>Jumlah Transaksi</th>
													<th>Jenis Transaksi</th>
													<th>Jenis Pembayaran</th>
													<th>Aksi</th>
												</tr>
											</tfoot>
											<tbody>
												<?php	$no2=1;
												while ($row3=mysqli_fetch_array($results3))
												{ 
													$totaltabungan = $row3['jumlah_transaksi_beras'];
													if (strpos($totaltabungan, '.') !== false) {
														$b=strstr($totaltabungan, '.', true);
														$removecoma = str_replace('.', '', $b );
														$takedecimal =  substr($totaltabungan, strpos($totaltabungan, ".") + 1); 
													}
													else
													{
														$removecoma = $totaltabungan;
														$takedecimal = null;
													}
													$hasil_rupiah = number_format($removecoma,0,'','.');
													if (strpos($totaltabungan, '.') !== false) {
														$finaltotalsaldo=$hasil_rupiah.",".$takedecimal."  Kg";
													}
													else
													{
														$finaltotalsaldo=$hasil_rupiah."  Kg";
													}
													?>
													<tr>
														<td style="text-align:center" ><?php echo $no2++;?></td>
														<td><?php echo $row3['tanggal_transaksi'] ?></td>
														<td><?php echo $finaltotalsaldo ?></td>
														<td><?php echo $row3['jenis_transaksi'] ?></td>
														<td><?php echo $row3['jenis_pembayaran'] ?></td>
														<td>
															<form action="proses_pengaturan.php" method="POST">
																<input type="hidden" name="iduser" value="<?php echo $id_user ?>" type="text" /> <!-- hidden -->
																<button class="btn btn-sm btn-danger m-0" name="hapus_transaksi_tabungan" value="<?php echo $row3['id_transaksi'];?>"  onclick="return confirm('apakah anda yakin akan membatalkan transaksi ini ?')">Batalkan</button></td>
															</form>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<?php } else {?>
										<div class="card-body text-center">
											<img width="100" src="https://image.flaticon.com/icons/svg/1634/1634836.svg">
											<h5 class="m-0 mt-3">Tidak ada transaksi yang belum diverifikasi</h5>
										</div>
									<?php } ?>			
									</div>
							</div><!-- myTabContent -->
						</div>
					</div>
		        </section>
			</div>
		</div>
	</div>
</section>
<?php include('../partials/footer.php'); ?>
<?php include('../partials/js.php'); ?>
<script src="../admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
  $('#dataTable2').DataTable();
});
</script>
<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script>
//the maps api is setup above
window.onload = function() {
    var latlng = new google.maps.LatLng(-7.0491487,110.3925141); //Set the default location of map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 16, //The zoom value for map
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        draggable: false //this makes it drag and drop
    });
	var infowindow = new google.maps.InfoWindow({
	content: contentString
	});

	marker.addListener('click', function() {
	infowindow.open(map, marker);
	});
};




// $(window).on('popstate', function(event) {

// 	 	location.href=index.php;
// 	console.log("fuck");

// });

window.onbeforeunload = function() {console.log("fuck"); };

</script>
</body>
</html> ?>

<?php 
}
else
{
	header('Location:../login/index.php') ;
}
?>
