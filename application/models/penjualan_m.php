<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class penjualan_m extends CI_Model {

	function ekistData(){
		echo "hello aku adalah model untuk penjualan";
	}
	private function ekspresi($eks){
		echo "<pre>";
			print_r($eks);
		echo "</pre>";
	}
	function cari_data_barang($cari, $jenis){
		if($jenis == 'dapat'){
			$index['query'] = [];
			$query = "SELECT a.id_barang, a.nama_barang, a.satuan, a.harga_jual, jumlah_stok, b.nama_penempatan
				FROM master_barang a, penempatan b
				WHERE a.id_penempatan = b.id_penempatan
				AND a.nama_barang LIKE '%$cari%'
				LIMIT 8";
			$sql = $this->db->query($query);
			$get = $sql->result_array();
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

		} else {
			$index['query'] = [];
			$query = "SELECT nama_barang FROM master_barang WHERE nama_barang LIKE '%$cari%' LIMIT 8";
			$sql = $this->db->query($query);
			$get = $sql->result_array();
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

	function updateStokbarang($param){
		$id_barang = $param['id_barang'];
		$stok_kurang = $param['jumlah_stok'];
			for($i=0; $i<count($id_barang); $i++){
				$sql = "UPDATE master_barang SET jumlah_stok = '".$stok_kurang[$i]."' WHERE id_barang = '".$id_barang[$i]."'";
				$this->db->query($sql);
			}
	}
	function tambah_data_penjualan($data){
		if(count($data['id_barang']) > 0){
			$dataInsert = array();
			for($i = 0; $i<count($data['id_barang']); $i++){
				$arrayKombine = array();
				foreach($data as $key => $value){
					$arrayKombine[$key] = $value[$i];
				}
				array_push($dataInsert, $arrayKombine);
			}
		}
		return $this->db->insert_batch('penjualan', $dataInsert);
	}
	function data_penjualan_lanjut($index, $length){
		$query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal
			FROM penjualan
			GROUP BY tanggal ORDER BY id DESC LIMIT $index, $length";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	function cari_data_penjualan($tgl){
		$query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM penjualan WHERE tanggal LIKE '%$tgl%' GROUP BY tanggal ORDER BY id DESC";
		$sql = $this->db->query($query);
      	$count = $sql->num_rows();
      	$indexCount = 8;
      	$data['next'] = 'Tidak ada';
      	$data['maxHal'] = 0;
      	if($count > $indexCount){
      		 $query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM penjualan WHERE tanggal LIKE '%$tgl%' GROUP BY tanggal ORDER BY id DESC LIMIT 0, $indexCount";
        	$sql = $this->db->query($query);
        	$data['next'] = 'ada';
        	$data['maxHal'] = ceil($count / $indexCount);
      	}
      	$data['data'] = $sql->result_array();
      	$data['countData'] = $count;
      	return $data;
	}
	function cari_data_penjualan_lanjut($tgl, $index, $length){
		$query = "SELECT COUNT( id ) AS total_penjualan, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM penjualan WHERE tanggal LIKE '%$tgl%' GROUP BY tanggal ORDER BY id DESC LIMIT $index, $length";
      	$sql = $this->db->query($query);
      	$get = $sql->result_array();
      	return $get;
	}
	function data_penjualan_detail_lanjut($tanggal, $index, $length){
		$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.tanggal = '$tanggal' ORDER BY a.id DESC LIMIT $index, $length";
  		 $sql = $this->db->query($query);
      	 $get = $sql->result_array();
      	 return $get;
	}
	function data_penjualan_cetak($tanggal){
		$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.tanggal = '$tanggal' ORDER BY a.id DESC";
		$sql = $this->db->query($query);
		$data['data'] = $sql->result_array();
		return $data;
	}
	function data_laporan_penjualan_cetak($tgl_1, $tgl_2){
		if( (strlen($tgl_2) > 0) and (strlen($tgl_1) > 0) ){
			$find = "BETWEEN '$tgl_1' AND '$tgl_2'";
		}else{
			$find = " = '$tgl_1'";
		}
		$query = "SELECT a.id, a.customer, b.nama_barang, a.satuan, a.jumlah, b.harga_jual, a.harga, a.tanggal FROM penjualan a, master_barang b WHERE a.id_barang = b.id_barang AND a.tanggal $find";
		$sql = $this->db->query($query);
		$data['data'] = $sql->result_array();
		return $data;
	}

}