<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendService;
use App\Models\GeneralSetting;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class ServiceController extends Controller
{

    use UploadImage;
    private $disk = "public";

    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:Frontend service view')->only('index');
        $this->middleware('permission:Frontend service create')->only('create');
        $this->middleware('permission:Frontend service update')->only('update');
        $this->middleware('permission:Frontend service delete')->only('delete');
    }

    public function index()
    {
        $services = FrontendService::where('belongs_to',strtolower(config('app.'.'name')))->latest()->get();
        return view('admin.frontend.service.index')->with(compact('services'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = Arr::except($request->all(), '_token');

            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);

//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendService::create($responseData);

            return redirect()->route('frontend.service.index')->with('success', 'Service created successfully');

        }

        return view('admin.frontend.service.create');
    }

    public function update(Request $request, $id)
    {
        $service = FrontendService::whereId($id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);

//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendService::whereId($id)->update($responseData);

            return redirect()->route('frontend.service.index')->with('success', "Update Successful");
        }
        return view('admin.frontend.service.update')->with(compact('service'));
    }

    public function delete(Request $request)
    {
        $setting = FrontendService::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.service.index')->with('success', 'Data successfully Deleted');
    }
}
