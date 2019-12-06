

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penjualan
        <small>Menampilkan seluruh penjualan barang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Penjualan</a></li>
      </ol>
    </section>
    <section class="content">
		
		<div class="box box-primary" style="margin-bottom:12px;">
            <div class="box-header">
              <h3 class="box-title">Filter penjualan</h3>
            </div>
            <div class="box-body">
              <div class="kotak-tanggal">
              <div class="form-group">
              <label>Penjualan Berdasarkan Tanggal :</label>
              <div id="form-tanggal-container">
                <div id="form-kotak-tanggal">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <div class="form-kotak-tanggal">
                      <div id="form-tanggal">
                        <input type="text" class="form-control tanggal" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                      </div>
                    </div>
                  </div>
                </div>
                <div id="form-kotak-tombol">
                  <button type="button" class="btn btn-block btn-primary" id="tanggal" data-cstarget="searchTanggal">Tampilkan</button>
                </div>
              </div>
            </div>
            </div>

            <div class="kotak-bulan">
              <div class="form-group">
                  <label>Penjualan Berdasarkan Bulan :</label>
                  <div id="form-bulan-container">
                    <div id="form-kotak-bulan">
                      <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <div class="form-kotak-tanggal">
                      <div id="form-tanggal">
                        <input type="text" class="form-control bulan" data-inputmask="'alias': 'mm/yyyy'" data-mask="">
                      </div>
                    </div>
                  </div>
                    </div>
                    <div id="form-kotak-bulan-tombol">
                      <button type="button" class="btn btn-block btn-primary" id="bulan" data-cstarget="searchTanggal">Tampilkan</button>
                    </div>
                  </div>
                  
                </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
		  
      <div class="box box-success">
           <div class="box-header">
              <h3 class="box-title">Tabel daftar penjualan barang</h3>
            </div>
            <div id="ket-pencarian">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered tampil-barang">
                <thead><tr>
                  <th>ID</th>
                  <th style="width:24%;">Barang Jual</th>
                  <th>Harga</th>
                  <th>Pembayaran</th>
                  <th>kembalian</th>
                  <th>Tanggal</th>
                  <th>Opsi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $key) {
                      echo '<tr>';
                        echo '<td>'.$key['id'].'</td>';
                        echo '<td>'.$key['deskripsi_barang'].'</td>';
                        echo '<td>'.$key['total_harga'].'</td>';
                        echo '<td>'.$key['pembayaran'].'</td>';
                        echo '<td>'.$key['kembalian'].'</td>';
                        echo '<td>'.$key['tanggal'].'</td>';
                        echo '<td> <button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>
						<button type="button" data-toggle="modal" data-target="#modal-danger" class="btn btn-danger fa fa-trash"></button>
						</td>';
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
              <div id="ket-index-data">
                <p>Menampilkan <strong>2</strong> dari <strong> <?php echo $countData; ?> </strong> data. </p>
              </div>
              <div id="page-more">
                <button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
    </section>

    </div>
  <!-- /.content-wrapper -->
  <div class="modal modal-info fade" id="modal-info" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Barang</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered tabel-penjualan-ket">
                <thead><tr>
                  <th style="width: 5%;">#</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>ID</td>
                  <td><div class="modal-id"></div></td>
                </tr>
                <tr>
                  <td>Barang</td>
                  <td><div class="modal-barang"></div></td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td><div class="modal-harga"></div></td>
                </tr>
                <tr>
                  <td>Pembayaran</td>
                  <td><div class="modal-pembayaran"></div></td>
                </tr>
                <tr>
                  <td>Kembalian</td>
                  <td><div class="modal-kembalian"></div></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><div class="modal-tanggal"></div></td>
                </tr>
                <tr>
                  <td>Kasir</td>
                  <td><div class="modal-kasir"></div></td>
                </tr>
              </tbody>
            </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>

      <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
                <button type="button" class="btn btn-outline" id="kirim-barang"><i class="fa fa-send"></i> Kirim</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      
	<script type="text/javascript">
	  var Datadefine = [];
	  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
	  Datadefine['index-hal'] = 1;
	  Datadefine['url'] = '<?php echo base_url();?>';
	  Datadefine['count-data'] = '<?php echo $countData; ?>';
	</script>