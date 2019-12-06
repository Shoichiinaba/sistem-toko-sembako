  <!-- UNTUK DAFTAR PEMBELIAN BARANG -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-th-list"></i> Daftar Pembelian
		<small>mengelola data pembelian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Daftar Pembelian</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="row">
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sudah Acc</span>
              <span class="info-box-number"><?php echo $status['acc'];?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-ban"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Belum Acc</span>
              <span class="info-box-number"><?php echo $status['belum'];?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
		<div class="box box-success">
		<div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pembelian Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
				<table class="table table-striped table-bordered tampil-barang">
				<thead>
				<tr>
                  <th style="">Total Barang</th>
                  <th style="">Total Item Barang</th>
                  <th style="">Total Harga(Rp)</th>
                  <th style="">Tanggal</th>
				  <th style="">Aksi</th>
                </tr>
				</thead>
				<tbody>
                <?php
					foreach($data as $barang){
						?>
						<tr>
							<td><?php echo $barang['total_barang']?></td>
							<td><?php echo $barang['total_item']?></td>
							<td><?php echo $barang['total_harga']?></td>
							<td><?php echo $barang['tanggal']?></td>
							<td><a href="<?php echo base_url();?>index.php/admin/pembelian_detail?q=<?php echo $barang['tanggal'];?>">
								<button type="button" class="btn  btn-primary fa fa-search"> Lihat Detail</button>
							</a>
							</td>
						</tr>
				<?php
					}
				?>
              </tbody></table>
			</div>
			<div class="box-body" style="padding-top:5px;">
				<div id="ket-index-data">
                <p>Menampilkan <strong>2</strong> dari <strong> <?php echo $countData; ?> </strong> data. </p>
              </div>
            <div id="page-more">
              <?php if($next == "ada") { ?>
                <button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>
              <?php } ?>
            </div>
			</div>
          </div>
		  
    </section>

    </div>
	<div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-barang">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
                </form>
                  <p>Apakah anda yakin ingin menghapus data ini</p>
                  <div class="loader"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" id="tutup" data-dismiss="modal">Tidak</button>
                <button type="button" id="delete" class="btn btn-outline"><i class="fa fa-trash"></i> Hapus</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <!-- /.content-wrapper -->

			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['url'] = '<?php echo base_url();?>';
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>