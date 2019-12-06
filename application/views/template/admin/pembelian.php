  <!-- UNTUK PEMBELIAN BARANG -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-shopping-cart"></i>
        Pembelian
		<small>Form pembelian barang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i>Pembelian</a></li>
      </ol>
    </section>
    <section class="content">
	<?php if(isset($alert)) { ?>
	<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>Sukses !</h4>
                Data pembelian sudah berhasil tersimpan.
    </div>
	<?php } ?>
		<div class="box box-primary">
            <div class="box-header with-border">
				<i class="fa fa-pencil-square-o"></i>
              <h3 class="box-title">Form Pembelian Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Masukan Barang</label>
							<select id="data_barang" class="form-control select2" style="width: 100%;">
							  <option value="null">--Pilih barang--</option>
							  <?php echo $result_option; ?>
							</select>
						  </div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Jumlah</label>
							<input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="">
						</div>
						<div class="form-group">
							<label>Harga</label>
							<input type="text" id="harga" name="harga" readonly class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label>Nama Supplier</label>
							<input type="text" id="nama_supplier" name="supplier" readonly class="form-control" placeholder="">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Tanggal</label>
							<input type="text" id="tanggal" name="tanggal" readonly class="form-control" value="<?php echo $tanggal; ?>">
						</div>
						<div class="form-group">
							<label>Satuan</label>
							<input type="text" id="nama_satuan" name="satuan" readonly class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<button id="addData" class="btn btn-primary">Tambahkan</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10">
						<div class="box no-border">
						<div class="box-header">
						  <h3 class="box-title">Daftar Pembelian Barang</h3>
						</div>
						<!-- /.box-header -->
						<form id="form-action">
						<div class="box-body no-padding table-responsive">
						  <table class="table table-striped table-bordered tampil-barang">
							<thead>
							<tr>
							  <th style="width:100px;">ID Barang</th>
							  <th style="width:200px;">Nama Barang</th>
							  <th style="width:70px;">Satuan</th>
							  <th style="width:10px;">Jumlah</th>
							  <th style="width:100px;">Harga</th>
							  <th style="width:150px;">Nama Supplier</th>
							  <th style="width:120px;">Alamat</th>
							  <th style="width:110px;">Telp</th>
							  <th style="width: 40px;"></th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						  </table>
						</div>
						</form>
						<!-- /.box-body -->
					  </div>
					  <button id="kirim" class="btn btn-success" style="display:none;">Kirim</button>
					</div>
				</div>
			</div>
          </div>
		  
    </section>

    </div>
  <!-- /.content-wrapper -->

			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['url'] = '<?php echo base_url();?>';
			</script>