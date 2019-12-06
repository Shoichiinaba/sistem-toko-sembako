<?php
	class Print_t{
		public function read($data){
			$this->data_text = $data;
		}
		private function ekspan_text(){
			return "Teks anda adalah : ".$this->data_text;
		}
		function get_text($data_text){
			$this->read($data_text);
			$eks = $this->ekspan_text();
			echo $eks;
		}
	}
?>