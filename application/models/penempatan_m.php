<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penempatan_m extends CI_Model {
	function tambah_data_penempatan($param){
		return $this->db->insert('penempatan', $param);
	}
	function ubah_data_penempatan($data){
		$idPenempatan = $data['id_penempatan'];
  		$namaPenempatan = $data['nama_penempatan'];
		$keterangan = $data['keterangan'];
		$kunci = $data['kunci'];

  		$query = "UPDATE  `dbtoko`.`penempatan` SET 
  		`nama_penempatan` =  '".$namaPenempatan."',
  		`keterangan` = '".$keterangan."',
  		`kunci` = '".$kunci."' WHERE `penempatan`.`id_penempatan` =  '".$idPenempatan."'";

  		return $this->db->simple_query($query);
	}
	function hapus_data_penempatan($id){
		$query = "DELETE FROM penempatan where id_penempatan='".$id."'";
		return $this->db->simple_query($query);
	}
	function panggil_data_penempatan($index, $length){
		$query = "SELECT * from penempatan ORDER BY nama_penempatan ASC limit $index, $length";
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
}