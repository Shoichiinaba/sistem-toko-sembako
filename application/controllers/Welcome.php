<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construnct(){
		parent::__construnct();
		$this->load->library('session');
	}
	public function index()
	{
		$this->load->view('template/login');
		
	}
	public function activateLogin(){
		if(isset($_POST['username']) and isset($_POST['password'])){
			$query = "SELECT * FROM user where username='".$_POST['username']."' and password='".md5($_POST['password'])."'";
			$sql = $this->db->query($query);
			if($sql->num_rows() == 1){
				$result = $sql->result_array();
				$id_user = $result[0]['id_user'];
				$username = $result[0]['username'];
				$keterangan = $result[0]['keterangan'];
				$this->session->set_userdata('id_user', $id_user);
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('keterangan', $keterangan);
				if( isset($_SESSION['id_user']) and isset($_SESSION['username']) and isset($_SESSION['keterangan']) ){
					if($_SESSION['keterangan'] == "Admin"){
						redirect("Admin");
					}else if($_SESSION['keterangan'] == "Kasir"){
						redirect("Kasirtoko");
					}
				}
			}else{
				// bila username tidak ditemukan
				$data['user'] = false;
				$this->load->view('template/login', $data);
			}
				
		}else{
			$this->load->view('template/login');
		}
	}
	function destroy(){
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('keterangan');
	}
}
