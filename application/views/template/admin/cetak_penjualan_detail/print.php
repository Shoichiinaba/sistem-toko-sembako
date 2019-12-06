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
	<title>Laporan Penjualan - <?php echo $tanggal_penjualan; ?></title>
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
			font-weight:bold;
			font-size:12px;
			margin-bottom:9px;
		}
	</style>
</head>
<body>
	<span class="tag"><?php echo $tanggal_cetak; ?></span>
	<span class="store"><strong>TOKO ANIS</strong></span>
	<h3 class='header'>Laporan Penjualan Barang - <?php echo $tanggal_penjualan; ?></h3>
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
		<table class='tabel'>
			<thead>
				<tr>
                  <th style="font-size:14px;">No Penjualan</th>
                  <th style="font-size:14px;">Customer</th>
				  <th style="font-size:14px;">Nama Barang</th>
                  <th style="font-size:14px;">Satuan</th>
				  <th style="font-size:14px;">Jumlah</th>
				  <th style="font-size:14px;">Harga Satuan(Rp)</th>
				  <th style="font-size:14px;">Total Harga(Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total_jumlah = 0;
				$total_harga = 0;
				$no = 0;
                foreach ($data['data'] as $key) {
					$total_jumlah = $total_jumlah + (int) $key['jumlah'];
					$total_harga = $total_harga + (int) $key['harga'];
					$no++;
                  ?>
                  <tr>
                    <td style=""><center><?php echo $key['id'];?></center></td>
					<td style=""><?php echo $key['customer'];?></td>
                    <td><?php echo $key['nama_barang'];?></td>
                    <td><center><?php echo $key['satuan'];?></center></td>
					<td><center><?php echo $key['jumlah'];?></center></td>
					<td><center><?php echo rupiah($key['harga_jual']);?></center></td>
					<td><center><?php echo rupiah($key['harga']);?></center></td>
                  </tr>
                  <?php } ?>
				  <tr>
					<td colspan="6"><strong>Total Jumlah Item</strong></td>
					<td><center><strong><?php echo $total_jumlah; ?></strong></center></td>
				  </tr>
				  <tr>
					<td colspan="6"><strong>Total Jumlah Harga(Rp)</strong></td>
					<td><center><strong><?php echo rupiah($total_harga); ?></strong></center></td>
				  </tr>
			</tbody>
		</table>
	</div>
</body>
</html>