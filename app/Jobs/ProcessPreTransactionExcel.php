<?php

namespace App\Jobs;

use App\Models\ReportFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Queue\SerializesModels;
use App\Functions\Excel\ExportExcelHelper;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Writer\Style\StyleBuilder;
use Illuminate\Queue\InteractsWithQueue;
use OpenSpout\Common\Entity\Style\Style;
use App\Models\Microservice\PreTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Http\FormRequest;
use App\Functions\Excel\Interfaces\IExportExcel;
use App\Http\Resources\PreTransactionResource;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessPreTransactionExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $request;
    private $create_report;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $create_report)
    {
        $this->request = $request;
        $this->create_report = $create_report;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Report", [$this->create_report]);
        $form_request = FormRequest::create('', '', $this->request);
        $export = new ExportExcelHelper();
        $export->setName('pre_transactions')
            ->setGeneratorModel(PreTransaction::class)
            ->setResource(PreTransactionResource::class)
            ->setRequest($form_request);

        $exportedFile = $export->exportJobExcel();
        $formattedString  = str_replace("/var/www/html/public", "", $exportedFile);
        // $formattedString = "complete/" . basename($exportedFile);
        Storage::put($formattedString, file_get_contents($exportedFile));
        ReportFile::where('id', $this->create_report->id)->update(['file' => $formattedString]);
        Log::info("Exported File", [$exportedFile]);
        unlink($exportedFile);
        // return $formattedString;
    }
}
