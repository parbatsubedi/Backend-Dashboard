<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendHeader;
use App\Traits\UploadImage;
use App\Wallet\WalletAPI\Microservice\UploadImageToCoreMicroservice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class HeaderController extends Controller
{
    use UploadImage;
    private $disk = "public";

    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:Frontend header view|Frontend header update|Frontend header create');
    }

    public function index(Request $request)
    {
        $header = FrontendHeader::where('belongs_to',strtolower(config('app.'.'name')))->first();

        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);


//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }
//
//            if ($request->hasFile('google_image')) {
//                $data['google_image'] = $this->uploadImage(['google_image' => $request->file('google_image')], 'google_image', 'app/public/uploads/frontend/');
//            }
//
//            if ($request->hasFile('apple_image')) {
//                $data['apple_image'] = $this->uploadImage(['apple_image' => $request->file('apple_image')], 'apple_image', 'app/public/uploads/frontend/');
//            }

            if (empty($header)) {
                $data = ["header_image" => null, "title" => "123"];
                FrontendHeader::create($responseData);
                $header = FrontendHeader::where('belongs_to',strtolower(config('app.'.'name')))->first();
            }
            FrontendHeader::where('id', $header->id)->update($responseData);

            return redirect()->route('frontend.header')->with(compact('header'));
        }

        return view('admin.frontend.header.index')->with(compact('header'));
    }

    public function MultipleHeadersIndex(){
        $headers = FrontendHeader::where('belongs_to',strtolower(config('app.'.'name')))->latest()->paginate(10);
        return view('admin.frontend.header.multipleHeaderIndex')->with(compact('headers'));
    }

    public function create(){
        return view('admin.frontend.header.CreateHeader');
    }

    public function store(Request $request){
        $data = Arr::except($request->all(), '_token');
        $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
        $status = FrontendHeader::create($responseData);

        if ($status){
            return redirect()->route('frontend.multipleHeader')->with('success','Header Created Successfully');
        }
        else{
            return redirect()->route('frontend.multipleHeader')->with('error','Header Could not be created please try again');
        }
    }

    public function edit($id){
        $header = FrontendHeader::find($id);
        return view('admin.frontend.header.EditHeader')->with(compact('header'));
    }

    public function update($id,Request $request){
        $data = Arr::except($request->all(), '_token');
        $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
        $status = FrontendHeader::where('id', $id)->update($responseData);
        if ($status){
            return redirect()->route('frontend.multipleHeader')->with('success','Header Updated Successfully');
        }
        else{
            return redirect()->route('frontend.multipleHeader')->with('error','Header could not be edited please try again');
        }
    }

    public function delete(Request $request)
    {
        $setting = FrontendHeader::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.multipleHeader')->with('success', 'Data successfully Deleted');
    }


}
