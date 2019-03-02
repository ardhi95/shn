<?php
$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);

// define table cells
$table = array(
    array('label' => __('No'), 'filter' => false),
	array('label' => __('Nama'), 'filter' => false),
    array('label' => __('Usia'), 'filter' => false),
	array('label' => __('Jenis Kelamin'),'filter' => true),
	array('label' => __('Status Perkawinan'),'filter' => true),
	array('label' => __('Catatan Kesehatan'),'filter' => true),
	array('label' => __('Jarak Rumah'),'filter' => false),
	array('label' => __('Unit Kerja'),'filter' => true),
	array('label' => __('Shift Kerja'),'filter' => true)
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
			$data[$ModelName]['name'],
			$data[$ModelName]["age"],
			($data[$ModelName]["gender"] == "m" ? "L" : "P"),
			($data[$ModelName]["marital_status"] == "m" ? "Married" : "Single"),
			($data[$ModelName]["health_record"] == "b" ? "Tidak" : "Bagus"),
			$data[$ModelName]["house"],
			$data["WorkUnit"]["name"],
			$data["WorkShift"]["name"]
		));
	}
}
// close table and output
$this->PhpExcel->addTableFooter()->output($filename);
?>