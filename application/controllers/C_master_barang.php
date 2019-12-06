<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class C_master_barang extends CI_Controller{
    function __construct(){
      parent::__construct();
      $this->load->model('master_barang_m');
    }
		function buttonOption($param){
		    $q = "";
		    if($param == "editable"){
		      $q = '<button type="button" data-toggle="modal" data-target="#modal-warning" data-cstarget="editReck" class="btn btn-warning fa fa-pencil-square-o"></button>
		      <button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button>';
		    }else if($param == "fulloption"){
		      $q = '<button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>
		      <button type="button" data-toggle="modal" data-target="#modal-warning" data-cstarget="editReck" class="btn btn-warning fa fa-pencil-square-o"></button>
		      <button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button>';
		    }else if($param == 'info'){
          $q = '<button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>';
        }
		    return $q;
		 }
		private function getBarangstr($param = array()){
	      $s = "";
	        foreach ($param as $key) {
	          $s.='<tr>';
	                        $s.='<td>'.$key['id_barang'].'</td>';
	                        $s.='<td>'.$key['nama_barang'].'</td>';
	                        $s.='<td>'.$key['satuan'].'</td>';
	                        $s.='<td>'.$key['harga_jual'].'</td>';
	                        $s.='<td>'.$key['harga_beli'].'</td>';
	                        $s.='<td>'.$key['jumlah_stok'].'</td>';
	                        if($_SESSION['keterangan'] != 'Kasir'){
	                          $s.='<td>'.$this->buttonOption('fulloption').'</td>';
	                        }else{
	                          $s.='<td>'.$this->buttonOption('info').'</td>';
	                        }
	                      $s.='</tr>';
	        }
	        return $s;
	 }

   function set_satuan(){
      $satuan = array(
        'Pc'=>'Pouch(Pc)',
        'Pcs'=>'Peaces(Pcs)',
        'Sch'=>'Sachet(Sch)',
        'Btl'=>'Botol(Btl)',
        'Krtn'=>'Karton(Krtn)',
        'Gln'=>'Galon(Gln)'
      );
      return $satuan;
   }

  function info_barang(){
      $id = $_GET['id'];
      $r = $this->master_barang_m->data_info_barang($id);
      die($r);
    }

  function cetak_barang(){
    $this->load->library('godompdf');
    $data['tanggal_cetak'] = 'Tanggal Cetak - '.date('d/m/Y');
    $data['data'] = $this->master_barang_m->data_print();
     $data['nama'] = $_SESSION['nama'];
    $data['status'] = $_SESSION['keterangan'];
    $data['jam'] = date('H:i:s');
    $html = $this->load->view('template/admin/cetak_barang/print', $data, true);
    $this->godompdf->generate($html, 'Barang - '.date('d/m/Y'));
  }

 function tambah_barang(){
		$data['id_barang'] = $this->master_barang_m->buat_id_barang();
		$data['nama_barang'] = $_POST['nama_barang'];
    $data['satuan'] = $_POST['satuan'];
		$data['harga_jual'] = $_POST['harga_jual'];
    $data['harga_beli'] = $_POST['harga_beli'];
		$data['jumlah_stok'] = $_POST['jumlah_stok'];
		$data['id_penempatan'] = $_POST['id_penempatan'];
    $data['id_supplier'] = $_POST['supplier'];
		if($this->master_barang_m->simpan_data_barang($data)){
			die( json_encode( array('result'=>'sukses') ) );
		}else{
			die( json_encode( array('result'=>'gagal') ) );
		}
	}

	function tampil_edit_barang(){
  		$id = $_GET['id'];
      $data = $this->master_barang_m->data_edit_tampil($id);
      $id_barang = $data[0]['id_barang'];
      $nama_barang = $data[0]['nama_barang'];
      $satuan = trim($data[0]['satuan']);
      $harga_jual = $data[0]['harga_jual'];
      $harga_beli = $data[0]['harga_beli'];
      $jumlah_stok = $data[0]['jumlah_stok'];
      $id_penempatan = trim($data[0]['id_penempatan']);
      $nama_penempatan = $data[0]['nama_penempatan'];
      $id_supplier = trim($data[0]['id_supplier']);
      $nama_supplier = $data[0]['nama_supplier'];
      $str='';
  		$str.='<div class="form-group">
                    <label>Koda Barang</label>
                    <input type="text" name="id_barang" class="form-control" value="'.$id_barang.'" readonly>
                  </div>';
  		$str.='<div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="'.$nama_barang.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Satuan</label>
                    <select class="form-control" name="satuan">
                    <option value="'.$satuan.'">'.$this->set_satuan()[$satuan].'</option>';
                    foreach ($this->set_satuan() as $key => $value) {
                      if($key != $satuan){
                        $str.='<option value="'.$key.'">'.$value.'</option>';
                      }
                    }
        $str.='</select></div>';
        $str.='<div class="form-group">
                    <label>Harga Jual</label>
                    <input type="text" class="form-control" name="harga_jual" value="'.$harga_jual.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Harga Beli</label>
                    <input type="text" class="form-control" name="harga_beli" value="'.$harga_beli.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="text" class="form-control" name="jumlah_stok" value="'.$jumlah_stok.'">
                  </div>';
        // untuk form penempatan barang
        $str.='<div class="form-group" id="penempatan">
                    <label>Penempatan barang</label>
                    <select class="form-control" name="id_penempatan" id="form-penempatan">
                      <option value="'.$id_penempatan.'">'.$nama_penempatan.'</option>';
        $penempatan_data_value = $this->master_barang_m->data_edit_barang_penempatan($nama_barang, $id_penempatan);
        foreach ($penempatan_data_value as $v) {
        	$str.='<option value="'.$v['id_penempatan'].'">'.$v['keterangan'].'</option>';
        }
        $str.='</select></div>';
        // untuk form supplier
        $str.='<div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control" name="id_supplier">
                      <option value="'.$id_supplier.'">'.$nama_supplier.'</option>';
        $supplierBarang = $this->db->query("SELECT * FROM supplier where id_supplier != '$id_supplier'");
        foreach ($supplierBarang->result() as $v) {
          $str.='<option value="'.$v->id_supplier.'">'.$v->nama_supplier.'</option>';
        }
        $str.='</select></div>';
        die($str);
  	}

  	public function update_barang(){
  		$data = $_GET;
  		if($this->master_barang_m->update_data_barang($data)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	public function hapus_barang(){
  		$id = $_GET['id_barang'];
  		if($this->master_barang_m->delete_data_barang($id)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	function tampil_barang_lanjut(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $result = $this->getBarangstr($this->master_barang_m->data_barang_lanjut($index, $length));
      echo json_encode(array('data'=>$result));
    }
    function cari_barang(){
        $cari = $_GET['cari'];
        $data = $this->master_barang_m->data_cari_barang($cari);
        $data['data'] =  $this->getBarangstr($data['data']);
        die( json_encode( $data ) );
    }
    function cari_barang_lanjut(){
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $data = $this->master_barang_m->data_cari_barang_lanjut($cari, $index, $length);
      $result = $this->getBarangstr($data);
      echo json_encode( array('data'=>$result) );
    }

    function get_penempatan(){
      $q = explode(' ', trim($_GET['data']));
      $get = $this->master_barang_m->data_penempatan($q[0]);
      $str = '<select class="form-control" name="id_penempatan" id="form-penempatan">';
      if($get->num_rows() >= 1){
        foreach ($get->result_array() as $value) {
          $str.='<option value="'.$value['id_penempatan'].'">'.$value['keterangan'].'</option>';
        }
      }else{
        $str.='<option>Penempatan tidak tersedia</option>';
      }
      
      $str.='</select>';
      echo $str;
    }
	  #batas class
}

?>