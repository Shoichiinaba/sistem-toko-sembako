<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna_m extends CI_Model {

	function tambah_data_pengguna($data){
		return $this->db->insert('user', $data);
	}
	function hapus_data($id){
		$query = "DELETE FROM user where id_user='".$id."'";
  		return $this->db->simple_query($query);
	}
}