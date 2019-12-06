<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_barang_m extends CI_Model {
	function buat_id_barang(){
		$sql = "select max(id_barang) as maxKode from master_barang";
			$getSql = $this->db->query($sql);
			$get = $getSql->result_array();
			$kode = $get[0]['maxKode'];
			if(strlen($kode) > 1){
				$no = (int) substr($kode, 2, 4);
				$no++;
			}else{
				// jika kode adalah NULL
				$no = (int) $kode;
				$no++;
			}
			$char = "BR";
			$kodeBarang = $char."".sprintf("%04s", $no);
			return $kodeBarang;
	}
	function data_info_barang($param){
		$sql = "SELECT a.id_barang,a.nama_barang,a.satuan,a.harga_jual,a.harga_beli,a.jumlah_stok,b.keterangan AS nama_penempatan, c.nama_supplier FROM master_barang a, penempatan b, supplier c WHERE a.id_penempatan = b.id_penempatan AND a.id_supplier = c.id_supplier AND a.id_barang = '$param'";
	      $result = $this->db->query($sql);
	      return ($result->num_rows() == 1)?json_encode(array('hasil'=>$result->result_array())) : json_encode(array('hasil'=>'failed'));
	}
	function data_barang_lanjut($index, $length){
		$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang limit $index, $length";
      	$sql = $this->db->query($query);
      	return $sql->result_array();
	}
	function data_cari_barang($cari){
        $query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang WHERE nama_barang LIKE '%$cari%'";
        $sql = $this->db->query($query);
        $count = $sql->num_rows();
        $indexCount = 8;
        $data['next'] = 'Tidak ada';
        $data['maxHal'] = 0;
        if($count > $indexCount){
          $query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang WHERE nama_barang LIKE '%$cari%' LIMIT 0, $indexCount";
          $sql = $this->db->query($query);
          $data['next'] = 'ada';
          $data['maxHal'] = ceil($count / $indexCount);
        }
        $result = $sql->result_array();
        $data['data'] = $result;
        $data['countData'] = $count;
        return $data;
	}
	function data_cari_barang_lanjut($cari, $index, $length){
		$query = "SELECT id_barang, nama_barang, satuan, harga_jual, harga_beli, jumlah_stok FROM master_barang WHERE nama_barang LIKE '%$cari%' LIMIT $index, $length";
      $sql = $this->db->query($query);
      return $sql->result_array();
	}

	function simpan_data_barang($param){
		return $this->db->insert('master_barang', $param);
	}
	function data_edit_tampil($id){
		$query = "SELECT a.id_barang AS id_barang, a.nama_barang AS nama_barang, a.satuan AS satuan, a.harga_jual AS harga_jual, a.harga_beli AS harga_beli, a.jumlah_stok AS jumlah_stok, a.id_penempatan AS id_penempatan, b.keterangan AS nama_penempatan, a.id_supplier AS id_supplier, c.nama_supplier AS nama_supplier
FROM master_barang a, penempatan b, supplier c
WHERE a.id_penempatan = b.id_penempatan
AND a.id_supplier = c.id_supplier
AND a.id_barang = '$id'";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	function update_data_barang($param){
		return $this->db->replace('master_barang', $param);
	}
	function delete_data_barang($id){
		$query = "DELETE FROM master_barang where id_barang='".$id."'";
		return $this->db->simple_query($query);
	}
	function data_print(){
		$query = "SELECT a.nama_barang, a.satuan, a.harga_jual, a.jumlah_stok, b.nama_penempatan FROM master_Barang a, penempatan b WHERE a.id_penempatan = b.id_penempatan ORDER BY  `b`.`nama_penempatan` ASC";
    	$sql = $this->db->query($query);
    	return $sql->result_array();
	}
	function data_penempatan($search){
		$query = "SELECT id_penempatan, nama_penempatan, keterangan
		FROM `penempatan`
		WHERE kunci LIKE '$search%'
		ORDER BY nama_penempatan ASC";
		$sql = $this->db->query($query);
		return $sql;
	}
	function data_edit_barang_penempatan($barang, $id_penempatan){
		$nBarang = explode(' ', $barang);
		$nBarang = $nBarang[0];
		$query = "SELECT id_penempatan, nama_penempatan, keterangan FROM penempatan WHERE kunci LIKE '$nBarang%' AND id_penempatan != '$id_penempatan'";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
}