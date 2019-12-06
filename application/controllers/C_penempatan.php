<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_penempatan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('penempatan_m');
	}
	function buttonOption($param){
    $q = "";
    if($param == "editable"){
      $q = '<button type="button" data-toggle="modal" data-target="#modal-warning" data-cstarget="editReck" class="btn btn-warning fa fa-pencil-square-o"></button>
      <button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button>';
    }else if($param == "fulloption"){
      $q = '<button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>
      <button type="button" data-toggle="modal" data-target="#modal-warning" data-cstarget="editReck" class="btn btn-warning fa fa-pencil-square-o"></button>
      <button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button>';
    }
    return $q;
  }
	private function getPenempatanstr($param = array()){
  		$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_penempatan'].'</td>';
                        $s.='<td>'.$key['nama_penempatan'].'</td>';
                        $s.='<td>'.$key['keterangan'].'</td>';
						$s.='<td>'.$key['kunci'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  	}
	public function panggil_data_penempatan(){
  		$index = $_GET['index'];
  		$length = $_GET['length'];
		$get = $this->penempatan_m->panggil_data_penempatan($index, $length);
		$result = $this->getPenempatanstr($get);
		echo json_encode(array('data'=>$result));
  	}
  	private function get_id_penempatan(){
  		$this->db->select_max('id_penempatan', 'max_kode');
		$query = $this->db->get('penempatan');
		$get = $query->result_array();
		$kode = $get[0]['max_kode'];
		if(strlen($kode) > 1){
			$no = (int) substr($kode, 2, 3);
			$no++;
		}else{
			// jika kode adalah NULL
			$no = (int) $kode;
			$no++;
		}
		$char = "PN";
		$kodePenempatan = $char."".sprintf("%03s", $no);
		return $kodePenempatan;
	}
  	function input_data_penempatan(){
  		$id = $this->get_id_penempatan();
  		$nama_penempatan = $_POST['nama_penempatan'];
  		$keterangan = $_POST['keterangan'];
		$kunci = $_POST['kunci'];
  		$data = array(
        'id_penempatan' => $id,
        'nama_penempatan' => $nama_penempatan,
        'keterangan' => $keterangan,
		'kunci' => $kunci
		);
		if($this->penempatan_m->tambah_data_penempatan($data)){
			 die( json_encode( array('result'=>true) ) );
		}
		die( json_encode( array('result'=>false) ) );
  	}

  	function ubah_penempatan(){
  		if($this->penempatan_m->ubah_data_penempatan($_GET)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
  	function hapus_penempatan(){
  		$idpenempatan = $_GET['id_penempatan'];
  		if($this->penempatan_m->hapus_data_penempatan($idpenempatan)){
  			die(json_encode( array('result'=>'sukses') ));
  		}
  		die(json_encode( array('result'=>'gagal') ));
  	}
}

?>