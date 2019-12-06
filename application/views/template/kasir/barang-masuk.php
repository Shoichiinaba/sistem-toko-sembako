  <!-- UNTUK BELUM ACC -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-th-list"></i>
        Barang Masuk <small>Mengelola data barang masuk</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-th-list"></i>Barang Masuk</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="box box-warning no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Barang Masuk</h3>
            </div>
            <div class="box-body">
			  <div class="pull-right">
				<div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" name="table_search" class="fil-cari form-control pull-left" placeholder="Cari barang" style=""/>
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default fa fa-search" data-cstarget="searchNpage"></button>
                  </div>
                </div>
			  </div>
              
            </div>
            <!-- /.box-body -->
          </div>
		<div class="box no-border hapus-radius-atas">
		<div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body no-padding table-responsive">
				<table class="table table-striped table-bordered tampil-barang">
				<thead>
				<tr>
                  <th style="">ID Barang</th>
                  <th style="">Nama Barang</th>
                  <th style="">Satuan</th>
                  <th style="">Jumlah</th>
				  <th style="">Harga(Rp)</th>
				  <th style="">Supplier</th>
				  <th>Aksi</th>
                </tr>
				</thead>
				<tbody>
				<?php
					if($countData > 0){ ?>
					<?php foreach($data as $key) { ?>
                      <tr>
                        <td><?php echo $key['id_barang']; ?></td>
                        <td><?php echo $key['nama_barang']; ?></td>
                        <td><?php echo $key['satuan']; ?></td>
                        <td><?php echo $key['jumlah']; ?></td>
                        <td><?php echo $key['harga']; ?></td>
						<td><?php echo $key['nama_supplier']; ?></td>
						<td>
							<button type="button" alt="<?php echo $key['id']; ?>" data-cstarget="getCheck" class="btn btn-primary fa fa-check">&nbsp;&nbsp;Diterima</button>
						</td>
                      </tr>
					<?php } ?>
				<?php } else { ?>
					 
				<?php } ?>
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
  <!-- /.content-wrapper -->
			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['url'] = '<?php echo base_url();?>';
			  // Datadefine['tanggal'] = '';
			</script>
			<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>