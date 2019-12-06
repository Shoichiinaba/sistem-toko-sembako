<?php
	include('data_print/v_data_print.php');
?>
<?php
	class Buat_data extends Print_t{
		function get_data_user(){
			$query = $this->db->get('user');
			return $query->result_array();
		}
		function set_database($db_diver){
			$this->db = $db_diver;
		}
		function num_data(){
			$num = $this->db->get('user');
			return $num->num_rows();
		}
		function get_session(){
			return $_SESSION;
		}
	}
?>
<?php
	$d = new Buat_data();
	$d->set_database($this->db);
?>
<html>
<head>
	<title>Hallo CI</title>
</head>
<body>
	<p>Selamat Datang di Codeiqniter</p>
	<ul>
	<?php
		$data_user = $d->get_data_user();
	?>
	<?php foreach($data_user as $data) { ?>
		<li><?php echo $data['nama'];?></li>
	<?php } ?>
	</ul>
</body>
</html>