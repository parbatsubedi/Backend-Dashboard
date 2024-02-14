<?php

namespace App\Wallet\PhpSpreadSheet;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PhpSpreadSheetExportHelper
{
    public function setLogo($activeSheet, $index)
    {
        $activeSheet->mergeCells("A" . ($index + 1) . ":D" . ($index + 4));

        if (config('app.logo') == 'sajilopay') {
            $image = public_path('img/sajilopaylogo.png');
        } elseif (config('app.logo') == 'icash') {
            $image = public_path('img/icashlogo.png');
        } elseif (config('app.logo') == 'dpaisa') {
            $image = public_path('img/dpaisalogo.png');
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath($image);
        $drawing->setHeight(70);
        $drawing->setCoordinates('A' . ($index + 1));
        $drawing->setWorksheet($activeSheet);
        $drawing->setOffsetX(50);
        return $activeSheet;
    }

    public function setTitle($activeSheet, $reportTitle, $index)
    {
        //Title
        $activeSheet->setCellValue('A' . ($index + 5), $reportTitle);
        $activeSheet->getStyle('A' . ($index + 5))->getFont()->setBold(1)->setSize(16);
        $activeSheet->mergeCells("A" . ($index + 5) . ":D" . ($index + 6));
        $activeSheet->getStyle('A' . ($index + 5))->getAlignment()->setHorizontal('center')->setVertical('center');
        return $activeSheet;
    }

    public function setFilteredOptions($activeSheet, $request, $index)
    {
        if ($request->all()) {
            $activeSheet->setCellValue('A' . ($index + 7), 'Filtered Options');
            $activeSheet->getStyle('A' . ($index + 7))->getFont()->setBold(1)->setSize(12);
            $activeSheet->mergeCells("A" . ($index + 7) . ":D" . ($index + 7));
        }

        //For Filtered Options

        $total = count($request->all());
        $filterRow = $request->all();

        if (count($filterRow) > 0) {
            $rowIndex = ($index + 8);
            foreach ($filterRow as $key => $value) {
                $activeSheet->setCellValue('A' . $rowIndex, $key);
                $cellRange = 'A' . $rowIndex . ':C' . $rowIndex;
                $activeSheet->mergeCells($cellRange);
                $activeSheet->setCellValue('C' . $rowIndex, $value);
                $cell_Range = 'D' . $rowIndex . ':F' . $rowIndex;
                $activeSheet->mergeCells($cell_Range);
                $rowIndex++;
            }
        }
        return $activeSheet;
    }

    public function exportToExcel($spreadsheet, $filename)
    {
        $Excel_writer = new Xlsx($spreadsheet);
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);

        $Excel_writer->save($filename);
        $content = file_get_contents($filename);
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }

}
