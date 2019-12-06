
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-shopping-cart"></i>
        Penjualan
        <small>Form penjualan barang</small>
      </h1>
	  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Penjualan</a></li>
      </ol>
    </section>

    <div class="konten-utama">
      <div class="col-konten-utama">

    	<div class="konten-pencarian">
	    	<div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">Pencarian Barang</h3>
	            </div>
	            <div class="box-body">
	              <div class="input-group input-group-sm ukuran-pencarian">
	                <input type="text" class="form-control" id="teks-pencarian" placeholder="Tulis nama barang disini...">
	                    <span class="input-group-btn">
	                      <button type="button" class="btn btn-info btn-flat tmbl-pencarian">Cari</button>
	                    </span>
	              </div>
                <div class="ket-pencarian">
                    <div id="keterangan-pencarian">
                    </div>
                    <div id="kalimat"></div>
              </div>
	            </div>
              
	            <!-- /.box-body -->
	          </div>
	      </div>

        <div class="konten-peringatan" style="display: none;">
          <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Warning alert preview. This alert is dismissable.
              </div>
        </div>

        <div class="konten-barang" style="display: none;">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Barang</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool hilang"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              <div class="table-responsive tabel-barang">
                <table class="table table-bordered">
                  <tbody></tbody></table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
          </div>
      </div>

      <div class="konten-peringatan konten-peringatan-pembayaran" style="display: none;">
        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" id="tbl-tutup-pembayaran">×</button>
                <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
                Pembayaran anda kurang dari total keseluruhan barang yang dibeli...
              </div>
      </div>

    	<div class="konten-barang-beli" style="display:none;">
    		<div class="box box-success">
	    		<div class="box-header with-border">
	              <h3 class="box-title">Penjualan Barang</h3>
	            </div>
	            <form id="form-beli">
              <div class="box-body" style="">
				<div class="form-group" style="width:220px;">
                  <label for="exampleInputEmail1">Nama Customer</label>
                  <input type="text" name="customer" class="form-control input-sm" placeholder="Input customer" id="customer" />
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered tabel-himpunan-barang">
                      <thead>
                    <tr>
                      <th>ID Barang</th>
                      <th style="width:35%">Nama Barang</th>
                      <th>Satuan</th>
					  <th>Jumlah</th>
                      <th>Harga</th>
                      <th style="width: 12%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                
            </div></div>

	              <div class="box-footer clearfix">
                  <div class="jumlah-pembayaran">
                    <div id="teks"><strong>Total Pembayaran Rp.</strong></div>
                    <div id="jumlah"><span class="info-box-number">0</span></div>
                  </div>

                  <div class="input-group" style="width:300px;">
                      <input type="text" class="form-control input-lg" name="bayar" placeholder="Isi nominal pembayaran">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat btn-lg bayar">Kirim</button>
                      </span>
                  </div>
                </form>
	              </div>
            
	    	</div>
    	</div>


    	<div class="modal fade" id="modal-default-barang" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Ambil Barang</h4>
              </div>
              <div class="modal-body">
                <table class="table table-hover">
                <tbody>
                <tr>
                  <td><strong>ID Barang</strong></td>
                  <td><div class="modal-idbarang"></div></td>
                </tr>
                <tr>
                  <td><strong>Nama Barang</strong></td>
                  <td><div class="modal-nama-barang"></div></td>
                </tr>
				<tr>
                  <td><strong>Satuan</strong></td>
                  <td><div class="modal-nama-satuan"></div></td>
                </tr>
                <tr>
                  <td><strong>Harga</strong></td>
                  <td><div class="modal-harga"></div></td>
                </tr>
                <tr>
                  <td><strong>Stok</strong></td>
                  <td><div class="modal-stok"></div></td>
                </tr>
                <tr>
                  <td><strong>Tentukan Jumlah</strong></td>
                  <td> <div class="modal-jumlah"><input type="number" min="0" max="12" name="angka" value="0"/></div></td>
                </tr>
              </tbody></table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary tambah-barang" data-dismiss="modal">Tambahkan</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    	</div>

      </div>

      <div class="konten-display-penjualan" style="display:none;">
          <div class="alert alert-success alert-dismissible">
                <h4><i class="icon fa fa-check"></i> Sukses !</h4>
                Proses pembelian barang telah dinyatakan berhasil dan tersimpan di database.
          </div>
          <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Hasil Penjualan Barang</h3>
              </div> 
              <div class="box-body" style="">
				<div class="form-group" style="width:220px;">
                  <label for="exampleInputEmail1">Nama Customer</label>
                  <input type="text" class="form-control input-sm" id="customer" readonly />
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered tabel-hasil-perhitungan">
                    <thead>
                      <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:35%">Nama Barang</th>
						<th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                  </tbody>
                </table>
                <button type="button" class="btn btn-default btn-kembali">
                  <i class="fa fa-arrow-left"></i> Kembali
                </button>
				<a href="<?php echo base_url();?>index.php/c_penjualan/cetak_struk">
				<button type="button" class="btn btn-default btn-kembali pull-right">
                  <i class="fa fa-print"></i> Cetak
                </button>
              </div>
            </div> 
          </div>
      </div>

    </div>
  </div>
  <script type="text/javascript">
	  var Datadefine = [];
	  Datadefine['url'] = '<?php echo base_url();?>';
  </script>

  <!-- /.content-wrapper -->
