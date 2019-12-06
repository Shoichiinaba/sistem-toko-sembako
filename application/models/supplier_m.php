<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_m extends CI_Model {
	function tambah_data_supplier($data){
		return $this->db->insert('supplier', $data);
	}
	function ubah_data_supplier($data){
		$idSupplier = $data['id_supplier'];
  		$namaSupplier = $data['nama_supplier'];
		$telp = $data['telp'];
		$alamat = $data['alamat'];

  		$query = "UPDATE `dbtoko`.`supplier` SET 
  		`nama_supplier` = '".$namaSupplier."',
  		`telp` = '".$telp."',
		`alamat` = '".$alamat."' WHERE `supplier`.`id_supplier` = '".$idSupplier."'";
		 return $this->db->simple_query($query);
	}
	function hapus_data_supplier($id){
		$query = "DELETE FROM supplier where id_supplier='".$id."'";
		return $this->db->simple_query($query);
	}
}