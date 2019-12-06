<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_penjualan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('penjualan_m');
	}
	private function getPenjualanstr($param){
		$s = "";
		foreach ($param as $data) {
			$s.='<tr>';
			$s.='<td><center>'.$data['total_penjualan'].'</center></td>';
			$s.='<td><center>'.$data['total_item'].'</center></td>';
			$s.='<td>'.$data['total_harga'].'</td>';
			$s.='<td>'.$data['tanggal'].'</td>';

			$s.=($_SESSION['keterangan'] == 'Admin') ? '<td><a href="'.base_url().'index.php/admin/penjualan_detail?tgl='.$data['tanggal'].'"><button type="button" data-toggle="modal" class="btn btn-primary fa fa-eye"></button></a> ':'<td><center><a href="'.base_url().'index.php/kasirtoko/penjualan_detail?tgl='.$data['tanggal'].'"><button type="button" data-toggle="modal" class="btn btn-primary fa fa-eye"> Lihat Detail</button></a></center> ';

			if($_SESSION['keterangan'] == 'Admin')
			{
			$s.='<button type="button" data-toggle="modal" data-cstarget="delPick" data-target="#modal-danger" class="btn btn-danger fa fa-trash"></button>';
			}
            $s.='</td>';
			$s.="</tr>";
		}
		return $s;
	}
	function panggil_data_penjualan(){
      $index = $_GET['index'];
      $length = $_GET['length'];
      $get = $this->penjualan_m->data_penjualan_lanjut($index, $length);
      $result = $this->getPenjualanstr($get);
      echo json_encode(array('data'=>$result));
    }

   function refresh_data_penjualan(){
    $query = "SELECT SUM( jumlah_barang ) AS total_barang, SUM( jumlah_item ) AS total_item, COUNT( id ) AS jumlah_penjualan, SUM( total_harga ) AS total_harga, tanggal FROM  `penjualan` GROUP BY tanggal ORDER BY id DESC";
    $indexCount = 8;
    $sql = $this->db->query($query);
    $count = $sql->num_rows();
    $data['next'] = 'Tidak ada';
    $data['maxHal'] = 0;
    if($count > $indexCount){
      $query = "SELECT SUM( jumlah_barang ) AS total_barang, SUM( jumlah_item ) AS total_item, COUNT( id ) AS jumlah_penjualan, SUM( total_harga ) AS total_harga, tanggal FROM  `penjualan` GROUP BY tanggal ORDER BY id DESC LIMIT 0, $indexCount";
      $sql = $this->db->query($query);
      $data['next'] = 'ada';
      $data['maxHal'] = ceil($count / $indexCount);
    }
    $result = $sql->result_array();
    $data['data'] = $this->getPenjualanstr($result);
    $data['countData'] = $count;
    die( json_encode( $data ) );
  }
  function cari_penjualan(){
      $cari = $_GET['cari'];
      $data = $this->penjualan_m->cari_data_penjualan($cari);
      $data['data'] = $this->getPenjualanstr($data['data']);
      die( json_encode( $data ) );
  }
  function cari_penjualan_lanjut(){
      $cari = $_GET['cari'];
      $index = $_GET['index'];
      $length = $_GET['length'];
      $get = $this->penjualan_m->cari_data_penjualan_lanjut($cari, $index, $length);
      $result = $this->getPenjualanstr($get);
      echo json_encode( array('data'=>$result) );
    }
    function hapus_data_penjualan(){
  		$tanggal = $_GET['tanggal'];
  		$query = "DELETE FROM penjualan where tanggal='".$tanggal."'";
  		if($this->db->simple_query($query)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	function tampil_data_penjualan(){
  		// untuk data penjualan
  		$id = $_GET['id'];
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
  	private function getPenjualandetailstr($param){
  		$s = "";
		foreach ($param as $data) {
			$s.='<tr>';
			$s.='<td style="">'.$data['id'].'</td>';
			$s.='<td style="">'.$data['customer'].'</td>';
			$s.='<td>'.$data['nama_barang'].'</td>';
			$s.='<td>'.$data['satuan'].'</td>';
			$s.='<td>'.$data['jumlah'].'</td>';
			$s.='<td>'.$data['harga_jual'].'</td>';
			$s.='<td>'.$data['harga'].'</td>';
			$s.='<td>'.$data['tanggal'].'</td>';
			$s.="</tr>";
		}
		return $s;
  	}
  	function panggil_data_penjualan_detail(){
  		$tanggal = $_GET['tgl'];
  		$index = $_GET['index'];
  		$length = $_GET['length'];
      	$get = $this->penjualan_m->data_penjualan_detail_lanjut($tanggal ,$index, $length);
      	$result = $this->getPenjualandetailstr($get);
      	echo json_encode(array('data'=>$result));
  	}
  	function refresh_data_penjualan_detail(){
  		$tanggal = $_GET['tgl'];
  		$query = "SELECT * FROM penjualan WHERE tanggal='".$tanggal."'";
	    $indexCount = 8;
	    $sql = $this->db->query($query);
	    $count = $sql->num_rows();
	    $data['next'] = 'Tidak ada';
	    $data['maxHal'] = 0;
	    if($count > $indexCount){
	      $query = "SELECT * FROM penjualan WHERE tanggal='".$tanggal."' LIMIT 0, $indexCount";
	      $sql = $this->db->query($query);
	      $data['next'] = 'ada';
	      $data['maxHal'] = ceil($count / $indexCount);
	    }
	    $result = $sql->result_array();
	    $data['data'] = $this->getPenjualandetailstr($result);
	    $data['countData'] = $count;
	    die( json_encode( $data ) );
  	}
  	
  function cetak(){
    $tanggal = $_GET['tanggal'];
    $get = $this->penjualan_m->data_penjualan_cetak($tanggal);
    $this->print_detail($tanggal, $get);
  }
  private function print_detail($tanggal, $result){
    $this->load->library('godompdf');
    $tgl = $tanggal;
    $data['tanggal_cetak'] = 'Tanggal Cetak - '.date('d/m/Y');
    $data['tanggal_penjualan'] = $tgl;
    $data['data'] = $result;
     $data['nama'] = $_SESSION['nama'];
    $data['status'] = $_SESSION['keterangan'];
    $data['jam'] = date('H:i:s');
    $html = $this->load->view('template/admin/cetak_penjualan_detail/print', $data, true);
    $this->godompdf->generate($html, 'penjualan - '.$tgl);
  }

  #INPUT penjualan barang
  	private function id_penjualan_get($data){
  		$this->db->select_max('id', 'max_kode');
		$query = $this->db->get('penjualan');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 4, 5);
			$no++;
		}else{
			$no = (int) $kode;
			$no++;
		}
		$no_length = $no + count($data);
		$data_id = array();
		for($i=$no; $i<$no_length; $i++){
			$char = "PNJL";
			$kodePenjualan = $char."".sprintf("%05s", $i);
			array_push($data_id, $kodePenjualan);
		}
		return $data_id;
	}
	private function get_customer_data($post_id, $post_custom){
		$cus_data = array();
		for($i=0; $i<count($post_id); $i++){
			array_push($cus_data, $post_custom);
		}
		return $cus_data;
	}
  private function data_input_penjualan($post, $tgl){
  	$data['id'] = $this->id_penjualan_get($post['id_barang']);
  	$data['customer'] = $this->get_customer_data($post['id_barang'], $post['customer']);
  	$data['id_barang'] = $post['id_barang'];
  	$data['satuan'] = $post['satuan'];
  	$data['jumlah'] = $post['jumlah'];
  	$data['harga'] = $post['harga'];
  	$data['tanggal'] = $tgl;
  	$_SESSION['data_id_penjualan'] = $data['id'];
  	$_SESSION['data_pembayaran'] = $post['bayar'];
  	$_SESSION['data_customer'] = $post['customer'];
  	return $data;
  }
  private function data_update_barang($post){
  	$data['id_barang'] = $post['id_barang'];
  	$data['jumlah_stok'] = $post['stok_kurang'];
  	return $data;
  }
  public function simpan_penjualan()
	{
		$id_barang = $_POST['id_barang'];
		$barang = $_POST['barang'];
		$jumlah = $_POST['jumlah'];
		$satuan = $_POST['satuan'];
		$harga = $_POST['harga'];
		$pembayaran = $_POST['bayar'];
		$tanggal = array();
		$taget = "";
		$totalHarga = 0;
		$jumlah_item = 0;
		$no = 0;
		for($i=0; $i<count($barang); $i++){
			$no++;
			$taget.='<tr>';
				$taget.='<td>'.$no.'</td>';
				$taget.='<td>'.$barang[$i].'</td>';
				$taget.='<td>'.$satuan[$i].'</td>';
				$taget.='<td>'.$jumlah[$i].'</td>';
				$taget.='<td>'.$harga[$i].'</td>';
			$taget.='</tr>';

			$jumlah_item+=(int) $jumlah[$i];
			$totalHarga+=(int) $harga[$i];
			array_push($tanggal, date('d/m/Y'));
		}
		$taget.=$this->hitunganTotal($pembayaran, $totalHarga);

		$dataInput = $this->data_input_penjualan($_POST, $tanggal);
		if( $this->penjualan_m->tambah_data_penjualan($dataInput) ){
			$dataUpdate = $this->data_update_barang($_POST);
			$this->penjualan_m->updateStokbarang($dataUpdate);
			echo json_encode(array('status'=>'success', 'tag'=>$taget, 'customer'=>$_POST['customer']));
		}else{
			echo json_encode(array('status'=>'failed', 'tag'=>$taget, 'customer'=>$_POST['customer']));
		}
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
	function cetak_struk(){
		$data = $this->get_id_penjualan();
		$this->print_struk_detail($data);
	}
	private function print_struk_detail($data_r){
    	$this->load->library('godompdf');
    	$data['nota'] = date('dmyHis');
     	$data['nama'] = $_SESSION['nama'];
     	$data['customer'] = $_SESSION['data_customer'];
     	$data['tanggal'] = date('d/m/Y');
    	$data['jam'] = date('H:i:s');
    	$data['bayar'] = $_SESSION['data_pembayaran'];
    	$data['data'] = $data_r;
    	$html = $this->load->view('template/admin/cetak_penjualan/print', $data,true);
    	$this->godompdf->generate($html, 'Nota - '.$data['nota']);
  }

  function get_id_penjualan(){
  	$data_id = $_SESSION['data_id_penjualan'];
  	$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.id ";
  	$in = "IN(";
  	for ($i = 0; $i<count($data_id)-1; $i++) {
  		$in.="'".$data_id[$i]."', ";
  	}
  	$in.="'".$data_id[count($data_id) - 1]."')";
  	$query.=$in;
  	$get = $this->db->query($query);
  	return $get->result_array();
  }

	// fungsi get_barang digunakan untuk menampilkan databarang
	// dengan berdasarkan pencarian
	function cari_barang(){
		$jenis = $this->input->post('jenis', true);
		$cari = $this->input->post('pencarian', true);
		$this->penjualan_m->cari_data_barang($cari, $jenis);
	}
	function get_print_penjualan(){
		$tgl_mulai = trim($_POST['tgl_1']);
		$tgl_sampai = trim($_POST['tgl_2']);
		$data = $this->penjualan_m->data_laporan_penjualan_cetak($tgl_mulai, $tgl_sampai);
		$this->get_print_penjualan_($data, $tgl_mulai, $tgl_sampai);
	}
	function get_print_penjualan_($result, $tgl1, $tgl2){
		$this->load->library('godompdf');
    	$data['tanggal_cetak'] = 'Tanggal Cetak - '.date('d/m/Y').' '.date('H:i:s');
    	$data['data'] = $result;
     	$data['nama'] = $_SESSION['nama'];
    	$data['status'] = $_SESSION['keterangan'];
    	if( (strlen($tgl2) > 0) and (strlen($tgl1) > 0) ){
    		$data['periode'] = $tgl1." &nbsp;sampai&nbsp; ".$tgl2;
    	}else{
    		$data['periode'] = $tgl1;
    	}
    	$html = $this->load->view('template/admin/cetak_penjualan_detail/print_range', $data, true);
    	$this->godompdf->generate($html, 'Laporan Penjualan');
	}
	
 #batas class 
}
?>