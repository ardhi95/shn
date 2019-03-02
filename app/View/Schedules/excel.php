<?php
$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
    array('label' => __('No'), 'filter' => false),
	array('label' => __('Sales'), 'filter' => false),
    array('label' => __('Date'), 'filter' => true),
	array('label' => __('Store'), 'filter' => true),
	array('label' => __('Checkin Status'), 'filter' => true)
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
			$data["Sales"]['fullname'],
			date("D, d M Y H:i",strtotime($data[$ModelName]['schedule_date'])),
			$this->General->IsEmptyVal($data["Store"]['name']),
			$data["CheckinStatus"]['name']
		));
	}
}
// close table and output
$this->PhpExcel->addTableFooter()->output($filename);
?>