<?php
ini_set('memory_limit', '1024M');
ob_start();
session_start();

require '../../_app/Config.inc.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$Read 			= new Read;
$spreadsheet 	= new Spreadsheet();
$sheet 			= $spreadsheet->getActiveSheet();
$filename 		= "leads_data_" . date('Ymd_His');

$rowCount = 2; // Começar na segunda linha, pois a primeira é para os cabeçalhos

// Nomeando as colunas
$sheet->setCellValue('A1', 'Nome');
$sheet->setCellValue('B1', 'Telefone');
$sheet->setCellValue('C1', 'Email');
$sheet->setCellValue('D1', 'Mensagem');
$sheet->setCellValue('E1', 'Página');
$sheet->setCellValue('F1', 'Data Cadastro');

$getFormato 	= filter_input(INPUT_GET, 'formato', FILTER_DEFAULT);
$getSearch  	= filter_input(INPUT_GET, 's', FILTER_DEFAULT);
$WhereString 	= (!empty($getSearch) ? " AND lead_nome LIKE '%{$getSearch}%' OR lead_email LIKE '%{$getSearch}%' OR lead_telefone LIKE '%{$getSearch}%' OR lead_id LIKE '%{$getSearch}%' " : "");

$Read->ExeRead(DB_LEADS_SITE, " WHERE 1 = 1 $WhereString ORDER BY lead_dataCadastro DESC, lead_nome ASC");
if ($Read->getResult()):
	foreach ($Read->getResult() as $Leads):
    	extract($Leads);
		
		if($getFormato == 'xls'):
			$sheet->setCellValue('A' . $rowCount, trim(Check::removerAcentos($lead_nome)));
			$sheet->setCellValue('B' . $rowCount, trim($lead_telefone));
			$sheet->setCellValue('C' . $rowCount, trim($lead_email));
			$sheet->setCellValue('D' . $rowCount, $lead_mensagem);
			$sheet->setCellValue('E' . $rowCount, trim(Check::removerAcentos($lead_pagina)));
            $sheet->setCellValue('F' . $rowCount, date('d/m/Y H:i:s', strtotime($lead_dataCadastro)));

            $rowCount++;
		endif;
	endforeach;
endif;

if($getFormato == 'xls'):
	// Configurações de cabeçalho para forçar o download
    $filename 	= $filename.".xlsx";
  	
  	ob_end_clean();
 
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');
    header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
endif;
?>