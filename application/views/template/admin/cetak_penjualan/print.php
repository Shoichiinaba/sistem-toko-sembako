<?php
	// var_dump($result);
	function rupiah($angka){
		$result = "".number_format($angka, 2, ',', '.');
		return $result;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Struk Penjualan</title>
	<style type="text/css">
		body{
			font-family:arial, 'Times-serif';
		}
		#container{
			display: block;
		}
		.tabel{
			border-collapse: collapse;
			font-family: arial;
			width:100%;
		}
		.tabel thead tr th{
			border:1px solid gray;
			height: 30px;
			background-color:rgb(233, 234, 252);
		}
		.tabel tbody tr td{
			border:1px solid gray;
			font-size:15px;
			height:25px;
		}
		.center{
			text-align: center;
		}
		.header{
			text-align: center;
			margin-top:5px;
			margin-bottom:9px;
		}
		.store{
			text-align:center;
			display:block;
			font-size:20px;
			font-family:arial;
			color:rgb(60, 141, 188);
		}
		.tag{
			text-align:right;
			display:block;
			font-family:arial;
			font-size:10px;
		}
		.deskripsi{
			width:100%;
		}.deskripsi tr td{
			height:12px;
		}
		.alamat {
			width:100%;
			text-align:center;
		}.alamat span{
			font-size:12px;
		}
		.user{
			font-size:15px;
			margin-bottom:9px;
		}
	</style>
</head>
<body>
	<span class="store"><strong>TOKO ANIS</strong></span>
	<h3 class='header'>Nota Penjualan</h3>
	<hr style="margin:3px;"></hr>
	<div class="alamat">
		<span>Jl.Kaligawe raya, Gembongsari , Semarang. Telp : 08984036667</span>
	</div>
	<div id='container'>
		<div class="user">
			<div style="margin-top:20px;">
				<table>
					<tr>
						<td style="width:12%;"><strong>No Nota</strong></td>
						<td style="width:2%;">:</td>
						<td><?php echo $nota;?></td>
					</tr>
					<tr>
						<td><strong>Customer</strong></td>
						<td>:</td>
						<td><?php echo $customer;?></td>
					</tr>
					<tr>
						<td><strong>Tanggal</strong></td>
						<td>:</td>
						<td><?php echo $tanggal;?>  <?php echo $jam;?></td>
					</tr>
					<tr>
						<td><strong>Kasir</strong></td>
						<td>:</td>
						<td><?php echo $nama;?></td>
					</tr>
				</table>
			</div>
		</div>
		<table class='tabel'>
			<thead>
				<tr>
                  <th style="font-size:14px;">No</th>
				  <th style="font-size:14px;">Nama Barang</th>
                  <th style="font-size:14px;">Satuan</th>
				  <th style="font-size:14px;">Jumlah</th>
				  <th style="font-size:14px;">Harga</th>
				  <th style="font-size:14px;">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1; 
				$total_harga = 0;
				?>
				<?php foreach($data as $value) {?>
					<tr>
						<td><center><?php echo $no; ?></center></td>
						<td><?php echo $value['nama_barang']; ?></td>
						<td><center><?php echo $value['satuan']; ?></center></td>
						<td><center><?php echo $value['jumlah']; ?></center></td>
						<td><center><?php echo rupiah($value['harga_jual']); ?></center></td>
						<td><center><?php echo rupiah($value['harga']); ?></center></td>
					</tr>
				<?php 
				
					$no++;
					$total_harga+=$value['harga'];
				} ?>
				<tr>
					<td colspan="5"><strong>Total (Rp)</strong></td>
					<td><center><strong><?php echo rupiah($total_harga); ?></strong></center></td>
				</tr>
				<tr>
					<td colspan="5"><strong>Bayar (Rp)</strong></td>
					<td><center><strong><?php echo rupiah($bayar); ?></strong></center></td>
				</tr>
				<tr>
					<td colspan="5"><strong>Kembalian (Rp)</strong></td>
					<td><center><strong><?php echo rupiah( ($bayar - $total_harga) ); ?></strong></center></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>