<?php
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'autoload.inc.php'); 
//spl_autoload_register('DOMPDF_autoload');
use Dompdf\Dompdf;
$dompdf = new Dompdf(); 
$dompdf->set_paper('legal', 'landscape');
$dompdf->load_html(utf8_decode($content_for_layout), Configure::read('App.encoding'));
$dompdf->render();
echo $dompdf->output();