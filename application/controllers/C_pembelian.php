<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_pembelian extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('pembelian_m');
	}
	private function getDaftarPembelian($param){
    $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['total_barang'].'</td>';
                        $s.='<td>'.$key['total_item'].'</td>';
                        $s.='<td>'.$key['total_harga'].'</td>';
                        $s.='<td>'.$key['tanggal'].'</td>';
                        $s.='<td><a href="'.base_url().'index.php/admin/pembelian_detail?q='.$key['tanggal'].'"><button type="button" class="btn  btn-primary fa fa-search"> Lihat Detail</button></a></td>';
                      $s.='</tr>';
        }
        return $s;
  }
  function getDaftarPembelianDetail( $param ){
      $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['satuan'].'</td>';
                        $s.='<td>'.$key['jumlah'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        // acc
                        $s.='<td>';
                        if($key['acc'] == 'belum'){
                          $s.='<span class="label  label-danger">'.$key['acc'].'</span>';
                        }else{
                          $s.='<span class="label  label-success">'.$key['acc'].'</span>';
                        }
                        $s.='</td>';
                        $s.='<td>';
                        if($key['status'] == 'belum'){
                        	$s.='<button class="btn btn-primary fa fa-plus no-padding" data-cstarget="getTambah" style="height:24px;" '.print( ($key['acc'] == "belum") ? 'disabled':'' ).'> Tambahkan</button>';
                        }else{
                        	$s.='<button class="btn btn-success fa fa-check no-padding" style="height:24px;"> Ditambahkan</button>';
                        }
                        $s.='<button data-target="#modal-warning" data-cstarget="editReck" data-toggle="modal" data-cstarget="delPick" class="btn btn-warning fa fa-pencil-square-o no-padding" style="width:30px; height:24px;"'.print( ($key['acc'] != "belum") ? 'disabled':'').'></button>';

                        $s.='<button data-target="#modal-danger" data-cstarget="delPick" data-toggle="modal" class="btn btn-danger fa fa-trash-o no-padding" style="width:30px; height:24px;"></button></td>';
                      $s.='</tr>';
        }
        return $s;
  }
  function ambil_tampil_barang(){
  	$id = $_GET['id'];
  	$data = $this->pembelian_m->hasil_data_barang($id);
  	if($data->num_rows() == 1){
  		$result = $data->result_array();
  		die( json_encode($result[0]) );
  	}
  }
  function simpan_data_pembelian_barang(){
    $data = array();
    for($i=0; $i<count($_POST['id_barang']); $i++){
      $dataV = array();
      foreach($_POST as $key => $value){
        $dataV[$key] = $value[$i];
      }
      array_push($data, $dataV);
    }
    $this->db->insert_batch('pembelian', $data);
  }

  function panggil_data_daftar_pembelian_lanjut(){
    $index = $_GET['index'];
      $length = $_GET['length'];
      $get = $this->pembelian_m->data_daftar_pembelian_lanjut($index, $length);
      $result = $this->getDaftarPembelian($get);
      echo json_encode(array('data'=>$result));
  }
  function panggil_data_daftar_pembelian_detail_lanjut(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $tgl = $_GET['tanggal'];
      $data = $this->pembelian_m->data_daftar_pembelian_detail_lanjut($index, $length, $tgl);
      $get = $data->result_array();
      $result = $this->getDaftarPembelianDetail($get);
      echo json_encode(array('data'=>$result));
  }

  function tampil_edit_pembelian(){
  		$id = $_GET['id'];
      $data = $this->pembelian_m->data_edit_pembelian_tampil($id);
      $id = $data[0]['id'];
      $id_barang = $data[0]['id_barang'];
      $nama_barang = $data[0]['nama_barang'];
      $satuan = trim($data[0]['satuan']);
      $jumlah = $data[0]['jumlah'];
      $harga = $data[0]['harga'];
      $nama_supplier = $data[0]['nama_supplier'];
      $str='';
  		$str.='<div class="form-group">
                    <label>ID Pembelian</label>
                    <input type="text" name="id" class="form-control" value="'.$id.'" readonly>
                  </div>';
  		$str.='<div class="form-group">
							<label>Nama Barang</label>
							<select id="data_barang" name="id_barang" class="form-control select2" style="width: 100%;" onchange="getChange(this)">
							<option value="'.$id_barang.'">'.$nama_barang.'</option>
							'.$this->pembelian_m->ambil_data_barang_edit($id_barang).'
							</select>
				</div>';
        $str.='<div class="form-group">
                    <label>Kategori</label>
                    <input type="text" id="form-satuan" class="form-control" name="satuan" value="'.$satuan.'" readonly>
                    </div>';
        $str.='<div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" id="form-jumlah" class="form-control" name="jumlah" value="'.$jumlah.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Harga</label>
                    <input type="text" id="form-harga" class="form-control" name="harga" value="'.$harga.'" readonly>
                  </div>';
        $str.='<div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" id="form-supplier" class="form-control" name="nama_supplier" value="'.$nama_supplier.'" readonly>
                  </div>';
        die($str);
  	}
  	function edit_data_pembelian_detail(){
  		$harga = $this->pembelian_m->getHarga($_GET['id_barang']);
  		$total_harga = $harga * $_GET['jumlah'];
  		$_GET['harga'] = $total_harga;
  		$data = $_GET;
  		if($this->pembelian_m->update_data_pembelian($data)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	function hapus_pembelian_detail(){
	      $id = $_GET['id'];
	      if($this->pembelian_m->hapus_data_pembelian_detail($id)){
	        die(json_encode( array('result'=>'sukses') ));
	      }
	      die(json_encode( array('result'=>'gagal') ));
  }
  function tambah_stok_barang(){
  	$id = trim($_GET['id']);
  	$jumlah = trim($_GET['jumlah']);
  	$data = $this->pembelian_m->getdataidBarang($id);
  	$jumlah_stok_update = $jumlah + $data['jumlah_stok'];
  	if($this->pembelian_m->update_data_stok_barang($data['id'], $data['id_barang'], $jumlah_stok_update)){
  		die(json_encode( array('result'=>'sukses') ));
  	}
  	die(json_encode( array('result'=>'gagal') ));
  	// 
  }
  function get_cetak_pembelian_barang(){
    $tanggal = $_GET['tanggal'];
    $sql = $this->pembelian_m->data_cetak_pembelian($tanggal);
    $this->cetak_pembelian_barang_detail($tanggal, $sql->result_array());
  }
  private function cetak_pembelian_barang_detail($tanggal, $result){
    $this->load->library('godompdf');
    $tgl = $tanggal;
    $data['tanggal_cetak'] = 'Tanggal Cetak - '.date('d/m/Y');
    $data['tanggal_barang'] = $tgl;
    $data['data'] = $result;
    $data['nama'] = $_SESSION['nama'];
    $data['status'] = $_SESSION['keterangan'];
    $data['jam'] = date('H:i:s');
    $html = $this->load->view('template/admin/cetak_pembelian_detail/print', $data, true);
    $this->godompdf->generate($html, 'pembelian - '.$tgl);
  }
  private function getBarangmasukstr($param){
       $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['satuan'].'</td>';
                        $s.='<td>'.$key['jumlah'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        $s.='<td><button type="button" alt="'.$key['id'].'" data-cstarget="getCheck" class="btn btn-primary fa fa-check">&nbsp;&nbsp;Diterima</button></td>';
                      $s.='</tr>';
        }
        return $s;
    }
  function panggil_data_barang_masuk(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $get = $this->pembelian_m->data_barang_masuk();
      $result = $this->getBarangmasukstr($get);
      echo json_encode(array('data'=>$result));
    }
   function pencarian_data_barang_masuk(){
        $cari = $_GET['cari'];
        $data = $this->pembelian_m->data_cari_barang_masuk($cari);
        $data['data'] = $this->getBarangmasukstr($data['data']);
        die( json_encode( $data ) );
    }
    function pencarian_data_barang_masuk_next(){
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
 	  $get = $this->pembelian_m->data_pencarian_barang_masuk_next($cari);
      $result = $this->getBarangmasukstr($get);
      echo json_encode( array('data'=>$result) );
    }
    function data_barang_masuk_terima(){
      $id = $_GET['id']; // merupakan id barang pada pembelian
      $data = array('acc' => 'sudah');
      $where = "id = '$id'";
      $str = $this->db->update_string('pembelian', $data, $where);
      if($this->db->query($str)){
        die( json_encode( array('status'=>'success') ) );
      }
      die( json_encode( array('status' => 'failed') ) );
    }

}
?>