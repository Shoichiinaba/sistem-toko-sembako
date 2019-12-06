<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_function extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('penjualan_m');
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
    }
    return $q;
  }

	function index()
	{
		$sql = "SELECT a.id_barang, a.nama_barang,a.harga,a.stok,b.nama_jenis,c.nama_kategori,c.keterangan from barang_jual a,jenis b,kategori c where a.id_jenis_barang = b.id_jenis_barang AND a.id_kategori = c.id_kategori";
		$getSql = $this->db->query($sql);
		$get = $getSql->result_array();
		echo json_encode($get);
	}
	// fungsi get_barang digunakan untuk menampilkan databarang
	// dengan berdasarkan pencarian
	function get_barang()
	{
		$jenis = $this->input->post('jenis', true);
		  $cari = $this->input->post('pencarian', true);

		if($jenis == 'dapat'){
			$index = [];
			$index['query'] = [];

				$sql = "SELECT a.id_barang, a.nama_barang,a.harga,a.stok,b.nama_jenis,c.nama_kategori,c.keterangan, d.nama_penempatan from barang_jual a,jenis b,kategori c, penempatan d where a.id_jenis_barang = b.id_jenis_barang AND a.id_kategori = c.id_kategori AND a.id_penempatan = d.id_penempatan AND a.nama_barang LIKE '%$cari%' limit 8";
				$getSql = $this->db->query($sql);
				$get = $getSql->result_array();
				if(count($get) > 0){
					foreach ($get as $obj) {
						array_push($index['query'], $obj);
					}
					echo json_encode($index);
				}else{
					// jika tidak ada data
					$index['query'] = 'No Data';
					echo json_encode( $index );
				}
				
		}else{
			$index = [];
			$index['query'] = [];
			$sql = "SELECT nama_barang FROM barang_jual WHERE nama_barang LIKE  '%$cari%' LIMIT 7";
			$getSql = $this->db->query($sql);
			$get = $getSql->result_array();
			if(count($get) > 0){
				foreach ($get as $obj) {
					array_push($index['query'], $obj);
				}
			}else{
				$index['query'] = 'No Data';
			}
				echo json_encode($index);
		}
	}

	public function beliBarang()
	{
		$id_barang = $_POST['id_barang'];
		$barang = $_POST['barang'];
		$jumlah = $_POST['jumlah'];
		$kategori = $_POST['kategori'];
		$harga = $_POST['harga'];
		$pembayaran = $_POST['bayar'];
		$stok_kurang = $_POST['stok_kurang'];
		$taget = "";
		$totalHarga = 0;
		$timelineBarang = "";

		$no = 0;
		for($i=0; $i<count($barang); $i++){
			$no++;
			$taget.='<tr>';
				$taget.='<td>'.$no.'</td>';
				$taget.='<td>'.$barang[$i].'</td>';
				$taget.='<td>'.$jumlah[$i].'</td>';
				$taget.='<td>'.$kategori[$i].'</td>';
				$taget.='<td>'.$harga[$i].'</td>';
			$taget.='</tr>';
			$totalHarga+=(int) $harga[$i];
			$timelineBarang.=$this->resultBarang($barang[$i], $jumlah[$i], $kategori[$i], $harga[$i]);
			$timelineBarang.=($no >= count($barang))?'':', ';
		}
		$kembalian = ((int) $pembayaran - $totalHarga); // menhitung kembalian
		$taget.=$this->hitunganTotal($pembayaran, $totalHarga); // meneruskan string dari $taget untuk pembayaran dan kembalian

		if( $this->input_penjualan($timelineBarang, $totalHarga, $pembayaran, $kembalian) ){
			$this->get_update_barang($_POST);
			echo json_encode(array('status'=>'success', 'tag'=>$taget));
		}else{
			echo json_encode(array('status'=>'failed', 'tag'=>$taget));
		}
	}

	private function resultBarang($barang, $jumlah, $kategori, $harga)
	{
		return "".$barang."  (".$jumlah." ".$kategori." X ".$harga.")";
	}

	private function hitunganTotal($pembayaran ,$totalharga)
	{
		$getTeks = "";
		$getTeks.='<tr>';
		$getTeks.='<td colspan="4" style="color:#00a65a;"><strong>Total harga barang keseluruhan</strong></td>';
		$getTeks.='<td style="color:white; background-color: #00a65a;"><strong>Rp. '.$totalharga.'</strong></td>';
		$getTeks.='</tr>';
		//
		$getTeks.='<tr>';
		$getTeks.='<td colspan="4" style="color:#ff851b;"><strong>Uang yang dibayarkan</strong></td>';
		$getTeks.='<td style="color:white; background-color:#ff851b; "><strong>Rp. '.$pembayaran.'</strong></td>';
		$getTeks.='</tr>';
		//
		$getTeks.='<tr>';
		$getTeks.='<td colspan="4" style="color:#3c8dbc;"><strong>Uang kembalian</strong></td>';
		$getTeks.='<td style="color:white; background-color: #00c0ef;"><strong>Rp. '.((int) $pembayaran - $totalharga).'</strong></td>';
		$getTeks.='</tr>';
		return $getTeks;
	}

	private function input_penjualan($deskripsi_barang, $total_harga, $pembayaran, $kembalian)
	{
		$pass;
		$tanggal = (String) date('d/m/Y');
		$sql = "insert into penjualan (id,deskripsi_barang,total_harga,pembayaran,kembalian,tanggal,id_user) value ";
		$sql.= "(NULL, '".$deskripsi_barang."','".$total_harga."','".$pembayaran."','".$kembalian."','".$tanggal."','')";
		$select = $this->db->query($sql);
		$pass = $select;
		return $pass;
	}

	private function get_update_barang($param)
	{
		$this->penjualan_m->updateStokbarang($param);
	}
	/* <--batas fungsi untuk penjualan -->*/
  
  	public function panggil_data_penjualan(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
  		$query = "SELECT * from penjualan ORDER BY id DESC limit $index, $length";
  		$sql = $this->db->query($query);
  		$get = $sql->result_array();
  		$result = $this->getPenjualanstr($get);
  		echo json_encode(array('data'=>$result));
  	}

  	private function getPenjualanstr($param = array()){
  		$s = "";
  		foreach ($param as $value) {
  			$s.='<tr>';
  			$s.='<td>'.$value['id'].'</td>';
  			$s.='<td>'.$value['deskripsi_barang'].'</td>';
  			$s.='<td>'.$value['total_harga'].'</td>';
  			$s.='<td>'.$value['pembayaran'].'</td>';
  			$s.='<td>'.$value['kembalian'].'</td>';
  			$s.='<td>'.$value['tanggal'].'</td>';
  			$s.='<td> <button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button></td>';
  			$s.='</tr>';
  		}
  		return $s;
  	}

    public function panggil_data_barang_jual(){
      // panggil data barang admin
      $index = $_GET['index'];
      $length = $_GET['length'];
      $query = "SELECT a.id_barang, a.nama_barang,c.keterangan , a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b, kategori c WHERE a.id_penempatan = b.id_penempatan AND a.id_kategori = c.id_kategori ORDER BY a.id_barang DESC limit $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangstr($get);
      echo json_encode(array('data'=>$result));
    }

  	public function tampil_cari_penjualan(){
  		$cari = $_GET['index'];
  		$query = "SELECT * from penjualan  where tanggal LIKE '%$cari%' ORDER BY id DESC";
  		$sql = $this->db->query($query);
  		$data = $sql->result_array();
  		$count = $sql->num_rows();
  		if($count > 2){
  			$query = "SELECT * from penjualan  where tanggal LIKE '%$cari%' ORDER BY id DESC limit 0, 2";
  			$sql = $this->db->query($query);
  			$data = $sql->result_array();
  			$hal = ceil($count / 2);
  			die(json_encode( array('result'=>$this->getPenjualanstr($data), 'maxhal'=>$hal, 'countData'=>$count) ));
  		}else{
  			if($count < 1){
  				die(json_encode(array('result'=>'<p>No data</p>', 'maxhal'=>false, 'countData'=>0)));	
  			}else{
  				die(json_encode(array('result'=>$this->getPenjualanstr($data), 'maxhal'=>false, 'countData'=>$count)));
  			}
  		}
  	}

  	
  	public function panggil_data_cari_penjualan(){
  		// untuk data penjualan
  		$index = $_GET['index'];
  		$length = $_GET['length'];
  		$cari = $_GET['cari'];
  		$query = "SELECT * from penjualan where tanggal LIKE '%$cari%' ORDER BY id DESC limit $index, $length";
  		$sql = $this->db->query($query);
  		$get = $sql->result_array();
  		$result = $this->getPenjualanstr($get);
  		die( json_encode( array('data'=>$result) ) );
  	}
  	public function tampil_data_penjualan(){
  		// untuk data penjualan
  		$id = $_POST['id'];
  		$query = "SELECT * FROM penjualan where id='$id'";
  		$sql = $this->db->query($query);
  		$get = $sql->result_array();
  		$deskripsi_barang = $get[0]['deskripsi_barang'];
  		$deskripsi_barang = explode(',', $deskripsi_barang);
  		$string_deskripsi = '';
  		$no = 0;
  		foreach ($deskripsi_barang as $data) {
  			$no++;
  			$string_deskripsi.="<strong>".$no.". ".$data.'</strong><br/>';
  		}
  		$get[0]['deskripsi_barang'] = $string_deskripsi;
  		die(json_encode($get));
  	}

    # Penanganan level Barang jual

    private function getBarangstr($param = array()){
      $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['keterangan'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['stok'].'</td>';
                        $s.='<td>'.$key['nama_penempatan'].'</td>';
                        if($_SESSION['keterangan'] != 'Kasir'){
                          $s.='<td>'.$this->buttonOption('editable').'</td>';
                        }else{
                          $s.='<td>'.'<button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>'.'</td>';
                        }
                      $s.='</tr>';
        }
        return $s;
    }

    public function tampil_seluruh_data_barang_jual(){
      $id = $_POST['id'];
      $sql = "SELECT a.id_barang, a.nama_barang,a.harga,a.stok,b.nama_jenis,c.nama_kategori,c.keterangan from barang_jual a,jenis b,kategori c where a.id_jenis_barang = b.id_jenis_barang AND a.id_kategori = c.id_kategori and a.id_barang='$id'";
      $result = $this->db->query($sql);
      if($result->num_rows() == 1){
        echo  json_encode(array('hasil'=>$result->result_array()));
      }else{
        echo json_encode(array('hasil'=>'failed'));
      }  
    }

    public function pencarian_data_barang_jual(){
        $atribut = $_GET['atribut'];
        $cari = $_GET['cari'];
        $q = $atribut.' LIKE '."'%".$cari."%'";
        $query = "SELECT a.id_barang, a.nama_barang,c.keterangan, a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b, kategori c where a.id_penempatan = b.id_penempatan GROUP BY a.id_barang HAVING $q";
        $sql = $this->db->query($query);
        $count = $sql->num_rows();
        $indexCount = 8;
        $data['next'] = 'Tidak ada';
        $data['maxHal'] = 0;
        if($count > $indexCount){
          $query = "SELECT a.id_barang, a.nama_barang,c.keterangan, a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b, kategori c where a.id_penempatan = b.id_penempatan GROUP BY a.id_barang HAVING $q LIMIT 0, $indexCount";
          $sql = $this->db->query($query);
          $data['next'] = 'ada';
          $data['maxHal'] = ceil($count / $indexCount);
        }
        $result = $sql->result_array();
        $data['data'] = $this->getBarangstr($result);
        $data['countData'] = $count;
        die( json_encode( $data ) );
    }
    public function pencarian_data_barang_jual_next(){
      // untuk data barang
      $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT a.id_barang, a.nama_barang,c.keterangan, a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b, kategori c where a.id_penempatan = b.id_penempatan GROUP BY a.id_barang HAVING $q LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangstr($get);
      echo json_encode( array('data'=>$result) );
    }
  	public function tampil_edit_barang(){
  		$id = $_GET['id'];
  		$str = "";
  		$q = "SELECT a.id_barang, a.nama_barang, a.harga, a.id_kategori, c.nama_kategori, a.id_penempatan, d.nama_penempatan, a.stok, a.stok_maksimum, a.id_barang_beli, e.nama_barang AS nama_barang_beli FROM barang_jual a, kategori c, penempatan d, barang_beli e WHERE a.id_kategori = c.id_kategori AND a.id_penempatan = d.id_penempatan AND a.id_barang_beli = e.id_barang AND a.id_barang =  '$id'";
  		$sql = $this->db->query($q);
  		$row = $sql->row();

  		$idBarang = $row->id_barang;
  		$namaBarang = $row->nama_barang;
  		$harga = $row->harga;
  		$idKategori = $row->id_kategori;
  		$namaKategori = $row->nama_kategori;
  		$idPenempatan = $row->id_penempatan;
  		$namaPenempatan = $row->nama_penempatan;
  		$stok = $row->stok;
  		$stokMaksimum = $row->stok_maksimum;
      $id_barang_beli = $row->id_barang_beli;
      $nama_barang_beli = $row->nama_barang_beli;
  		$str.='<div class="form-group">
                    <label>Koda Barang</label>
                    <input type="text" name="id_barang" class="form-control" value="'.$idBarang.'" readonly>
                  </div>';
  		$str.='<div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="'.$namaBarang.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga_barang" class="form-control" value="'.$harga.'">
                  </div>';
        // untuk form jenis barang
        // 

        // untuk form kategori barang
        $str.='<div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="kategori_barang">
                    <option value="'.$idKategori.'">'.$namaKategori.'</option>';
        $qkategoriBarang = $this->db->query("SELECT * from kategori where id_kategori != '$idKategori'");
        foreach($qkategoriBarang->result() as $v){
        	$str.='<option value="'.$v->id_kategori.'">'.$v->nama_kategori.'</option>';
        }
        $str.='</select></div>';
        //
        $str.='<div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="text" class="form-control" name="stok_barang" value="'.$stok.'">
                  </div>';
        $str.='<div class="form-group">
                    <label>Jumlah Maksimum Stok</label>
                    <input type="text" class="form-control" name="stok_maksimum_barang" value="'.$stokMaksimum.'">
                  </div>';
        // untuk form penempatan barang
        $str.='<div class="form-group">
                    <label>Penempatan barang</label>
                    <select class="form-control" name="penempatan_barang">
                      <option value="'.$idPenempatan.'">'.$namaPenempatan.'</option>';
        $qpenempatanBarang = $this->db->query("SELECT * FROM penempatan where id_penempatan != '$idPenempatan'");
        foreach ($qpenempatanBarang->result() as $v) {
        	$str.='<option value="'.$v->id_penempatan.'">'.$v->nama_penempatan.'</option>';
        }
        $str.='</select></div>';

        $str.='<div class="form-group">
                    <label>Pilih barang beli</label>
                    <div id="tempat-select">
                    <select class="form-control select2edit" name="id_barang_beli">
                      <option value="'.$id_barang_beli.'">'.$nama_barang_beli.'</option>';
        $str.='</select></div></div>';
        die($str);
  	}
  	public function update_barang(){
  		$idBarang = $_GET['id_barang'];
  		$namaBarang = $_GET['nama_barang'];
		$hargaBarang = $_GET['harga_barang'];
		$kategoriBarang = $_GET['kategori_barang'];
		$stokBarang = $_GET['stok_barang'];
		$stokMaksimumBarang = $_GET['stok_maksimum_barang'];
		$penempatanBarang = $_GET['penempatan_barang'];
    $id_barang_beli = trim($_GET['id_barang_beli']);

  		$query = "UPDATE  `dbtoko`.`barang_jual` SET 
  		`nama_barang` =  '".$namaBarang."',
  		`harga` = '".$hargaBarang."',
  		`id_kategori` = '".$kategoriBarang."',
  		`id_penempatan` =  '".$penempatanBarang."',
  		`stok` =  '".$stokBarang."',
  		`stok_maksimum` =  '".$stokMaksimumBarang."',
      `id_barang_beli` = '".$id_barang_beli."' WHERE  `barang_jual`.`id_barang` =  '".$idBarang."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  		
  	}
  	public function hapus_barang(){
  		$idbarang = $_GET['id_barang'];
  		$query = "DELETE FROM barang_jual where id_barang='".$idbarang."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}

  	private function get_id_barang(){
		$sql = "select max(id_barang) as maxKode from barang_jual";
		$getSql = $this->db->query($sql);
		$get = $getSql->result_array();
		$kode = $get[0]['maxKode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 4, 4);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		
		$char = "BRJL";
		$kodeBarang = $char."".sprintf("%04s", $no);
		return $kodeBarang;
	}
  	public function tambah_barang(){
		$idBarang = $this->get_id_barang();
		$namaBarang = $_POST['nama_barang'];
		$hargaBarang = $_POST['harga_barang'];
		$kategoriBarang = $_POST['kategori_barang'];
		$stokBarang = $_POST['stok_barang'];
		$stokMaksimumBarang = $_POST['stok_maksimum_barang'];
		$penempatanBarang = $_POST['penempatan_barang'];
    $id_barang_beli = trim($_POST['id_barang_beli']);
		$query = "insert into barang_jual values ('$idBarang','$namaBarang','$hargaBarang','$kategoriBarang','$penempatanBarang','$stokBarang','$stokMaksimumBarang', '$id_barang_beli')";
		if($this->db->simple_query($query)){
			die( json_encode( array('result'=>'sukses') ) );
		}else{
			die( json_encode( array('result'=>'gagal') ) );
		}
	}
public function refresh_barang(){
    // khusus admin
    $query = "SELECT a.id_barang, a.nama_barang, a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b WHERE a.id_penempatan = b.id_penempatan ORDER BY a.id_barang DESC";
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $indexCount = 8;
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT a.id_barang, a.nama_barang, a.harga, a.stok, b.nama_penempatan FROM barang_jual a, penempatan b WHERE a.id_penempatan = b.id_penempatan ORDER BY a.id_barang DESC limit 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getBarangstr($result);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }

	# penanganan pada level penempatan
  	private function getPenempatanstr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_penempatan'].'</td>';
                        $s.='<td>'.$key['nama_penempatan'].'</td>';
                        $s.='<td>'.$key['keterangan'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}

  	private function get_id_penempatan(){
  		$this->db->select_max('id_penempatan', 'max_kode');
		$query = $this->db->get('penempatan');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 2, 3);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "PN";
		$kodeBarang = $char."".sprintf("%03s", $no);
		return $kodeBarang;
	}
  	public function panggil_data_penempatan(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
		$sql = $this->db->get('penempatan', $length, $index);
		$get = $sql->result_array();
		$result = $this->getPenempatanstr($get);
		echo json_encode(array('data'=>$result));
  	}
  	function input_data_penempatan(){
  		$id = $this->get_id_penempatan();
  		$nama_penempatan = $_POST['nama_penempatan'];
  		$keterangan = $_POST['keterangan'];
  		$data = array(
        'id_penempatan' => $id,
        'nama_penempatan' => $nama_penempatan,
        'keterangan' => $keterangan
		);

		if($this->db->insert('penempatan', $data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}
  	function hapus_penempatan(){
  		$idpenempatan = $_GET['id_penempatan'];
  		$query = "DELETE FROM penempatan where id_penempatan='".$idpenempatan."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	public function update_penempatan(){
  		$idPenempatan = $_GET['id_penempatan'];
  		$namaPenempatan = $_GET['nama_penempatan'];
		$keterangan = $_GET['keterangan'];

  		$query = "UPDATE  `dbtoko`.`penempatan` SET 
  		`nama_penempatan` =  '".$namaPenempatan."',
  		`keterangan` = '".$keterangan."' WHERE `penempatan`.`id_penempatan` =  '".$idPenempatan."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  		
  	}
  	public function refresh_penempatan(){
		// khusus admin
		$sql = $sql = $this->db->get('penempatan');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $sql = $this->db->get('penempatan', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count / 2);
		}
		$result = $sql->result_array();
		$data['data'] = $this->getPenempatanstr($result);
		$data['countData'] = $count;
		die( json_encode( $data ) );
	}
	
	#penanganan pada level jenis
	private function getJenisstr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_jenis_barang'].'</td>';
                        $s.='<td>'.$key['nama_jenis'].'</td>';
                        $s.='<td>'.$key['keterangan'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}
	private function get_id_jenis(){
  		$this->db->select_max('id_jenis_barang', 'max_kode');
		$query = $this->db->get('jenis');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 2, 3);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "JN";
		$kodeBarang = $char."".sprintf("%03s", $no);
		return $kodeBarang;
	}
	public function panggil_data_jenis(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
		$sql = $this->db->get('jenis', $length, $index);
		$get = $sql->result_array();
		$result = $this->getJenisstr($get);
		echo json_encode(array('data'=>$result));
  	}
	function input_data_jenis(){
  		$id = $this->get_id_jenis();
  		$nama_jenis = $_POST['nama_jenis'];
  		$keterangan = $_POST['keterangan'];
  		$data = array(
        'id_jenis_barang' => $id,
        'nama_jenis' => $nama_jenis,
        'keterangan' => $keterangan
		);

		if($this->db->insert('jenis', $data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}
	function hapus_jenis(){
  		$idjenis = $_GET['id_jenis_barang'];
  		$query = "DELETE FROM jenis where id_jenis_barang='".$idjenis."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	public function update_jenis(){
  		$idJenis = $_GET['id_jenis_barang'];
  		$namaJenis = $_GET['nama_jenis'];
		$keterangan = $_GET['keterangan'];

  		$query = "UPDATE  `dbtoko`.`jenis` SET 
  		`nama_jenis` =  '".$namaJenis."',
  		`keterangan` = '".$keterangan."' WHERE `jenis`.`id_jenis_barang` =  '".$idJenis."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  		
  	}
  	public function refresh_jenis(){
		// khusus admin
		$sql = $sql = $this->db->get('jenis');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $sql = $this->db->get('jenis', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count / 2);
		}
		$result = $sql->result_array();
		$data['data'] = $this->getJenisstr($result);
		$data['countData'] = $count;
		die( json_encode( $data ) );
	}
	
	#penanganan pada level kategori
	private function getKategoristr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_kategori'].'</td>';
                        $s.='<td>'.$key['nama_kategori'].'</td>';
                        $s.='<td>'.$key['keterangan'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}
	private function get_id_kategori(){
  		$this->db->select_max('id_kategori', 'max_kode');
		$query = $this->db->get('kategori');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 3, 3);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "KTR";
		$kodeBarang = $char."".sprintf("%03s", $no);
		return $kodeBarang;
	}
	public function panggil_data_kategori(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
		$sql = $this->db->get('kategori', $length, $index);
		$get = $sql->result_array();
		$result = $this->getKategoristr($get);
		echo json_encode(array('data'=>$result));
  	}
	function input_data_kategori(){
  		$id = $this->get_id_kategori();
  		$nama_kategori = $_POST['nama_kategori'];
  		$keterangan = $_POST['keterangan'];
  		$data = array(
        'id_kategori' => $id,
        'nama_kategori' => $nama_kategori,
        'keterangan' => $keterangan
		);

		if($this->db->insert('kategori', $data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}
	function hapus_kategori(){
  		$idkategori = $_GET['id_kategori'];
  		$query = "DELETE FROM kategori where id_kategori='".$idkategori."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	public function update_kategori(){
  		$idKategori = $_GET['id_kategori'];
  		$namaKategori = $_GET['nama_kategori'];
		$keterangan = $_GET['keterangan'];

  		$query = "UPDATE  `dbtoko`.`kategori` SET 
  		`nama_kategori` =  '".$namaKategori."',
  		`keterangan` = '".$keterangan."' WHERE `kategori`.`id_kategori` =  '".$idKategori."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  		
  	}
  	public function refresh_kategori(){
		// khusus admin
		$sql = $sql = $this->db->get('kategori');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $sql = $this->db->get('kategori', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count / 2);
		}
		$result = $sql->result_array();
		$data['data'] = $this->getKategoristr($result);
		$data['countData'] = $count;
		die( json_encode( $data ) );
	}
	
	#penanganan pada level supplier
	private function getSupplierstr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_supplier'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        $s.='<td>'.$key['telp'].'</td>';
						            $s.='<td>'.$key['alamat'].'</td>';
						            $s.='<td>'.$key['kota'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}
	private function get_id_supplier(){
  		$this->db->select_max('id_supplier', 'max_kode');
		$query = $this->db->get('supplier');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 3, 3);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "SPL";
		$kodeBarang = $char."".sprintf("%03s", $no);
		return $kodeBarang;
	}
	public function panggil_data_supplier(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
		$sql = $this->db->get('supplier', $length, $index);
		$get = $sql->result_array();
		$result = $this->getSupplierstr($get);
		echo json_encode(array('data'=>$result));
  	}
	function input_data_supplier(){
  		$id = $this->get_id_supplier();
  		$nama_supplier = $_POST['nama_supplier'];
  		$telp = $_POST['telp'];
		$alamat = $_POST['alamat'];
		$kota = $_POST['kota'];
  		$data = array(
        'id_supplier' => $id,
        'nama_supplier' => $nama_supplier,
        'telp' => $telp,
		'alamat' => $alamat,
		'kota' => $kota
		);

		if($this->db->insert('supplier', $data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}
	function hapus_supplier(){
  		$idSupplier = $_GET['id_supplier'];
  		$query = "DELETE FROM supplier where id_supplier='".$idSupplier."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	public function update_supplier(){
  		$idSupplier = $_GET['id_supplier'];
  		$namaSupplier = $_GET['nama_supplier'];
		$telp = $_GET['telp'];
		$alamat = $_GET['alamat'];
		$kota = $_GET['kota'];

  		$query = "UPDATE `dbtoko`.`supplier` SET 
  		`nama_supplier` = '".$namaSupplier."',
  		`telp` = '".$telp."',
		`alamat` = '".$alamat."',
		`kota` = '".$kota."' WHERE `supplier`.`id_supplier` = '".$idSupplier."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}

  	public function refresh_supplier(){
		// khusus admin
		$sql = $this->db->get('supplier');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $sql = $this->db->get('supplier', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count / 2);
		}
		$result = $sql->result_array();
		$data['data'] = $this->getSupplierstr($result);
		$data['countData'] = $count;
		die( json_encode( $data ) );
	}

	# author : Andi Febianto
	# email : andi_febinto@yahoo.com
	# Khusus untuk penanganan data barang beli

	function get_id_barang_beli(){
  		$this->db->select_max('id_barang', 'max_kode');
		$query = $this->db->get('barang_beli');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 4, 4);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "BRBL";
		$kodeBarang = $char."".sprintf("%04s", $no);
		return $kodeBarang;
	}

	function input_data_barang_beli(){
  	$id = $this->get_id_barang_beli();
  	$nama_barang = $_POST['nama_barang'];
  	$id_kategori = $_POST['id_kategori'];
		$harga = $_POST['harga'];
		$id_supplier = $_POST['id_supplier'];
  		$data = array(
        'id_barang' => $id,
        'nama_barang' => $nama_barang,
        'id_kategori' => $id_kategori,
		    'harga' => $harga,
		    'id_supplier' => $id_supplier
		);

		if($this->db->insert('barang_beli', $data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  }

  private function getBarangbelistr($param = array()){
      $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['nama_kategori'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
        }
        return $s;
    }

  public function refresh_barang_beli(){
    // khusus admin
    $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier ORDER BY a.id_barang DESC";
    $indexCount = 2;
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier ORDER BY a.id_barang DESC limit 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getBarangbelistr($result);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }

  public function panggil_data_barang_beli(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier ORDER BY a.id_barang DESC limit $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangbelistr($get);
      echo json_encode(array('data'=>$result));
    }
    function pencarian_data_barang_beli_next(){
      $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier GROUP BY a.id_barang HAVING $q LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangbelistr($get);
      echo json_encode( array('data'=>$result) );
    }
    
    public function hapus_barang_beli(){
      $idbarang = $_GET['id_barang'];
      $query = "DELETE FROM barang_beli where id_barang='".$idbarang."'";
      if($this->db->simple_query($query)){
        die(json_encode( array('result'=>'sukses') ));
      }
      die(json_encode( array('result'=>'gagal') ));
    }
    public function tampil_edit_barang_beli(){
      $id_barang = $_GET['id_barang'];
      $nama_barang = $_GET['nama_barang'];
      $kategori = $_GET['kategori'];
      $harga = $_GET['harga'];
      $supplier = $_GET['supplier'];
      $sql = $this->db->query("SELECT id_supplier, id_kategori from barang_beli where id_barang = '$id_barang'")->result_array();
      $id_supplier = $sql[0]['id_supplier'];
      $id_kategori = $sql[0]['id_kategori'];
      $str = "";
      $str.='<div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="id_barang" class="form-control" value="'.$id_barang.'" readonly>
              </div>';
      $str.='<div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="'.$nama_barang.'">
              </div>';
      $str.='<div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="id_kategori">
                    <option value="'.$id_kategori.'">'.$kategori.'</option>';
          $sql = $this->db->query("select * from kategori where id_kategori != '$id_kategori'");
          foreach ($sql->result_array() as $arry) {
              $str.='<option value="'.$arry['id_kategori'].'">'.$arry['nama_kategori'].'</option>';
          }
      $str.='</select></div>';
      $str.='<div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" value="'.$harga.'">
              </div>';
       $str.='<div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control" name="id_supplier">
                    <option value="'.$id_supplier.'">'.$supplier.'</option>';
          $sql = $this->db->query("select * from supplier where id_supplier != '$id_supplier'");
          foreach ($sql->result_array() as $arry) {
              $str.='<option value="'.$arry['id_supplier'].'">'.$arry['nama_supplier'].'</option>';
          }
          
      $str.='</select></div>';
      echo $str;
    }
    public function update_barang_beli(){
      $id_barang = $_GET['id_barang'];
      $nama_barang = $_GET['nama_barang'];
      $id_kategori = $_GET['id_kategori'];
      $harga = $_GET['harga'];
      $id_supplier = $_GET['id_supplier'];

      $query = "UPDATE `dbtoko`.`barang_beli` SET 
      `nama_barang` = '".$nama_barang."',
      `id_kategori` = '".$id_kategori."',
    `harga` = '".$harga."',
    `id_supplier` = '".$id_supplier."' WHERE `barang_beli`.`id_barang` = '".$id_barang."'";
      if($this->db->simple_query($query)){
        die(json_encode( array('result'=>'sukses') ));
      }
      die(json_encode( array('result'=>'gagal') ));
    }

    function pencarian_data_barang_beli(){
      $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier GROUP BY a.id_barang HAVING $q";
      $sql = $this->db->query($query);
      $count = $sql->num_rows();
      $indexCount = 2;
      $data['next'] = 'Tidak ada';
      $data['maxHal'] = 0;
      if($count > $indexCount){
        $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier GROUP BY a.id_barang HAVING $q LIMIT 0, $indexCount";
        $sql = $this->db->query($query);
        $data['next'] = 'ada';
        $data['maxHal'] = ceil($count / $indexCount);
      }
      $result = $sql->result_array();
      $data['data'] = $this->getBarangbelistr($result);
      $data['countData'] = $count;
      die( json_encode( $data ) );
  }

  #Penanganan level pembelian barang
  function ambil_data_barang_beli(){
    $id = $_GET['id'];
    $query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier, c.alamat, c.telp from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier AND a.id_barang = '".$id."'";
    $sql = $this->db->query($query);
      if($sql->num_rows() == 1){
        $result = $sql->result_array();
        die( json_encode($result[0]) );
      }
  }

  function input_data_pembelian_barang(){
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

  function getdetailPembelianstr( $param ){
      $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['kategori'].'</td>';
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
                        // status
                        $s.='<td>';
                        if($key['status'] == 'belum'){
                          $s.='<span class="label  label-danger">'.$key['status'].'</span>';
                        }else{
                          $s.='<span class="label  label-success">'.$key['status'].'</span>';
                        }
                        $s.='</td>';
                        $s.='<td><button data-target="#modal-danger" data-cstarget="delPick" data-toggle="modal" class="btn btn-danger fa fa-trash-o no-padding" style="width:30px; height:24px;"></button></td>';
                      $s.='</tr>';
        }
        return $s;
  }
  function tampil_data_pembelian_detail(){
    # fungsi kelas yang digunakan untuk menampilkan
    # data lagi
      $index = $_GET['index'];
      $length = $_GET['length'];
      $tgl = $_GET['tanggal'];
      $query = "SELECT id_barang, nama_barang, kategori, jumlah, harga, nama_supplier, alamat, telp, acc, status FROM pembelian WHERE tanggal = '".$tgl."' LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getdetailPembelianstr($get);
      echo json_encode(array('data'=>$result));
  }
  function hapus_daftar_barang_beli_detail(){
    $idbarang = $_GET['id_barang'];
    $tanggal = $_GET['tanggal'];
      $query = "DELETE FROM pembelian WHERE id_barang='".$idbarang."' AND tanggal='".$tanggal."'";
      if($this->db->simple_query($query)){
        die(json_encode( array('result'=>'sukses') ));
      }
      die(json_encode( array('result'=>'gagal') ));
  }
  function refresh_daftar_barang_beli_detail(){
    if(!isset($_GET['tanggal'])){
      die( json_encode( array('data'=>'failed') ) );
    }
    $query = "SELECT id_barang, nama_barang, kategori, jumlah, harga, nama_supplier, alamat, telp, acc, status FROM pembelian WHERE tanggal =  '".$_GET['tanggal']."'";
    $indexCount = 2;
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT id_barang, nama_barang, kategori, jumlah, harga, nama_supplier, alamat, telp, acc, status FROM pembelian WHERE tanggal =  '".$_GET['tanggal']."' LIMIT 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getdetailPembelianstr($result);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }
  function get_cetak_pembelian_barang(){
    $tanggal = $_GET['tanggal'];
    $query = "SELECT nama_barang, kategori, jumlah, harga, nama_supplier, alamat, telp FROM pembelian WHERE tanggal =  '".$tanggal."'";
    $sql = $this->db->query($query);
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
  private function getDaftarbarangBelistr($param){
    $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['jumlah'].'</td>';
                        $s.='<td>'.$key['jumlah_item'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['tanggal'].'</td>';
                        $s.='<td><a href="'.base_url().'index.php/admin/pembelian_detail?q='.$key['tanggal'].'"><button type="button" class="btn  btn-primary fa fa-search"></button></a>
                        <button data-target="#modal-danger" data-toggle="modal" data-cstarget="delPick" class="btn btn-danger fa fa-trash-o"></button></td>';
                      $s.='</tr>';
        }
        return $s;
  }
  function panggil_data_daftar_pembelian(){
    $index = $_GET['index'];
      $length = $_GET['length'];
      $query = "SELECT id_barang, nama_barang, COUNT( id ) AS jumlah, SUM( jumlah ) AS jumlah_item, SUM( harga ) AS harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getDaftarbarangBelistr($get);
      echo json_encode(array('data'=>$result));
  }
  function hapus_daftar_pembelian(){
    $tanggal = $_GET['tanggal'];
      $query = "DELETE FROM pembelian WHERE tanggal='".$tanggal."'";
      if($this->db->simple_query($query)){
        die(json_encode( array('result'=>'sukses') ));
      }
      die(json_encode( array('result'=>'gagal') ));
  }
  function refresh_daftar_pembelian(){
    $query = "SELECT id_barang, nama_barang, COUNT( id ) AS jumlah, SUM( jumlah ) AS jumlah_item, SUM( harga ) AS harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC";
    $indexCount = 2;
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT id_barang, nama_barang, COUNT( id ) AS jumlah, SUM( jumlah ) AS jumlah_item, SUM( harga ) AS harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC LIMIT 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getDaftarbarangBelistr($result);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }

  // Untuk ACC pembelian barang
  private function getBarangacc($param, $acc){
    $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['kategori'].'</td>';
                        $s.='<td>'.$key['jumlah'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['tanggal'].'</td>';
                        if($acc == "sudah"){
                          $s.='<td><span class="label label-success">'.$key['acc'].'</span></td>';
                        }else{
                          $s.='<td><span class="label label-danger">'.$key['acc'].'</span></td>';
                        }
                        
                        $s.='<td>';
                        if($key['status'] == 'sudah'){
                          if($acc == "sudah"){
                            $s.='<button type="button" alt="'.$key['id'].'" class="btn btn-success fa fa-check" style="padding:5px 4px 6px 4px; height:24px; font-size:13px;">&nbsp;Ditambahkan</button>&nbsp;';
                          }
                        }else{
                          if($acc == "sudah"){
                            $s.='<button type="button" alt="'.$key['id'].'" data-cstarget="addStock" class="btn btn-primary fa fa-plus" style="padding:5px 4px 6px 4px; height:24px; font-size:13px;">&nbsp;Tambahkan</button>&nbsp;';
                          }
                        }
                        $s.='<button data-target="#modal-danger" data-toggle="modal" data-cstarget="delPick" class="btn btn-danger fa fa-trash-o no-padding" style="width:30px; height:24px;"></button></td>';
                      $s.='</tr>';
        }
        return $s;
  }
  public function panggil_data_barang_beli_acc($acc){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."' limit $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangacc($get, $acc);
      echo json_encode(array('data'=>$result));
    }

  function refresh_barang_beli_acc($acc){
    $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."'";
    $indexCount = 2;
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."' LIMIT 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getBarangacc($result, $acc);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }
  function hapus_barang_beli_acc($acc){
    $idbarang = $_GET['id_barang'];
    $tanggal = $_GET['tanggal'];
      $query = "DELETE FROM pembelian WHERE id_barang='".$idbarang."' AND tanggal='".$tanggal."' AND acc = '".$acc."'";
      if($this->db->simple_query($query)){
        die(json_encode( array('result'=>'sukses') ));
      }
      die(json_encode( array('result'=>'gagal') ));
  }
  function pencarian_data_pembelian_acc($acc){
    $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."' AND $q";
      $sql = $this->db->query($query);
      $count = $sql->num_rows();
      $indexCount = 2;
      $data['next'] = 'Tidak ada';
      $data['maxHal'] = 0;
      if($count > $indexCount){
        $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."' AND $q LIMIT 0, $indexCount";
        $sql = $this->db->query($query);
        $data['next'] = 'ada';
        $data['maxHal'] = ceil($count / $indexCount);
      }
      $result = $sql->result_array();
      $data['data'] = $this->getBarangacc($result, $acc);
      $data['countData'] = $count;
      die( json_encode( $data ) );
  }
  function pencarian_data_pembelian_acc_next($acc){
      $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = '".$acc."' AND $q LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangacc($get, $acc);
      echo json_encode( array('data'=>$result) );
    }

    #Fungsi level kasir untuk barang masuk
    private function getBarangmasukstr($param){
       $s = "";
        foreach ($param as $key) {
          $s.='<tr>';
                        $s.='<td>'.$key['id_barang'].'</td>';
                        $s.='<td>'.$key['nama_barang'].'</td>';
                        $s.='<td>'.$key['kategori'].'</td>';
                        $s.='<td>'.$key['jumlah'].'</td>';
                        $s.='<td>'.$key['harga'].'</td>';
                        $s.='<td>'.$key['tanggal'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        $s.='<td><button type="button" alt="'.$key['id'].'" data-cstarget="getCheck" class="btn btn-primary fa fa-check">&nbsp;&nbsp;Diterima</button></td>';
                      $s.='</tr>';
        }
        return $s;
    }
    public function panggil_data_barang_masuk(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $query = "SELECT id, id_barang, nama_barang, kategori, jumlah, harga, tanggal, nama_supplier FROM pembelian WHERE acc = 'belum' lIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      $result = $this->getBarangmasukstr($get);
      echo json_encode(array('data'=>$result));
    }
    public function pencarian_data_barang_masuk(){
        $atribut = $_GET['atribut'];
        $cari = $_GET['cari'];
        $q = $atribut.' LIKE '."'%".$cari."%'";
        $query = "SELECT id, id_barang, nama_barang, kategori, jumlah, harga, tanggal, nama_supplier FROM pembelian WHERE acc = 'belum' GROUP BY id HAVING $q";
        $sql = $this->db->query($query);
        $count = $sql->num_rows();
        $indexCount = 2;
        $data['next'] = 'Tidak ada';
        $data['maxHal'] = 0;
        if($count > $indexCount){
          $query = "SELECT id, id_barang, nama_barang, kategori, jumlah, harga, tanggal, nama_supplier FROM pembelian WHERE acc = 'belum' GROUP BY id HAVING $q LIMIT 0, $indexCount";
          $sql = $this->db->query($query);
          $data['next'] = 'ada';
          $data['maxHal'] = ceil($count / $indexCount);
        }
        $result = $sql->result_array();
        $data['data'] = $this->getBarangmasukstr($result);
        $data['countData'] = $count;
        die( json_encode( $data ) );
    }
    function pencarian_data_barang_masuk_next(){
      $atribut = $_GET['atribut'];
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $q = $atribut.' LIKE '."'%".$cari."%'";
      $query = "SELECT id, id_barang, nama_barang, kategori, jumlah, harga, tanggal, nama_supplier FROM pembelian WHERE acc = 'belum' GROUP BY id HAVING $q LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
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

    #fungsi level admin untuk tambahkan stok barang
    function get_data_barang_jual(){
      $id = $_GET['id'];
      $query = "SELECT id_barang, nama_barang, stok, stok_maksimum FROM barang_jual WHERE id_barang_beli = '$id'";
      $sql = $this->db->query($query);
      if($sql->num_rows() > 0){
        die( json_encode( array( 'data'=>$sql->result_array() ) ) );
      }
      die( json_encode( array('data'=>'failed') ) );
    }
    function tambah_stok_barang(){
      $data = array();
      for($i=0; $i<count($_GET['id_barang']); $i++){
        $dataV = array();
        foreach($_GET as $key => $value){
            $dataV[$key] = $value[$i];
        }
        array_push($data, $dataV);
      }
      // data update
      for ($i=0; $i<count($data); $i++) {
        $stok = $data[$i]['stok'];
        $tambahkan = $data[$i]['tambahkan'];
        $update_stok = $stok+$tambahkan;
        $data[$i]['stok'] = $update_stok;
        unset($data[$i]['tambahkan']);
      }
      if($this->db->update_batch('barang_jual', $data, 'id_barang') > 0){
        die(json_encode( array('result'=>'success') ));
      }
       die(json_encode( array('result'=>'failed') ));
  }
  function ubah_status_barang_beli(){
     $id = $_GET['id']; // merupakan id barang pada pembelian
      $data = array('status' => 'sudah');
      $where = "id = '$id'";
      $str = $this->db->update_string('pembelian', $data, $where);
      if($this->db->query($str)){
        die( json_encode( array('status'=>'success') ) );
      }
      die( json_encode( array('status' => 'failed') ) );
  }
  
}
?>