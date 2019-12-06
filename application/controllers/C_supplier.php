<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class C_supplier extends CI_controller {
		function __construct(){
			parent::__construct();
			$this->load->model('supplier_m');
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

		private function getSupplierstr($param = array()){
  			$s = "";
  			foreach ($param as $key) {
  				$s.='<tr>';
                        $s.='<td>'.$key['id_supplier'].'</td>';
                        $s.='<td>'.$key['nama_supplier'].'</td>';
                        $s.='<td>'.$key['telp'].'</td>';
						$s.='<td>'.$key['alamat'].'</td>';
                        $s.='<td>'.$this->buttonOption('editable').'</td>';
                      $s.='</tr>';
  			}
  			return $s;
  		}
		function panggil_data_supplier(){
	  		$index = $_GET['index'];
	  		$length = $_GET['length'];
			$sql = $this->db->get('supplier', $length, $index);
			$get = $sql->result_array();
			$result = $this->getSupplierstr($get);
			echo json_encode(array('data'=>$result));
	  	}
	  	private function get_id_supplier(){
	  		$this->db->select_max('id_supplier', 'max_kode');
			$query = $this->db->get('supplier');
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
			$char = "SPL";
			$kodeBarang = $char."".sprintf("%03s", $no);
			return $kodeBarang;
		}
	  	function input_data_supplier(){
	  		$id = $this->get_id_supplier();
	  		$nama_supplier = $_POST['nama_supplier'];
	  		$telp = $_POST['telp'];
			$alamat = $_POST['alamat'];
	  		$data = array(
	        'id_supplier' => $id,
	        'nama_supplier' => $nama_supplier,
	        'telp' => $telp,
			'alamat' => $alamat,
			);

			if($this->supplier_m->tambah_data_supplier($data)){
				 die( json_encode( array('result'=>true) ) );
			}
			die( json_encode( array('result'=>false) ) );
  		}
  		function update_supplier(){
	  		if($this->supplier_m->ubah_data_supplier($_GET)){
	  			die(json_encode( array('result'=>'sukses') ));
	  		}
	  		die(json_encode( array('result'=>'gagal') ));
  		}
  		function hapus_supplier(){
	  		$idSupplier = $_GET['id_supplier'];
	  		if($this->supplier_m->hapus_data_supplier($idSupplier)){
	  			die(json_encode( array('result'=>'sukses') ));
	  		}
	  		die(json_encode( array('result'=>'gagal') ));
	  	}

	}
?>