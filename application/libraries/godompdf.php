<?php if ( !defined('BASEPATH')) exit();

class Godompdf
{
    function generate($html, $filename){
    	define('DOMPDF_ENABLE_AUTOLOAD', false);
    	require_once('dompdf/dompdf_config.inc.php');
    	$dompdf = new DOMPDF();
    	$dompdf->set_paper('A4', 'portrait');
    	$dompdf->load_html($html);
    	$dompdf->render();
    	$dompdf->stream($filename.'.pdf', array("Attachment"=>0));
    }
}