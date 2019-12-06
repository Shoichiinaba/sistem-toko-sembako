<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_m extends CI_Model {
	function ambil_data_master_barang_select(){
		$q = "";
		$query = "SELECT id_barang, nama_barang FROM master_barang";
		$sql = $this->db->query($query);
		$batas = 10;
		$count = $sql->num_rows();
		if($count > $batas){
			$hal = ceil($count / $batas);
			for($index=1; $index<=$hal; $index++){
				$indexFirst = ($index * $batas) - $batas;
				$query = "SELECT id_barang, nama_barang FROM master_barang LIMIT $indexFirst, $batas";
				$sql = $this->db->query($query);
				$result = $sql->result_array();
				foreach ($result as $data) {
					$q.="<option value='".$data['id_barang']."'>".$data['nama_barang']."</option>";
				}
			}
		}else{
			$result = $sql->result_array();
			foreach ($result as $data) {
				$q.="<option value='".$data['id_barang']."'>".$data['nama_barang']."</option>";
			}
		}
		return $q;
	}
	function ambil_data_barang_edit($id_barang){
		$q = "";
		$query = "SELECT id_barang, nama_barang FROM master_barang WHERE id_barang != '$id_barang'";
		$sql = $this->db->query($query);
		$batas = 10;
		$count = $sql->num_rows();
		if($count > $batas){
			$hal = ceil($count / $batas);
			for($index=1; $index<=$hal; $index++){
				$indexFirst = ($index * $batas) - $batas;
				$query = "SELECT id_barang, nama_barang FROM master_barang WHERE id_barang != '$id_barang' LIMIT $indexFirst, $batas";
				$sql = $this->db->query($query);
				$result = $sql->result_array();
				foreach ($result as $data) {
					$q.="<option value='".$data['id_barang']."'>".$data['nama_barang']."</option>";
				}
			}
		}else{
			$result = $sql->result_array();
			foreach ($result as $data) {
				$q.="<option value='".$data['id_barang']."'>".$data['nama_barang']."</option>";
			}
		}
		return $q;
	}
	function hasil_data_barang($id){
		$query = "SELECT a.id_barang, a.nama_barang, a.satuan, a.harga_beli, b.nama_supplier, b.alamat, b.telp from master_barang a, supplier b where a.id_supplier = b.id_supplier AND a.id_barang = '$id'";
    	$sql = $this->db->query($query);
    	return $sql;
	}
	function data_daftar_pembelian_lanjut($index, $length){
		$query = "SELECT COUNT( id_barang ) AS total_barang, SUM( jumlah ) AS total_item, SUM( harga ) AS total_harga, tanggal FROM pembelian GROUP BY tanggal ORDER BY id DESC LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      return $get;
	}
	function data_daftar_pembelian_detail_lanjut($index, $length, $tgl){
		$query = "SELECT a.id, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND tanggal = '".$tgl."' LIMIT $index, $length";
      	$sql = $this->db->query($query);
      	return $sql;
	}
	function data_edit_pembelian_tampil($id){
		$query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND a.id = '".$id."'";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	function getHarga($id_barang){
		$query = "SELECT harga_beli FROM master_barang WHERE id_barang = '$id_barang'";
		$sql = $this->db->query($query);
		return $sql->result_array()[0]['harga_beli'];
	}
	function update_data_pembelian($data){
		$data_update = array(
			'id_barang' => $data['id_barang'],
			'satuan' => $data['satuan'],
			'jumlah' => $data['jumlah'],
			'harga' => $data['harga'],
			'nama_supplier' => $data['nama_supplier']
		);
		$id = $data['id'];
		$this->db->where('id', $id);
		return $this->db->update('pembelian', $data_update);
	}
	function hapus_data_pembelian_detail($id){
		 $query = "DELETE FROM pembelian WHERE id='".$id."'";
		 $sql = $this->db->simple_query($query);
		 return $sql;
	}
	function getdataidBarang($id){
		$query = "SELECT a.id, b.jumlah_stok, b.id_barang FROM pembelian a, master_barang b WHERE a.id_barang = b.id_barang AND a.id = '$id'";
		$sql = $this->db->query($query);
		$data = $sql->result_array();
		return array(
			'id' => $data[0]['id'],
			'id_barang' => $data[0]['id_barang'],
			'jumlah_stok' => $data[0]['jumlah_stok']
		);
	}
	function update_data_stok_barang($id, $id_barang, $stok){
		$data_update = array(
			'jumlah_stok' => $stok
		);
		$this->db->where('id_barang', $id_barang);
		if($this->db->update('master_barang', $data_update)){
			$data_update = array(
				'status'=>'sudah'
			);
			$this->db->where('id', $id);
			return $this->db->update('pembelian', $data_update);
		}
	}
	function data_cetak_pembelian($tanggal){
		$query = "SELECT b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.alamat, a.telp FROM pembelian a,master_barang b WHERE a.tanggal =  '".$tanggal."' AND a.id_barang = b.id_barang";
		$sql = $this->db->query($query);
		return $sql;
	}
	function data_barang_masuk($index, $length){
		 $query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND a.acc = 'belum' LIMIT $index, $length";
      	$sql = $this->db->query($query);
      	$get = $sql->result_array();
      	return $get;
	}
	function data_cari_barang_masuk($cari){
		$query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND a.acc = 'belum' AND b.nama_barang LIKE '%$cari%'";
        $sql = $this->db->query($query);
        $count = $sql->num_rows();
        $indexCount = 8;
        $data['next'] = 'Tidak ada';
        $data['maxHal'] = 0;
        if($count > $indexCount){
          $query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND a.acc = 'belum' AND b.nama_barang LIKE '%$cari%' LIMIT 0, $indexCount";
          $sql = $this->db->query($query);
          $data['next'] = 'ada';
          $data['maxHal'] = ceil($count / $indexCount);
        }
        $data['data'] = $sql->result_array();
        $data['countData'] = $count;
        return $data;
	}
	function data_pencarian_barang_masuk_next($cari){
		$query = "SELECT a.id, a.id_barang, b.nama_barang, a.satuan, a.jumlah, a.harga, a.nama_supplier, a.acc, a.status
			FROM pembelian a, master_barang b
			WHERE a.id_barang = b.id_barang
			AND a.acc = 'belum' AND b.nama_barang LIKE '%$cari%' LIMIT $index, $length";
      $sql = $this->db->query($query);
      $get = $sql->result_array();
      return $get;
	}

}
?>