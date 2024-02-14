<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RequestInfo;
use Illuminate\Support\Facades\View;

class SeederController extends Controller
{
    public function index(){
        $seederFileName = scandir(database_path('seeds'));
        return view('admin.seeder',compact('seederFileName'));
    }

    public function runSeeder($className){
        $seederFileName = scandir(database_path('seeds'));
        if(!in_array($className.'.php',$seederFileName)){
            return redirect()->route('view.seeder')->with('error','Seeder class not found');
        }
        //uncomment below line if you face error like STDIN not defined
//        define('STDIN',fopen("php://stdin","r"));
        $status = \Artisan::call('db:seed',['--class' => $className,'--force'=>true]);
        if($status == 0){
            return redirect()->route('view.seeder')->with('success',$className." successfully executed");
        }else{
            return redirect()->route('view.seeder')->with('error',"Didnt executed successfully please try again later");
        }
    }

}
