<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasirtoko extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('penjualan_m');
	}
	private function cek_login(){
		if( !(isset($_SESSION['id_user']) and isset($_SESSION['username']) and isset($_SESSION['nama']) and isset($_SESSION['keterangan'])) ){
			redirect('Login');
			die('Anda Belum melakukan login silahkan login terlebih dahulu');
		}else if( isset($_SESSION['keterangan']) and $_SESSION['keterangan'] != 'Kasir' ){
			redirect('Login/keluar');
		}
	}
	public function index()
	{
		$this->cek_login();
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/demoKasir.js"
		);
		$theTitle['title'] = "Kasir | Penjualan";
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Kasir';
		$menu['jumlah'] = $this->jumlah_barang_masuk();
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/kasir/index');
		$this->load->view('template/footer', $ekstensiJS);
	}
	public function barang(){
		$this->cek_login();
		$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$result['next'] = 'Tidak ada';
		$result['maxHal'] = 0;
		if($count > $indexCount){
			//
			$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang limit 0, $indexCount";
			$sql = $this->db->query($query);
			$result['next'] = 'ada';
			$result['maxHal'] = ceil($count/$indexCount);
		}
		$data = $sql->result_array();
		$result['data'] = $data;
		$result['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-kasir-barang.js"
		);
		$theTitle['title'] = "Kasir | Master Barang";
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Kasir';
		$menu['jumlah'] = $this->jumlah_barang_masuk();
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/kasir/tampil-barang', $result);
		$this->load->view('template/footer', $ekstensiJS);
	}
	private function view_filter_pencarian($data){
		$str = "";
		foreach ($data as $val) {
			$str.='<option value='.$val->name.'>'.$val->name.'</option>';
		}
		return $str;
	}
	public function penjualan(){
		$query = "SELECT * FROM penjualan ORDER BY id DESC";
		$sql = $this->db->query($query);
		if($sql->num_rows() > 2){
			// jika data pertama yang ditampilkan berjumlah lebih dari 2
			$sqly = $this->db->query("SELECT * FROM penjualan ORDER BY id DESC limit 2");
			$count = $sql->num_rows();
			$result = $sqly->result_array();
			$data['data'] = $result;
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count / 2);
			$data['countData'] = $count;
		}else{
			// jika tidak
			$count = $sql->num_rows();
			$result = $sql->result_array();
			$data['data'] = $result;
			$data['next'] = 'Tidak ada';
			$data['maxHal'] = 0;
			$data['countData'] = $count;
		}

		$this->load->view('template/tampil-penjualan', $data);
	}
	function penjualanlp(){
		$this->cek_login();
		$query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal
		FROM penjualan
		GROUP BY tanggal ORDER BY id DESC";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal
			FROM penjualan
			GROUP BY tanggal ORDER BY id DESC LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
			base_url()."dist/js/plugin-btn-admin-penjualan.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Kasir';
		$menu['jumlah'] = $this->jumlah_barang_masuk();
		$theTitle['title'] = "Kasir | Laporan Penjualan";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/kasir/penjualan', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function penjualan_detail(){
		$this->cek_login();
		$tanggal = $_GET['tgl'];
		$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.tanggal = '$tanggal' ORDER BY a.id DESC";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.tanggal = '$tanggal' ORDER BY a.id DESC LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$data['tanggal'] = $tanggal;
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-penjualan.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Kasir';
		$menu['jumlah'] = $this->jumlah_barang_masuk();
		$theTitle['title'] = "Admin | Penjualan - ".$tanggal;
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/kasir/penjualan_detail', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function barang_masuk(){
		$this->cek_login();
		$query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND acc = 'belum'";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$result['next'] = 'Tidak ada';
		$result['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND acc = 'belum' LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$result['next'] = 'ada';
			$result['maxHal'] = ceil($count/$indexCount);
		}
		$data = $sql->result_array();
		$result['data'] = $data;
		$result['countData'] = $count;
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Kasir';
		$menu['jumlah'] = $this->jumlah_barang_masuk();
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-kasir-barangmsk.js"
		);
		$theTitle['title'] = "Kasir | Barang Masuk";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/kasir/barang-masuk', $result);
		$this->load->view('template/footer', $ekstensiJS);
	}
	private function jumlah_barang_masuk(){
		$sql = $this->db->query("SELECT COUNT(id_barang) as jumlah FROM pembelian WHERE acc = 'belum'");
		$jumlah = $sql->result_array()[0];
		return $jumlah['jumlah'];
	}
	private function get_code(){
		$sql = "select max(id_barang) as maxKode from barang_jual";
		$getSql = $this->db->query($sql);
		$get = $getSql->result_array();
		// $kode = $get[0]['maxKode'];
		$kode = "BRJL0000";
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


}
