<?php

namespace App\Http\Controllers;

use App\Wallet\PhpSpreadSheet\PhpSpreadSheetExportHelper;
use App\Wallet\Report\Http\Controllers\NRBAnnexReportController;
use App\Wallet\Report\Repositories\ActiveInactiveUserReportRepository;
use App\Wallet\Report\Repositories\ActiveInactiveUserSlabReportRepository;
use App\Wallet\Report\Repositories\NrbAnnexAgentPaymentReportRepository;
use App\Wallet\Report\Repositories\StatementSettlementBankRepository;
use App\Wallet\WalletAPI\Microservice\WalletClearanceMicroService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

//use PhpOffice\PhpSpreadsheet\Writer\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\RequestInfo;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\Storage;
use App\Models\NPSAccountLinkLoad;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;


class PhpSpreadSheetController extends Controller
{

    public function requestInfo(Request $request)
    {

        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Logo
        $activeSheet->mergeCells("A1:J4");

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
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($activeSheet);

        //Title
        $activeSheet->setCellValue('A5', 'Requests Info Report');
        $activeSheet->getStyle('A5')->getFont()->setBold(1)->setSize(16);;
        $activeSheet->mergeCells("A5:J6");

        $activeSheet->setCellValue('A7', 'Filtered Options');
        $activeSheet->getStyle('A7')->getFont()->setBold(1)->setSize(12);;
        $activeSheet->mergeCells("A7:J7");

        //Filtered Options

        $total = count($request->all());
        $test = $request->all();

        if (count($test) > 0) {
            $filter = 8;
            foreach ($test as $key => $value) {
                $activeSheet->setCellValue('A' . $filter, $key);
                $cellRange = 'A' . $filter . ':C' . $filter;
                $activeSheet->mergeCells($cellRange);
                $activeSheet->setCellValue('C' . $filter, $value);
                $cell_Range = 'D' . $filter . ':F' . $filter;
                $activeSheet->mergeCells($cell_Range);
                $filter++;
            }
        }

        foreach (range('A', 'J') as $col) {
            $activeSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $activeSheet->setCellValue('A17', 'ID');
        $activeSheet->setCellValue('B17', 'Request ID');
        $activeSheet->setCellValue('C17', 'User ID');
        $activeSheet->setCellValue('D17', 'Description');
        $activeSheet->setCellValue('E17', 'Vendor');
        $activeSheet->setCellValue('F17', 'Service Type');
        $activeSheet->setCellValue('G17', 'Micro-Service Type');
        $activeSheet->setCellValue('H17', 'URL');
        $activeSheet->setCellValue('I17', 'Status');
        $activeSheet->setCellValue('J17', 'Date');
        $activeSheet->getStyle('A17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('B17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('C17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('D17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('E17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('F17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('G17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('H17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('I17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('J17')->getFont()->setBold(1)->setSize(12);

        $query = RequestInfo::filter(request())->get();

        if ($query->count() > 0) {
            $i = 18;
            foreach ($query as $row) {
                $activeSheet->setCellValue('A' . $i, $row['id']);
                $activeSheet->setCellValueExplicit('B' . $i, $row['request_id'], DataType::TYPE_STRING);
                $activeSheet->setCellValue('C' . $i, $row['user_id']);
                $activeSheet->setCellValue('D' . $i, $row['description']);
                $activeSheet->setCellValue('E' . $i, $row['vendor']);
                $activeSheet->setCellValue('F' . $i, $row['service_type']);
                $activeSheet->setCellValue('G' . $i, $row['microservice_type']);
                $activeSheet->setCellValue('H' . $i, $row['url']);
                $activeSheet->setCellValue('I' . $i, $row['status']);
                $activeSheet->setCellValue('J' . $i, $row['created_at']);
                $i++;
            }
        }

        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "requestInfo_" . $date . ".xlsx";
        $Excel_writer->save($filename);
        $content = file_get_contents($filename);
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }

    public function NPSAccountLinkLoad(Request $request)
    {

        $spreadsheet = new Spreadsheet();
        $Excel_writer = new Xlsx($spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        //Logo
        $activeSheet->mergeCells("A1:J4");

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
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($activeSheet);

        //Title
        $activeSheet->setCellValue('A5', 'Load Wallet Report');
        $activeSheet->getStyle('A5')->getFont()->setBold(1)->setSize(16);
        $activeSheet->mergeCells("A5:J6");

        $activeSheet->setCellValue('A7', 'Filtered Options');
        $activeSheet->getStyle('A7')->getFont()->setBold(1)->setSize(12);
        $activeSheet->mergeCells("A7:J7");

        //For Filtered Options

        $total = count($request->all());
        $filterRow = $request->all();

        if (count($filterRow) > 0) {
            $rowIndex = 8;
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

        foreach (range('A', 'J') as $col) {
            $activeSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $activeSheet->setCellValue('A17', 'ID');
        $activeSheet->setCellValue('B17', 'Amount');
        $activeSheet->setCellValue('C17', 'Gateway Transaction ID');
        $activeSheet->setCellValue('D17', 'Load Status');
        $activeSheet->setCellValue('E17', 'Load Time Stamp');
        $activeSheet->setCellValue('F17', 'Merchant Txn ID');
        $activeSheet->setCellValue('G17', 'Reference ID');
        $activeSheet->setCellValue('H17', 'User Phone Number');
        $activeSheet->setCellValue('I17', 'Linked Account ID');
        $activeSheet->setCellValue('J17', 'Created At');

//        foreach (range('A17','J17') as $col) {
//            $activeSheet-> ->setBold(1)->setSize(12);
//        }

        $activeSheet->getStyle('A17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('B17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('C17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('D17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('E17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('F17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('G17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('H17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('I17')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('J17')->getFont()->setBold(1)->setSize(12);

        $npsAccountLinkLoad = NPSAccountLinkLoad::with('preTransaction')->filter(request())->get();

        if ($npsAccountLinkLoad->count() > 0) {
            $index = 18;
            foreach ($npsAccountLinkLoad as $row) {
                $activeSheet->setCellValue('A' . $index, $row['id']);
                $activeSheet->setCellValueExplicit('B' . $index, $row['amount'], DataType::TYPE_STRING);
                $activeSheet->setCellValue('C' . $index, $row['gateway_transaction_id']);
                $activeSheet->setCellValue('D' . $index, $row['load_status']);
                $activeSheet->setCellValue('E' . $index, $row['load_time_stamp']);
                $activeSheet->setCellValue('F' . $index, $row['merchant_txn_id']);
                $activeSheet->setCellValue('G' . $index, $row['reference_id']);
                $activeSheet->setCellValue('H' . $index, optional(optional($row->preTransaction)->user)->mobile_no);
                $activeSheet->setCellValue('I' . $index, $row['linked_id']);
                $activeSheet->setCellValue('J' . $index, $row['created_at']);
                $index++;
            }
        }

        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "loadWallet_" . $date . ".xlsx";
        $Excel_writer->save($filename);
        $content = file_get_contents($filename);
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }

    public function statementSettlementBankReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $statementSettlementBanks = $nrbAnnex->statementSettlementBank($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'Statement Settlement Bank Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();


        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->setCellValue('A9', 'S.N.')
                    ->setCellValue('B9', 'Particulars')
                    ->setCellValue('C9', 'Credit')
                    ->setCellValue('D9', 'Debit');

        $activeSheet->getStyle('A9:D9')->getFont()->setBold(1)->setSize(12);
        $totalCredit = 0;
        $totalDebit = 0;

        if ($statementSettlementBanks) {
            $index = 10;
            $sn = 1;
            foreach ($statementSettlementBanks as $title => $statementSettlementBank) {
                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValue('B' . $index, $title);
                $activeSheet->setCellValueExplicit('C' . $index, $statementSettlementBank['credit'], DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D' . $index, $statementSettlementBank['debit'], DataType::TYPE_STRING);
                $totalCredit += $statementSettlementBank['credit'];
                $totalDebit += $statementSettlementBank['debit'];
                $index++;
            }
            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "B" . $index);
            $activeSheet->setCellValue("A" . $index, 'Grand Total');
            $activeSheet->setCellValueExplicit('C' . $index, $totalCredit, DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('D' . $index, $totalDebit, DataType::TYPE_STRING);
            $index++;
            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->setCellValue('A' . $index, 'Report Generated for Date : ' . $request->from);
        }

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "Statement Settlement Bank Report for " . $request->from . ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    public function activeInactiveUserReport(Request $request)
    {
        $activeInactiveReports = new ActiveInactiveUserReportRepository($request);
        $activeInactiveReports = $activeInactiveReports->dispatchWalletClearance($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'Active Inactive User Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->mergeCells("A9:A16")
                    ->mergeCells("A17:A22")
                    ->mergeCells("B9:B10")
                    ->mergeCells("B11:B12")
                    ->mergeCells("B13:B14")
                    ->mergeCells("B15:B16")
                    ->mergeCells("B17:B18")
                    ->mergeCells("B19:B20")
                    ->mergeCells("B21:B22");

        $activeSheet->setCellValue('A9', 'Active Customer Wallet')
                    ->setCellValue('A17', 'Inactive Customer Wallet')
                    ->setCellValue('B9', 'Male')
                    ->setCellValue('B11', 'Female')
                    ->setCellValue('B13', 'Others')
                    ->setCellValue('B15', 'Grand Total')
                    ->setCellValue('B17', 'Inactive (6-12 Months)')
                    ->setCellValue('B19', 'Inactive (> 12 Months)')
                    ->setCellValue('B21', 'Grand Total');

        $activeSheet->getStyle('A9:C22')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('D9:D22')->getAlignment()->setHorizontal('right');
        $activeSheet->getStyle('A9:A17')->getAlignment()->setHorizontal('center')->setVertical('center');


        if ($activeInactiveReports) {
            $index = 9;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Male']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Male']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Female']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Female']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Other']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Other']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Grand Total']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Active Customer Wallet']['Grand Total']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Inactive  (6-12 months)']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Inactive  (6-12 months)']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Inactive (> 12 months)']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Inactive (> 12 months)']['Total Balance']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Count');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Grand Total']['Number']);
            $index++;
            $activeSheet->setCellValue('C' . $index, 'Total Balance');
            $activeSheet->setCellValue('D' . $index, $activeInactiveReports['activeInactiveUserReports']['Inactive Customer Wallet']['Grand Total']['Total Balance']);
            $index++;

            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->setCellValue('A' . $index, 'Report Generated as of date : ' . $request->from);
            $activeSheet->getStyle('A' . $index)->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "Active Inactive User Report for " . $request->from . ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    public function activeInactiveUserSlabReport(Request $request)
    {
        $activeInactiveReports = new ActiveInactiveUserSlabReportRepository($request);
        $activeInactiveReports = $activeInactiveReports->dispatchWalletClearance($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'Active Inactive User Report w/ Amount Range';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->mergeCells("A9:A14")
                    ->mergeCells("A15:A20")
                    ->mergeCells("A21:A26")
                    ->mergeCells("A27:A32");

        $activeSheet->mergeCells("B9:B10")
                    ->mergeCells("B11:B12")
                    ->mergeCells("B13:B14")
                    ->mergeCells("B15:B16")
                    ->mergeCells("B17:B18")
                    ->mergeCells("B19:B20")
                    ->mergeCells("B21:B22")
                    ->mergeCells("B23:B24")
                    ->mergeCells("B25:B26")
                    ->mergeCells("B27:B28")
                    ->mergeCells("B29:B30")
                    ->mergeCells("B31:B32");

        $activeSheet->setCellValue('A9', 'Active Customer Wallet')
                    ->setCellValue('A15', 'Inactive Customer Wallet (upto 6 Months)')
                    ->setCellValue('A21', 'Inactive Customer Wallet (6-12 Months)')
                    ->setCellValue('A27', 'Inactive Customer Wallet (> 12 Months)');

        $activeSheet->setCellValue('B9', 'Male')
                    ->setCellValue('B11', 'Female')
                    ->setCellValue('B13', 'Others');
//        $activeSheet->setCellValue('B15', 'Grand Total');

        $activeSheet->setCellValue('B15', 'Male')
                    ->setCellValue('B17', 'Female')
                    ->setCellValue('B19', 'Others')
                    ->setCellValue('B21', 'Male')
                    ->setCellValue('B23', 'Female')
                    ->setCellValue('B25', 'Others')
                    ->setCellValue('B27', 'Male')
                    ->setCellValue('B29', 'Female')
                    ->setCellValue('B31', 'Others');
//        $activeSheet->setCellValue('B35', 'Grand Total');

        $activeSheet->getStyle('A9:C32')->getFont()->setBold(1)->setSize(12);
        $activeSheet->getStyle('D9:D32')->getAlignment()->setHorizontal('right');
        $activeSheet->getStyle('A9:A27')->getAlignment()->setHorizontal('center')->setVertical('center');

        //Generate Report for Array
        if ($activeInactiveReports) {
            $index = 9;
            foreach ($activeInactiveReports as $reports) {
                foreach ($reports as $report) {
                    foreach ($report as $value) {
                        if ($index % 2 == 0) {
                            $activeSheet->setCellValue('C' . $index, 'Total Balance');
                        } else {
                            $activeSheet->setCellValue('C' . $index, 'Count');
                        }

                        $activeSheet->setCellValue('D' . $index, $value);
                        $index++;
                    }
                }
            }

            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->mergeCells("A" . ($index+1) . ":" . "D" . ($index+1));

            $activeSheet->setCellValue('A' . $index, 'Report Generated for Amount Range : ' . $request->from_amount.'-'.$request->to_amount);
            $activeSheet->setCellValue('A' . ($index+1), 'Report Generated as of date : ' . $request->from);
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getAlignment()->setHorizontal('center')->setVertical('center');
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getFont()->setSize(12);
        }

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:D'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "Active Inactive User Report for " . $request->from . ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    //10.1.11 Report
    public function nrbAgentReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $agentReports = $nrbAnnex->agentPaymentReport($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'NRB Annex 10.1.11 Agent Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->mergeCells('A9:A10')
            ->mergeCells('B9:B10')
            ->mergeCells('C9:C10')
            ->mergeCells('D9:D10')
            ->mergeCells('E9:F9')
            ->mergeCells('G9:K9');

        $activeSheet->setCellValue('A9', 'S.N.')
            ->setCellValue('B9', 'Agent Code')
            ->setCellValue('C9', 'Agent Name')
            ->setCellValue('D9', 'Total Sub-Agents')
            ->setCellValue('E9', 'Amount in Agent Wallet')
            ->setCellValue('G9', 'Over The Counter Transaction Type - Amount In The Reporting Period ')
            ->setCellValue('E10', 'Previous Reporting Period Balance')
            ->setCellValue('F10', 'Current Reporting Period Balance')
            ->setCellValue('G10', 'Bill Payments Including TopUp')
            ->setCellValue('H10', 'P2P Transfer')
            ->setCellValue('I10', 'Cash In')
            ->setCellValue('J10', 'Others')
            ->setCellValue('K10', 'Total')
        ;

        $activeSheet->getStyle('A9:K10')->getFont()->setBold(1)->setSize(12);
        $totalCredit = 0;
        $totalDebit = 0;
        if ($agentReports) {
            $index = 11;
            $sn = 1;
            foreach ($agentReports as $agentReport) {
                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValueExplicit('B' . $index, $agentReport['agent_code'], DataType::TYPE_STRING);
//                $activeSheet->setCellValue('B' . $index, $agentReport['agent_code']);
                $activeSheet->setCellValue('C' . $index, $agentReport['agent_name']);
                $activeSheet->setCellValue('D' . $index, $agentReport['sub_agents']);
                $activeSheet->setCellValue('E' . $index, $agentReport['balance']);
                $activeSheet->setCellValue('F' . $index, $agentReport['balance']);
                $activeSheet->setCellValue('G' . $index, $agentReport['bill_payments']);
                $activeSheet->setCellValue('H' . $index, $agentReport['p2p']);
                $activeSheet->setCellValue('I' . $index, $agentReport['cash_in']);
                $activeSheet->setCellValue('J' . $index, $agentReport['others']);
                $activeSheet->setCellValue('K' . $index, $agentReport['total']);
                $index++;
            }
            $index++;
//            $activeSheet->mergeCells("A" . $index . ":" . "B" . $index);
//            $activeSheet->setCellValue("A" . $index, 'Grand Total');
//            $activeSheet->setCellValueExplicit('C' . $index, $totalCredit, DataType::TYPE_STRING);
//            $activeSheet->setCellValueExplicit('D' . $index, $totalDebit, DataType::TYPE_STRING);
            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->setCellValue('A' . $index, 'Report Generated for Date : ' . $request->from);
        }

        $activeSheet->getStyle('A9:K'.($index-2))
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:K'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "NRB Annex 10.1.11 Report for Date Range : " . $request->from ." to ".$request->to. ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    //NRB 22 part 4 Agent Report
    public function nrbEachAgentReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $agentReports = $nrbAnnex->eachAgentReport($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'Transaction Report of Agents';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->setCellValue('A9', 'S.N.')
            ->setCellValue('B9', 'Agent Code')
            ->setCellValue('C9', 'Agent Name')
            ->setCellValue('D9', 'Over the Counter Transaction Type')
            ->setCellValue('E9', 'Number of Transactions')
            ->setCellValue('F9', 'Amount (Rs.)');

        $activeSheet->getStyle('A9:F9')->getFont()->setBold(1)->setSize(12);
        $totalCredit = 0;
        $totalDebit = 0;
        if ($agentReports) {
            $index = 10;
            $sn = 1;
            foreach ($agentReports as $agentReport) {

                $activeSheet->mergeCells('A'.$index.":A".($index+6))
                            ->mergeCells('B'.$index.":B".($index+6))
                            ->mergeCells('C'.$index.":C".($index+6));

                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValueExplicit('B' . $index, $agentReport['agent_code'], DataType::TYPE_STRING);
                $activeSheet->setCellValue('C' . $index, $agentReport['agent_name']);

                $activeSheet->setCellValue('D' . $index, 'TOP-UP')
                            ->setCellValue('D' . ($index+1), 'TRANSFER TO WALLET')
                            ->setCellValue('D' . ($index+2), 'TRANSFER TO BANK')
                            ->setCellValue('D' . ($index+3), 'CASH IN')
                            ->setCellValue('D' . ($index+4), 'CASH OUT')
                            ->setCellValue('D' . ($index+5), 'MERCHANT PAYMENT')
                            ->setCellValue('D' . ($index+6), 'GOVERNMENT PAYMENT');

                $activeSheet->setCellValue('E' . $index, $agentReport['totalTopUpCount'])
                            ->setCellValue('E' . ($index+1), $agentReport['totalTransferToWalletCount'])
                            ->setCellValue('E' . ($index+2), $agentReport['totalTransferToBankCount'])
                            ->setCellValue('E' . ($index+3), $agentReport['totalCashInCount'])
                            ->setCellValue('E' . ($index+4), $agentReport['totalCashOutCount'])
                            ->setCellValue('E' . ($index+5), $agentReport['totalMerchantPaymentCount'])
                            ->setCellValue('E' . ($index+6), $agentReport['totalGovernmentPaymentCount']);

                $activeSheet->setCellValue('F' . $index, $agentReport['totalTopUpAmount'])
                            ->setCellValue('F' . ($index+1), $agentReport['totalTransferToWalletAmount'])
                            ->setCellValue('F' . ($index+2), $agentReport['totalTransferToBankAmount'])
                            ->setCellValue('F' . ($index+3), $agentReport['totalCashInAmount'])
                            ->setCellValue('F' . ($index+4), $agentReport['totalCashOutAmount'])
                            ->setCellValue('F' . ($index+5), $agentReport['totalMerchantPaymentAmount'])
                            ->setCellValue('F' . ($index+6), $agentReport['totalGovernmentPaymentAmount']);

                $index=$index+6;
                $index++;
            }
//            $activeSheet->mergeCells("A" . $index . ":" . "B" . $index);
//            $activeSheet->setCellValue("A" . $index, 'Grand Total');
//            $activeSheet->setCellValueExplicit('C' . $index, $totalCredit, DataType::TYPE_STRING);
//            $activeSheet->setCellValueExplicit('D' . $index, $totalDebit, DataType::TYPE_STRING);
            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->setCellValue('A' . $index, 'Report Generated for Date Range: ' . $request->from_date.' to '.$request->to_date);
        }

        $activeSheet->getStyle('A9:F'.($index-2))
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:F'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "NRB 22 Part 4 Report for Date Range : " . $request->from ." to ".$request->to. ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    //10.1.5 Agent Report
    public function nrbAnnexAgentReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $agentReports = $nrbAnnex->agentReport($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'NRB Annex 10.1.5 Agent Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->setCellValue('A9', 'S.N.')
            ->setCellValue('B9', 'Transaction Channel')
            ->setCellValue('C9', 'Form of Transaction')
            ->setCellValue('D9', 'Count')
            ->setCellValue('E9', 'Total Amount')
        ;

        $activeSheet->getStyle('A9:E9')->getFont()->setBold(1)->setSize(12);

        if ($agentReports) {
            $index = 10;
            $sn = 1;
            foreach ($agentReports as $title=>$agentReport) {
                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValue('B' . $index, 'Agent/Sub-Agent');
                $activeSheet->setCellValue('C' . $index, $title);
                $activeSheet->setCellValue('D' . $index, $agentReport['number']);
                $activeSheet->setCellValue('E' . $index, $agentReport['value']);
                $index++;
            }

            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->mergeCells("A" . ($index+1) . ":" . "D" . ($index+1));

            $activeSheet->setCellValue('A' . $index, 'Report Generated for Amount Range : ' . $request->from_amount.'-'.$request->to_amount);
            $activeSheet->setCellValue('A' . ($index+1), 'Report Generated as of date : ' . $request->from. ' to '.$request->to);
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getAlignment()->setHorizontal('center')->setVertical('center');
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getFont()->setSize(12);
        }

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "NRB Annex 10.1.5 Agent Report for Date Range : " . $request->from ." to ".$request->to. ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    //10.1.5 Customer Report
    public function nrbAnnexCustomerReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $customerReports = $nrbAnnex->customerReport($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'NRB Annex 10.1.5 Customer Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->setCellValue('A9', 'S.N.')
            ->setCellValue('B9', 'Transaction Channel')
            ->setCellValue('C9', 'Form of Transaction')
            ->setCellValue('D9', 'Count')
            ->setCellValue('E9', 'Total Amount')
        ;

        $activeSheet->getStyle('A9:E9')->getFont()->setBold(1)->setSize(12);

        if ($customerReports) {
            $index = 10;
            $sn = 1;
            foreach ($customerReports as $title=>$customerReport) {
                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValue('B' . $index, 'Initiated Customer');
                $activeSheet->setCellValue('C' . $index, $title);
                $activeSheet->setCellValue('D' . $index, $customerReport['number']);
                $activeSheet->setCellValue('E' . $index, $customerReport['value']);
                $index++;
            }

            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);
            $activeSheet->mergeCells("A" . ($index+1) . ":" . "D" . ($index+1));

            $activeSheet->setCellValue('A' . $index, 'Report Generated for Amount Range : ' . $request->from_amount.'-'.$request->to_amount);
            $activeSheet->setCellValue('A' . ($index+1), 'Report Generated as of date : ' . $request->from. ' to '.$request->to);
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getAlignment()->setHorizontal('center')->setVertical('center');
            $activeSheet->getStyle('A' . $index.':B'.($index+1))->getFont()->setSize(12);
        }

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "NRB Annex 10.1.5 Customer Report for Date Range : " . $request->from ." to ".$request->to. ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }

    //10.1.6 Report
    public function nrbAnnexPaymentReport(Request $request)
    {
        $nrbAnnex = new NRBAnnexReportController();
        $request = $request->merge(['forExcel' => 'TRUE']);
        $annexReports = $nrbAnnex->merchantReport($request);

        $spreadsheet = new Spreadsheet();
        $reportTitle = 'NRB Annex 10.1.6 Report';

        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();

        $helper = new PhpSpreadSheetExportHelper();
        $index = 0;
        $activeSheet = $helper->setLogo($activeSheet, $index);
        $activeSheet = $helper->setTitle($activeSheet, $reportTitle, $index);
//        $activeSheet = $helper->setFilteredOptions($activeSheet, $request);

        $activeSheet->mergeCells("D9:E9")
                    ->mergeCells("A9:A10")
                    ->mergeCells("C9:C10")
                    ->mergeCells("B9:B10");

        $activeSheet->setCellValue('A9', 'S.N.')
            ->setCellValue('B9', 'Particulars')
            ->setCellValue('C9', 'Form of Transaction')
            ->setCellValue('D9', 'Count')
            ->setCellValue('D10', 'Successful')
            ->setCellValue('E10', 'Failed')
        ;

        $activeSheet->getStyle('A9:E10')->getFont()->setBold(1)->setSize(12);
        if ($annexReports) {
            $index = 11;
            $sn = 1;
            foreach ($annexReports as $title=>$report) {
                $activeSheet->setCellValue('A' . $index, $sn++);
                $activeSheet->setCellValue('C' . $index, $title);
                $activeSheet->setCellValue('D' . $index, $report['successful']);
                $activeSheet->setCellValue('E' . $index, $report['failed']);
                $index++;
            }

            $index++;
            $activeSheet->mergeCells("A" . $index . ":" . "D" . $index);

            $activeSheet->setCellValue('A' . $index, 'Report Generated as of date : ' . $request->from. ' to '.$request->to);
            $activeSheet->getStyle('A' . $index.':B'.$index)->getAlignment()->setHorizontal('center')->setVertical('center');
            $activeSheet->getStyle('A' . $index.':B'.$index)->getFont()->setSize(12);
        }

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('090a0a'));

        $activeSheet->getStyle('A9:E'.($index-2))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->setColor(new Color('090a0a'));

        foreach ($activeSheet->getColumnIterator() as $column) {
            $activeSheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $filename = "NRB Annex 10.1.6 Report for Date Range : " . $request->from ." to ".$request->to. ".xlsx";

        $helper->exportToExcel($spreadsheet, $filename);
    }
}
