
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-inbox"></i>
        Penempatan<small>Mengelola data penempatan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-inbox"></i>Penempatan</a></li>
      </ol>
    </section>
    <section class="content">
          <div class="box-body">
            <button type="button" data-toggle="modal" data-target="#modal-primary" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Penempatan</button>
          </div>
      <div class="box box-success">
        <div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Penempatan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered tampil-penempatan">
                <thead>
                  <tr>
                    <th>ID Penempatan</th>
                    <th>Nama Penempatan</th>
                    <th>Keterangan</th>
					<th>Kunci</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key) {
                  ?>
                  <tr>
                    <td><?php echo $key['id_penempatan'];?></td>
                    <td><?php echo $key['nama_penempatan'];?></td>
                    <td><?php echo $key['keterangan'];?></td>
					<td><?php echo $key['kunci'];?></td>
                    <td> 
                      <button type="button" data-toggle="modal" data-cstarget="editReck" data-target="#modal-warning"  class="btn btn-warning fa fa-pencil-square-o"></button>
                      <button type="button" data-toggle="modal" data-cstarget="delPick" data-target="#modal-danger" class="btn btn-danger fa fa-trash"></button></td>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
            </div>
            <!-- /.box-body -->
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
      <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembaharuan Penempatan</h4>
              </div>
              <div class="modal-body">
                <form id="form-input-penempatan">
                  <div class="form-group">
                    <label>ID Penempatan</label>
                    <input type="text" name="id_penempatan" readonly class="form-control id">
                  </div>
                  <div class="form-group">
                    <label>Nama Penempatan</label>
                    <input type="text" name="nama_penempatan" class="form-control nama" placeholder="Isi nama penempatan...">
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control keterangan" placeholder="Isi keterangan penempatan...">
                  </div>
				  <div class="form-group">
                    <label>Kata Kunci Barang</label>
                    <input type="text" name="kunci" class="form-control kunci" placeholder="Kata kunci untuk penempatan...">
                  </div>
                </form>
                <div class="loader">
                 <!-- <img src="<?php echo base_url();?>dist/img/ajax-loader.gif"/> --> 

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-outline" id="update">Simpan Perubahan</button>
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
                <h4 class="modal-title">Entri Penempatan</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <form id="form-input-penempatan">
                  <div class="form-group">
                    <label>Nama Penempatan</label>
                    <input type="text" name="nama_penempatan" class="form-control" placeholder="Isi nama penempatan..." required>
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Isi keterangan penempatan..." required>
                  </div>
				  <div class="form-group">
                    <label>Kata Kunci Barang</label>
                    <input type="text" name="kunci" class="form-control keterangan" placeholder="Kata kunci untuk penempatan..." required>
                  </div>
                </form>
                <div id="loading"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" id="tutup" data-dismiss="modal">Tutup</button>
                
                <button type="button" class="btn btn-outline" id="kirim"><i class="fa fa-send"></i> Kirim</button>
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
                <h4 class="modal-title">Hapus Penempatan</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-penempatan">
                <div class="form-group">
                    <label>ID Barang</label>
                    <input type="text" name="id_penempatan" class="form-control" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
                </form>
                  <div class="form-group">
                    <label>Nama Penempatan : </label>
                    <span class="label label-warning"></span>
                  </div>
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
		<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['url'] = '<?php echo base_url();?>';
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>