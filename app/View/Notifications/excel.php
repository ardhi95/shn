<?php
$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
    array('label' => __('No'), 'filter' => false),
	array('label' => __('Subject'), 'filter' => false),
    array('label' => __('Message'), 'filter' => true),
	array('label' => __('Total Recipient'), 'filter' => true),
	array('label' => __('Total Arrival'), 'filter' => true),
	array('label' => __('Total Read'),'filter' => true)
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
			$data[$ModelName]['title'],
			$this->Text->truncate(strip_tags($data[$ModelName]['message']),30,array("ending"=>"..","html"=>true)),
			number_format($data[$ModelName]['total_recipient'],0),
			number_format($data[$ModelName]['total_arrival_message'],0),
			number_format($data[$ModelName]['total_read_message'],0)
		));
	}
}
// close table and output
$this->PhpExcel->addTableFooter()->output($filename);
?>