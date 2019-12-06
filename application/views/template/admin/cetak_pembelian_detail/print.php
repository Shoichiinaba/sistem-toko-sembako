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
	<title>Laporan Pembelian - <?php echo $tanggal_barang; ?></title>
	<style type="text/css">
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
		}
		.tabel tbody tr td{
			border:1px solid gray;
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
		}.alamat {
			width:100%;
			text-align:center;
		}.alamat span{
			font-size:12px;
		}.user{
			font-weight:bold;
			font-size:12px;
			margin-bottom:9px;
		}
		.sign-container{
			margin-top:60px;
			width:150px;
			display:block;
			margin-left:565px;
		}
		.sign-container .sign{
			height:50px;
		}
	</style>
</head>
<body>
	<span class="tag"><?php echo $tanggal_cetak; ?></span>
	<span class="store"><strong>TOKO ANIS</strong></span>
	<h3 class='header'>Laporan Pembelian Barang - <?php echo $tanggal_barang; ?></h3>
	<hr style="margin:3px;"></hr>
	<div class="alamat">
		<span>Jl.Kaligawe raya, Gembongsari , Semarang. Telp : 08984036667</span>
	</div>
	<div id='container'>
		<div class="user">
			<div>
				<table>
					<tr>
						<td>Oleh</td>
						<td>:</td>
						<td><?php echo $nama;?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td><?php echo $status;?></td>
					</tr>
					<tr>
						<td>Jam</td>
						<td>:</td>
						<td><?php echo $jam;?></td>
					</tr>
				</table>
			</div>
		</div>
		<center>
		<table class='tabel'>
			<thead>
				<tr>
					<th style="width:50px; font-size:14px;">No</th>
					<th style="width:140px; font-size:14px;">Nama Barang</th>
					<th style="width:50px; font-size:14px;">Satuan</th>
					<th style="width:100px; font-size:14px;">Nama Supplier</th>
					<th style="width:120px; font-size:14px;">Alamat Supplier</th>
					<th style="width:100px; font-size:14px;">Telepon</th>
					<th style="width:50px; font-size:14px;">Jumlah</th>
					<th style="width:90px; font-size:14px;">Harga(Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no = 1;
					$total_jumlah = 0;
					$total_harga = 0;
					foreach($data as $result){ ?>
						<tr>
							<td class="center"><?php echo $no; ?></td>
							<td><?php echo $result['nama_barang']; ?></td>
							<td class="center"><?php echo $result['satuan']; ?></td>
							<td class="center"><?php echo $result['nama_supplier']; ?></td>
							<td class="center"><?php echo $result['alamat']; ?></td>
							<td class="center"><?php echo $result['telp']; ?></td>
							<td class="center"><?php echo $result['jumlah']; ?></td>
							<td class="center"><?php echo rupiah($result['harga']); ?></td>
						</tr>
				<?php
						$no++;
						$total_jumlah+=(int) $result['jumlah'];
						$total_harga+=(int) $result['harga'];
					}
				?>
				<tr>
					<td colspan="6">
						<strong>Total Pembelian Barang</strong>
					</td>
					<td class="center">
						<strong><?php echo $total_jumlah; ?></strong>
					</td>
					<td class="center">
						<strong><?php echo rupiah($total_harga); ?></strong>
					</td>
				</tr>
			</tbody>
		</table>
		</center>
		<div class="root-sign">
		<div class="sign-container">
			<center>
				<div class="sign-title"><strong>Penerima/Kasir</strong></div>
				<div class="sign"></div>
				<div class="sign-name">Faiz Irfan Setiawan</div>
			</center>
		</div>
		</div>
	</div>
</body>
</html>