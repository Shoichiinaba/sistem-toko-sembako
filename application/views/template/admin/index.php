
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-home"></i>
		Home
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
      </ol>
    </section>
    <section class="content">
      <div class="callout callout-info">
                <h4>Selamat Datang !!!</h4>
                <p>Anda telah berada di halaman admin Toko. Maka gunakanlah hak penuh anda untuk mengelola seluruh data barang toko</p>
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
              <table class="table table-bordered tabel-barang-ket">
                <thead><tr>
                  <th style="width: 5%;">#</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>ID Barang</strong></td>
                  <td><div class="modal-idbarang">id barang</div></td>
                </tr>
                <tr>
                  <td><strong>Nama Barang</strong></td>
                  <td><div class="modal-nama-barang">Nama barang</div></td>
                </tr>
                <tr>
                  <td><strong>Harga</strong></td>
                  <td><div class="modal-harga">Harga</div></td>
                </tr>
                <tr>
                  <td><strong>Stok</strong></td>
                  <td><div class="modal-stok">stok</div></td>
                </tr>
                <tr>
                  <td><strong>Jenis barang</strong></td>
                  <td><div class="modal-jenis-barang">nama_kategori</div></td>
                </tr>
                <tr>
                  <td><strong>Jenis Kategori</strong></td>
                  <td> <div class="modal-jenis-kategori">jenis_kategori</div></td>
                </tr>
                <tr>
                  <td><strong>Keterangan</strong></td>
                  <td> <div class="modal-keterangan">keterangan</div></td>
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
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" placeholder="Masukan nama barang anda">
                  </div>
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" placeholder="Masukan harga barang anda">
                  </div>
                  <div class="form-group">
                    <label>Jenis Barang</label>
                    <select class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="text" class="form-control" placeholder="Masukan jumlah stok barang anda">
                  </div>
                  <div class="form-group">
                    <label>Jumlah Maksimum Stok</label>
                    <input type="text" class="form-control" placeholder="Masukan jumlah maksimum stok barang anda">
                  </div>
                  <div class="form-group">
                    <label>Penempatan barang</label>
                    <select class="form-control">
                      <option>option 1</option>
                      <option>option 2</option>
                      <option>option 3</option>
                      <option>option 4</option>
                      <option>option 5</option>
                    </select>
                  </div>
                </div>
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
      
