<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pengguna extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('pengguna_m');
	}
	private function get_id_pengguna(){
  		$this->db->select_max('id_user', 'max_kode');
		$query = $this->db->get('user');
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
		$char = "USR";
		$kodePengguna = $char."".sprintf("%03s", $no);
		return $kodePengguna;
	}
	private function getPenggunastr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_user'].'</td>';
                        $s.='<td>'.$key['username'].'</td>';
                        $s.='<td>'.$key['nama'].'</td>';
						$s.='<td>'.$key['password'].'</td>';
						$s.='<td>'.$key['keterangan'].'</td>';
                        $s.='<td>
                        <button type="button" data-toggle="modal" data-cstarget="delPick" data-target="#modal-danger" class="btn btn-danger fa fa-trash"></button></td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}
  	function hapus_pengguna(){
  		$id = $_GET['id'];
  		if($this->pengguna_m->hapus_data($id)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
	function panggil_data_pengguna(){
		$index = $_GET['index'];
  		$length = $_GET['length'];
		$sql = $this->db->get('pengguna', $length, $index);
		$get = $sql->result_array();
		$result = $this->getPenggunastr($get);
		echo json_encode(array('data'=>$result));
	}
	function input_data_pengguna(){
  		$id = $this->get_id_pengguna();
		$data = array(
        	'id_user' => $id,
        	'nama' => $_POST['nama'],
        	'username' => $_POST['username'],
			'password' => md5($_POST['password']),
			'keterangan' => $_POST['keterangan']
		);
		if($this->pengguna_m->tambah_data_pengguna($data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}
}

?>