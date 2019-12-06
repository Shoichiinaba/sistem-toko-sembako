 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Data Pengguna <small>Mengelola data pengguna</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> <a href="#">Pengguna</a></li>
      </ol>
    </section>
    <section class="content">
          <div class="box-body">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default" style="display:none;"><i class="fa fa-refresh"></i></button>
            <button type="button" data-toggle="modal" data-target="#modal-primary" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Pengguna</button>
          </div>
      <div class="box box-success">
        <div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pengguna</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped tampil-pengguna">
                <thead>
                  <tr>
                    <th>ID Pengguna</th>
                    <th>Username</th>
                    <th>Nama Terang</th>
					<th>Password</th>
					<th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key) {
                  ?>
                  <tr>
                    <td><?php echo $key['id_user'];?></td>
                    <td><?php echo $key['username'];?></td>
                    <td><?php echo $key['nama'];?></td>
					<td><?php echo $key['password'];?></td>
					<td><?php echo $key['keterangan'];?></td>
                    <td> 
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
	
        <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Entri Pengguna</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <form id="form-input-pengguna">
                  <div class="form-group">
                    <label>Nama Terang</label>
                    <input type="text" name="nama" class="form-control" placeholder="Isi nama terang..." required />
                  </div>
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Isi username..." required />
                  </div>
				  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required />
                  </div>
				  <div class="form-group">
                    <label>Keterangan</label>
                    <select class="form-control" name="keterangan">
                      <option value="Admin">Admin</option>
					  <option value="Kasir">Kasir</option>
                    </select>
                  </div>
                </form>
                <div id="loading"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" id="tutup" data-dismiss="modal">Tutup</button>
                
                <button type="submit" class="btn btn-outline" id="kirim"><i class="fa fa-send"></i> Kirim</button>
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
                <h4 class="modal-title">Hapus Pengguna</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-pengguna">
                <div class="form-group">
                    <label>ID Pengguna</label>
                    <input type="text" name="id" class="form-control" placeholder="" value="" readonly>
                  </div>
                </form>
                  <div class="form-group">
                    <label>Username : </label>
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