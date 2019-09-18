<?php
$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
    array('label' => __('No'), 'filter' => false),
	array('label' => __('Order ID'), 'filter' => false),
    array('label' => __('Store'), 'filter' => true),
    array('label' => __('Sales'), 'filter' => true),
    array('label' => __('Date'), 'filter' => true),
	array('label' => __('Status'),'filter' => true)
);

// add heading with different font and bold text
$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));

// add data
if(!empty($data))
{
	$count = 0;
	foreach ($data as $data)
	{
		$count++;
		$no		=	(($page-1)*$viewpage) + $count;
		$this->PhpExcel->addTableRow(array(
			$no,
			$data[$ModelName]['id'],
			$data["Schedule"]["Store"]['name'],
			$data["Schedule"]["Sales"]['fullname'],
			date("d M Y H:i",strtotime($data["Order"]['modified'])),
			$data["OrderStatus"]['name']
		));
	}
}
// close table and output
$this->PhpExcel->addTableFooter()->output($filename);
?>
