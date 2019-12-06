
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kategori Barang
        <small>Menampilkan seluruh data Kategori barang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Kategori barang</a></li>
      </ol>
    </section>
    <section class="content">
          <div class="box-body">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
            <button type="button" data-toggle="modal" data-target="#modal-primary" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Kategori</button>
          </div>
      <div class="box">
        <div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Kategori Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding table-responsive">
              <table class="table table-striped tampil-kategori">
                <thead>
                  <tr>
                    <th>ID Kategori Barang</th>
                    <th>Kategori Barang</th>
                    <th>Keterangan</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key) {
                  ?>
                  <tr>
                    <td><?php echo $key['id_kategori'];?></td>
                    <td><?php echo $key['nama_kategori'];?></td>
                    <td><?php echo $key['keterangan'];?></td>
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
                <h4 class="modal-title">Pembaharuan Kategori Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-input-kategori">
                  <div class="form-group">
                    <label>ID Kategori Barang</label>
                    <input type="text" name="id_kategori" readonly class="form-control id">
                  </div>
                  <div class="form-group">
                    <label>Nama Kategori Barang</label>
                    <input type="text" name="nama_kategori" class="form-control nama" placeholder="">
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control keterangan" placeholder="">
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
                <h4 class="modal-title">Entri Kategori Barang</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <form id="form-input-kategori">
                  <div class="form-group">
                    <label>Kategori Barang</label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Kategori barang...">
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Isi keterangan...">
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
                <h4 class="modal-title">Hapus Kategori Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-kategori">
                <div class="form-group">
                    <label>ID Kategori Barang</label>
                    <input type="text" name="id_kategori" class="form-control" placeholder="" value="" readonly>
                  </div>
                </form>
                  <div class="form-group">
                    <label>Kategori Barang : </label>
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
