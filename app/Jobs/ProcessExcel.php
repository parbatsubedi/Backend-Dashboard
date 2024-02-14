<?php

namespace App\Jobs;

use App\Models\ReportFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Models\TransactionEvent;
use App\Http\Resources\TransactionEventResource;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Queue\SerializesModels;
use App\Functions\Excel\ExportExcelHelper;
use Illuminate\Support\Facades\Storage;
use Box\Spout\Writer\Style\StyleBuilder;
use Illuminate\Queue\InteractsWithQueue;
use OpenSpout\Common\Entity\Style\Style;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Http\FormRequest;
use App\Functions\Excel\Interfaces\IExportExcel;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // private $name;

    // private $resource; //Resource class

    // private $request;

    // private $generatorModel; //Eloquent Model

    // private $mixGeneratorModels;

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

    // private function generatorCollection()
    // {
    //     if ($this->generatorModel == TransactionEvent::class) {
    //         foreach ($this->generatorModel::latest()->whereNull("refund_id")->with('neaTransaction')->filter($this->request)->cursor() as $model) {
    //             yield $model;
    //         }
    //     } else {
    //         foreach ($this->generatorModel::latest()->filter($this->request)->cursor() as $model) {
    //             yield $model;
    //         }
    //     }
    // }

    // private function headerStyle()
    // {
    //     if (strtolower(config("app.name")) == "paywell") {
    //         return (new Style())
    //             ->setFontBold();
    //     }

    //     return (new StyleBuilder())
    //         ->setFontBold()
    //         /*->setBackgroundColor(Color::ORANGE)*/
    //         ->build();
    // }

    // private function excelName($name)
    // {
    //     return $name . '-' . now() . '.xlsx';
    // }


    // public function exportExcel()
    // {
    //     return (new FastExcel($this->generatorCollection()))->headerStyle($this->headerStyle())->download($this->excelName($this->name), function ($value) {
    //         return (new $this->resource($value));
    //     });
    // }


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
        $export->setName('complete_transactions')
            ->setGeneratorModel(TransactionEvent::class)
            ->setResource(TransactionEventResource::class)
            ->setRequest($form_request);

        $exportedFile = $export->exportJobExcel();
        if(strtolower(config('app.name')) == "paywell"){
            $formattedString  = str_replace("/var/www/html/public", "", $exportedFile);
        }elseif (strtolower(config('app.name')) == "parbat"){
            $formattedString  = str_replace("/var/www/html/", "", $exportedFile);
        }else{
            $formattedString  = str_replace("/var/www/html/", "", $exportedFile);
        }

        //$formattedString = "complete/" . basename($exportedFile);
        Storage::put($formattedString, file_get_contents($exportedFile));
        ReportFile::where('id', $this->create_report->id)->update(['file' => $formattedString]);
        Log::info("Exported File", [$exportedFile]);
        unlink($exportedFile);
        // return $formattedString;
    }
}
