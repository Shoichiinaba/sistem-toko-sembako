<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	private function cek_login(){
		if( !(isset($_SESSION['id_user']) and isset($_SESSION['username']) and isset($_SESSION['nama']) and isset($_SESSION['keterangan'])) ){
			redirect('Login');
			die('Anda Belum melakukan login silahkan login terlebih dahulu');
		}else if( isset($_SESSION['keterangan']) and $_SESSION['keterangan'] != 'Admin' ){
			redirect('Login/keluar');
		}
	}
	function index(){
		// dashboarb
		$this->cek_login();
		$theTitle['title'] = 'Admin | Home';
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/index');
		$this->load->view('template/footer');
	}
	private function form_penempatan_barang(){
		$query = "select * from penempatan";
		$sql = $this->db->query($query);
		$r = "";
		foreach ($sql->result_array() as $v) {
			$r.="<option value='$v[id_penempatan]'>".$v['keterangan']."</option>";
		}
		return $r;
	}
	private function form_supplier_barang(){
		$query = "select * from supplier";
		$sql = $this->db->query($query);
		$r = "";
		foreach ($sql->result_array() as $v) {
			$r.="<option value='$v[id_supplier]'>".$v['nama_supplier']."</option>";
		}
		return $r;
	}

	function penjualan(){
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
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Penjualan";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/admin/penjualanlp', $data);
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
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Penjualan - ".$tanggal;
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/admin/penjualan_detail', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function penempatan(){
		$this->cek_login();
		$query = "SELECT * from penempatan";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		$indexCount = 8;
		if($count > $indexCount){
			$query = "SELECT * from penempatan ORDER BY nama_penempatan ASC limit 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist\js\plugin-btn-admin-penempatan.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Penempatan";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/penempatan', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function pengguna(){
		$this->cek_login();
		$sql = $this->db->get('user');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		$indexCount = 8;
		if($count > $indexCount){
			$sql = $this->db->get('user', $indexCount, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$ekstensiJS['js_file'] = array(
			base_url()."dist\js\plugin-btn-admin-pengguna.js"
		);
		$theTitle['title'] = "Admin | Pengguna";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/pengguna', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function jenis(){
		$this->cek_login();
		$sql = $this->db->get('jenis');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $this->db->get('jenis', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/2);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist\js\plugin-btn-admin-jenis.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Jenis";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/jenis', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function kategori(){
		$this->cek_login();
		$sql = $this->db->get('kategori');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > 2){
			$sql = $this->db->get('kategori', 2, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/2);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist\js\plugin-btn-admin-kategori.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Kategori";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/kategori', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	
	function supplier(){
		$this->cek_login();
		$sql = $this->db->get('supplier');
		$count = $sql->num_rows();
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		$indexCount = 8;
		if($count > $indexCount){
			$sql = $this->db->get('supplier', $indexCount, 0);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-supplier.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Supplier";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/supplier', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}

	function barang(){
		$this->cek_login();
		$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang limit 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$data['form_penempatan_barang'] = $this->form_penempatan_barang();
		$data['form_supplier_barang'] = $this->form_supplier_barang();
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-barang.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Master Barang";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/master_barang', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}

	function barangbl(){
		$this->cek_login();
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
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$data['form_kategori_barang'] = $this->form_kategori_barang();
		$data['form_supplier_barang'] = $this->form_supplier_barang();
		$data['pencarian'] = $this->view_filter_pencarian( $sql->field_data() );
		$theTitle['title'] = "Admin | Barang Beli";
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-barangbl.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/data_beli_barang', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function pembelian(){
		$this->cek_login();
		$this->load->model('pembelian_m');
		$theTitle['title'] = "Admin | Pembelian";
		$ekstensiJS['js_file'] = array(
			base_url()."bower_components/select2/dist/js/select2.full.min.js",
			base_url()."dist/js/plugin-btn-admin-pembelian.js"
		);
		$data['result_option'] = $this->pembelian_m->ambil_data_master_barang_select();
		$data['tanggal'] = (String) date('d/m/Y');
		if(isset($_GET['alert']) and ($_GET['alert'] == "sukses")){
			$data['alert'] = "sukses";
		}
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/pembelian', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function daftarpembelian(){
		$this->cek_login();
		$query = "SELECT COUNT( id_barang ) AS total_barang, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT COUNT( id_barang ) AS total_barang, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-daftar-pembelian.js"
		);
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$data['status'] = $this->num_acc();
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Daftar Pembelian";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/daftar_pembelian', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	private function num_acc(){
		$acc = $this->db->query("SELECT COUNT(id_barang) as jumlah FROM pembelian WHERE acc = 'sudah'");
		$belum = $this->db->query("SELECT COUNT(id_barang) as jumlah FROM pembelian WHERE acc = 'belum'");
		$status = array(
			'acc' => $acc->result_array()[0]['jumlah'],
			'belum' => $belum->result_array()[0]['jumlah']
		);
		return $status;
	}
	function pembelian_detail(){
		$this->cek_login();
		if(isset($_GET['q'])){
			$data['tanggal'] = $_GET['q'];
		}
		$query = "SELECT a.id, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND tanggal = '".$data['tanggal']."'";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 8;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT a.id, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
				FROM pembelian a, master_barang b
				WHERE a.id_barang = b.id_barang
				AND tanggal = '".$data['tanggal']."' LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$ekstensiJS['js_file'] = array(
			base_url()."bower_components/select2/dist/js/select2.full.min.js",
			base_url()."dist/js/plugin-btn-admin-pembelian-detail.js"
		);
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Pembelian - ".$_GET['q'];
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu', $menu);
		$this->load->view('template/admin/pembelian_detail', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function belumAcc(){
		$this->cek_login();
		$query = "SELECT id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc FROM pembelian WHERE acc = 'belum'";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 2;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc FROM pembelian WHERE acc = 'belum' LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-acc.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Belum ACC";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/admin/belum_acc', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}
	function sudahAcc(){
		$this->cek_login();
		$query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = 'sudah'";
		$sql = $this->db->query($query);
		$count = $sql->num_rows();
		$indexCount = 2;
		$data['next'] = 'Tidak ada';
		$data['maxHal'] = 0;
		if($count > $indexCount){
			$query = "SELECT id,id_barang, nama_barang, kategori, jumlah, harga, tanggal, acc, status FROM pembelian WHERE acc = 'sudah' LIMIT 0, $indexCount";
			$sql = $this->db->query($query);
			$data['next'] = 'ada';
			$data['maxHal'] = ceil($count/$indexCount);
		}
		$result = $sql->result_array();
		$data['data'] = $result;
		$data['countData'] = $count;
		$ekstensiJS['js_file'] = array(
			base_url()."dist/js/plugin-btn-admin-acc.js"
		);
		$menu['keterangan'] = (isset($_SESSION['keterangan']))?$_SESSION['keterangan']:'Admin';
		$theTitle['title'] = "Admin | Sudah ACC";
		$this->load->view('template/header', $theTitle);
		$this->load->view('template/menu',$menu);
		$this->load->view('template/admin/sudah_acc', $data);
		$this->load->view('template/footer', $ekstensiJS);
	}

	function ujiFunc(){
		// fungsi untuk menampilkan field data pada query sql
		$query = "SELECT a.id_barang, a.nama_barang, b.nama_kategori, a.harga, c.nama_supplier from barang_beli a, kategori b, supplier c where a.id_kategori = b.id_kategori AND a.id_supplier = c.id_supplier ORDER BY a.id_barang DESC";
		$indexCount = 2;
		$sql = $this->db->query($query);
		echo $this->view_filter_pencarian($sql->field_data());
	}
	private function view_filter_pencarian($data){
		$str = "";
		foreach ($data as $val) {
			$str.='<option value='.$val->name.'>'.$val->name.'</option>';
		}
		return $str;
	}
	function coba_view(){
		$this->load->view('template/admin/prot_view/coba');
	}
	
}

?>